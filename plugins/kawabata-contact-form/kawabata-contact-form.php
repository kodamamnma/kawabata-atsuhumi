<?php
/**
 * Plugin Name: 鹿児島地域交通通信社 お問い合わせフォーム
 * Description: テーマの /contact/ フォームから送られた内容を受け取り、管理画面「お問い合わせ」に保存してメールで通知します。
 * Version: 1.0.0
 * Author: 鹿児島地域交通通信社
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'KCF_RECIPIENT', 'info@kagoshima-news.jp' );

/** ご用件の選択肢（キーはGA4の inquiry_type にもそのまま使う） */
function kcf_types() {
    return [
        'tip'      => '情報提供',
        'coverage' => '取材・掲載のご依頼',
        'usage'    => '写真・記事の利用',
        'ad'       => '広告・タイアップのご相談',
        'feedback' => '記事へのご意見・ご感想',
        'other'    => 'その他',
    ];
}

/* ─── 受信内容の保存先（メールが届かなくても管理画面で読めるようにするため） ─── */
add_action( 'init', function () {
    register_post_type( 'kcf_inquiry', [
        'labels'          => [
            'name'          => 'お問い合わせ',
            'singular_name' => 'お問い合わせ',
            'menu_name'     => 'お問い合わせ',
            'all_items'     => '受信一覧',
            'edit_item'     => 'お問い合わせの内容',
        ],
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'show_in_rest'    => false,
        'menu_position'   => 25,
        'menu_icon'       => 'dashicons-email-alt',
        'supports'        => [ 'title', 'editor' ],
        'capability_type' => 'post',
        // 管理画面から手で新規作成させない（受信専用）
        'capabilities'    => [ 'create_posts' => 'do_not_allow' ],
        'map_meta_cap'    => true,
    ] );
} );

/* ─── 管理画面の一覧に用件・連絡先・メール送信結果を出す ─── */
add_filter( 'manage_kcf_inquiry_posts_columns', function ( $columns ) {
    return [
        'cb'         => $columns['cb'],
        'title'      => '件名',
        'kcf_type'   => 'ご用件',
        'kcf_email'  => 'メールアドレス',
        'kcf_mailed' => '通知メール',
        'date'       => '受信日時',
    ];
} );

add_action( 'manage_kcf_inquiry_posts_custom_column', function ( $column, $post_id ) {
    if ( 'kcf_type' === $column ) {
        echo esc_html( get_post_meta( $post_id, '_kcf_type_label', true ) );
    } elseif ( 'kcf_email' === $column ) {
        $email = get_post_meta( $post_id, '_kcf_email', true );
        echo '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>';
    } elseif ( 'kcf_mailed' === $column ) {
        echo get_post_meta( $post_id, '_kcf_mailed', true ) ? '送信済み' : '<strong style="color:#b32d2e">送信失敗</strong>';
    }
}, 10, 2 );

/* ─── 受信用エンドポイント: POST /wp-json/kawabata/v1/contact ─── */
add_action( 'rest_api_init', function () {
    register_rest_route( 'kawabata/v1', '/contact', [
        'methods'             => 'POST',
        'callback'            => 'kcf_handle_submit',
        'permission_callback' => '__return_true',
    ] );
} );

function kcf_client_ip() {
    // サーバーがプロキシ配下（X-Forwarded-Proto判定あり）のため、転送元IPを優先する
    if ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
        $parts = explode( ',', wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) );
        return trim( $parts[0] );
    }
    return isset( $_SERVER['REMOTE_ADDR'] ) ? wp_unslash( $_SERVER['REMOTE_ADDR'] ) : '';
}

function kcf_handle_submit( WP_REST_Request $request ) {
    $p = $request->get_json_params();
    if ( ! is_array( $p ) ) {
        $p = $request->get_body_params();
    }

    // 人には見えない欄に入力がある／表示から3秒未満の送信はボットとみなし、保存せず成功を装う
    $started = isset( $p['started'] ) ? (int) $p['started'] : 0;
    if ( ! empty( $p['website'] ) || ( $started > 0 && ( time() * 1000 - $started ) < 3000 ) ) {
        return [ 'ok' => true ];
    }

    $rl_key = 'kcf_rl_' . md5( kcf_client_ip() );
    $count  = (int) get_transient( $rl_key );
    if ( $count >= 10 ) {
        return new WP_Error( 'kcf_rate_limited', '短時間に送信が続いたため受け付けを止めています。10分ほどおいて再度お試しください。', [ 'status' => 429 ] );
    }

    $types = kcf_types();
    $type  = isset( $p['inquiry_type'] ) ? sanitize_key( $p['inquiry_type'] ) : '';
    $name  = isset( $p['name'] ) ? sanitize_text_field( $p['name'] ) : '';
    $org   = isset( $p['org'] ) ? sanitize_text_field( $p['org'] ) : '';
    $email = isset( $p['email'] ) ? sanitize_email( $p['email'] ) : '';
    $msg   = isset( $p['message'] ) ? sanitize_textarea_field( $p['message'] ) : '';
    $url   = isset( $p['url'] ) ? esc_url_raw( trim( $p['url'] ) ) : '';

    $errors = [];
    if ( ! isset( $types[ $type ] ) ) {
        $errors[] = 'ご用件を選んでください。';
    }
    if ( '' === $name || mb_strlen( $name ) > 100 ) {
        $errors[] = 'お名前を100文字以内で入力してください。';
    }
    if ( ! is_email( $email ) ) {
        $errors[] = 'メールアドレスの形式を確認してください。';
    }
    if ( '' === $msg || mb_strlen( $msg ) > 5000 ) {
        $errors[] = 'ご用件の詳細を5000文字以内で入力してください。';
    }
    if ( mb_strlen( $org ) > 200 || mb_strlen( $url ) > 500 ) {
        $errors[] = '会社・団体名または関連資料のURLが長すぎます。';
    }
    if ( $errors ) {
        return new WP_Error( 'kcf_invalid', implode( "\n", $errors ), [ 'status' => 400 ] );
    }

    set_transient( $rl_key, $count + 1, 10 * MINUTE_IN_SECONDS );

    $label   = $types[ $type ];
    $post_id = wp_insert_post( [
        'post_type'    => 'kcf_inquiry',
        'post_status'  => 'private',
        'post_title'   => '【' . $label . '】' . $name . ( $org ? '（' . $org . '）' : '' ),
        'post_content' => $msg,
    ], true );

    if ( is_wp_error( $post_id ) ) {
        return new WP_Error( 'kcf_save_failed', '送信内容を保存できませんでした。時間をおいて再度お試しください。', [ 'status' => 500 ] );
    }

    update_post_meta( $post_id, '_kcf_type', $type );
    update_post_meta( $post_id, '_kcf_type_label', $label );
    update_post_meta( $post_id, '_kcf_name', $name );
    update_post_meta( $post_id, '_kcf_org', $org );
    update_post_meta( $post_id, '_kcf_email', $email );
    update_post_meta( $post_id, '_kcf_url', $url );

    $body = implode( "\n", [
        'お問い合わせフォームから送信がありました。',
        '',
        'ご用件：' . $label,
        'お名前：' . $name,
        '会社・団体名：' . ( $org ?: '（なし）' ),
        'メールアドレス：' . $email,
        '関連資料のURL：' . ( $url ?: '（なし）' ),
        '',
        '―― ご用件の詳細 ――',
        $msg,
        '',
        '――',
        '管理画面で確認：' . admin_url( 'post.php?post=' . $post_id . '&action=edit' ),
        'このメールに返信すると、送信者に直接届きます。',
    ] );

    $mailed = wp_mail(
        apply_filters( 'kcf_recipient', KCF_RECIPIENT ),
        '【お問い合わせ】' . $label . '／' . $name,
        $body,
        [ 'Reply-To: ' . $email ]
    );
    update_post_meta( $post_id, '_kcf_mailed', $mailed ? 1 : 0 );

    // 通知メールが失敗しても内容は保存済みのため、送信者には成功として返す
    return [ 'ok' => true ];
}

/* ─── 編集画面で連絡先などを読めるようにする ─── */
add_action( 'add_meta_boxes_kcf_inquiry', function () {
    add_meta_box( 'kcf_detail', '送信者の情報', function ( $post ) {
        $rows = [
            'ご用件'         => get_post_meta( $post->ID, '_kcf_type_label', true ),
            'お名前'         => get_post_meta( $post->ID, '_kcf_name', true ),
            '会社・団体名'   => get_post_meta( $post->ID, '_kcf_org', true ),
            'メールアドレス' => get_post_meta( $post->ID, '_kcf_email', true ),
            '関連資料のURL'  => get_post_meta( $post->ID, '_kcf_url', true ),
            '通知メール'     => get_post_meta( $post->ID, '_kcf_mailed', true ) ? '送信済み' : '送信失敗（サーバーのメール設定を確認してください）',
        ];
        echo '<table class="widefat striped"><tbody>';
        foreach ( $rows as $k => $v ) {
            echo '<tr><th style="width:140px">' . esc_html( $k ) . '</th><td>' . esc_html( $v ?: '—' ) . '</td></tr>';
        }
        echo '</tbody></table>';
    }, 'kcf_inquiry', 'normal', 'high' );
} );
