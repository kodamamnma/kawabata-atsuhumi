<?php
/**
 * 鹿児島地域交通通信社 WordPress テーマ functions
 */

function kawabata_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
}
add_action( 'after_setup_theme', 'kawabata_setup' );

function kawabata_enqueue() {
    // Google Fonts
    wp_enqueue_style(
        'kawabata-fonts',
        'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&family=Noto+Serif+JP:wght@400;700&display=swap',
        [],
        null
    );

    // テーマのスタイルシート
    wp_enqueue_style( 'kawabata-style', get_stylesheet_uri(), [ 'kawabata-fonts' ], '1.0.1' );

    // React 18.3.1（headに配置）
    wp_enqueue_script(
        'kawabata-react',
        'https://unpkg.com/react@18.3.1/umd/react.development.js',
        [],
        null,
        false
    );

    // ReactDOM 18.3.1
    wp_enqueue_script(
        'kawabata-react-dom',
        'https://unpkg.com/react-dom@18.3.1/umd/react-dom.development.js',
        [ 'kawabata-react' ],
        null,
        false
    );

    // Babel Standalone 7.29.0
    wp_enqueue_script(
        'kawabata-babel',
        'https://unpkg.com/@babel/standalone@7.29.0/babel.min.js',
        [],
        null,
        false
    );

    // WordPress の投稿データを JS に渡す
    $articles = kawabata_get_articles();
    wp_add_inline_script(
        'kawabata-babel',
        'var WP_ARTICLES = ' . wp_json_encode( $articles ?: [] ) . ';',
        'after'
    );
}
add_action( 'wp_enqueue_scripts', 'kawabata_enqueue' );

// CDN スクリプトに SRI integrity 属性を付与
add_filter( 'script_loader_tag', function ( $tag, $handle ) {
    $integrity_map = [
        'kawabata-react'     => 'sha384-hD6/rw4ppMLGNu3tX5cjIb+uRZ7UkRJ6BPkLpg4hAu/6onKUg4lLsHAs9EBPT82L',
        'kawabata-react-dom' => 'sha384-u6aeetuaXnQ38mYT8rp6sbXaQe3NL9t+IBXmnYxwkUI2Hw4bsp2Wvmx4yRQF1uAm',
        'kawabata-babel'     => 'sha384-m08KidiNqLdpJqLq95G/LEi8Qvjl/xUYll3QILypMoQ65QorJ9Lvtp2RXYGBFj1y',
    ];
    if ( isset( $integrity_map[ $handle ] ) ) {
        $tag = preg_replace(
            '/(<script\b[^>]*?) src=/i',
            '$1 integrity="' . $integrity_map[ $handle ] . '" crossorigin="anonymous" src=',
            $tag,
            1
        );
    }
    return $tag;
}, 10, 2 );

/**
 * WordPress 投稿を記事配列（JS 用 JSON）として返す。
 */
function kawabata_get_articles() {
    $posts = get_posts( [
        'numberposts' => 50,
        'post_status' => 'publish',
        'orderby'     => 'date',
        'order'       => 'DESC',
    ] );

    if ( empty( $posts ) ) {
        return [];
    }

    $valid_cats = [ '鉄道', '航空', '船舶', 'バス', '地域話題', '鹿児島のイベント' ];
    $tones      = [ 'a', 'b', 'c', 'd', 'e', 'f' ];
    $articles   = [];

    foreach ( $posts as $i => $post ) {
        $terms = wp_get_post_terms( $post->ID, 'category', [ 'fields' => 'names' ] );
        $cat   = 'その他';
        // 優先順位を考慮してカテゴリを決定（より具体的なカテゴリを優先）
        $priority_cats = [ '鉄道', '航空', '船舶', 'バス', '鹿児島のイベント', '地域話題' ];
        foreach ( $priority_cats as $priority_cat ) {
            if ( in_array( $priority_cat, $terms, true ) ) {
                $cat = $priority_cat;
                break;
            }
        }

        $thumb = get_the_post_thumbnail_url( $post->ID, 'medium' ) ?: null;

        $excerpt = has_excerpt( $post->ID )
            ? strip_tags( get_the_excerpt( $post ) )
            : wp_trim_words( strip_tags( $post->post_content ), 60, '' );

        $badge = get_post_meta( $post->ID, 'kawabata_badge', true ) ?: null;

        $articles[] = [
            'cat'     => $cat,
            'title'   => $post->post_title,
            'time'    => mysql2date( 'n月j日 H:i', $post->post_date ),
            'tone'    => $tones[ $i % 6 ],
            'badge'   => $badge,
            'summary' => $excerpt ?: null,
            'src'     => $thumb,
            'href'    => get_permalink( $post->ID ),
        ];
    }

    return $articles;
}

/**
 * 個別記事ページ用に ARTICLE_DATA を JavaScript に渡す。
 */
function kawabata_single_article_data() {
    if ( is_single() ) {
        global $post;
        $terms = wp_get_post_terms( $post->ID, 'category', [ 'fields' => 'names' ] );
        $cat   = 'その他';
        // 優先順位を考慮してカテゴリを決定（より具体的なカテゴリを優先）
        $priority_cats = [ '鉄道', '航空', '船舶', 'バス', '鹿児島のイベント', '地域話題' ];
        foreach ( $priority_cats as $priority_cat ) {
            if ( in_array( $priority_cat, $terms, true ) ) {
                $cat = $priority_cat;
                break;
            }
        }

        $article = [
            'cat'       => $cat,
            'title'     => get_the_title(),
            'published' => get_the_date( 'Y年n月j日 H:i' ),
            'updated'   => get_the_modified_date( 'Y年n月j日 H:i' ),
            'author'    => get_the_author(),
            'tags'      => wp_get_post_tags( $post->ID, [ 'fields' => 'names' ] ),
            'src'       => get_the_post_thumbnail_url( $post->ID, 'large' ) ?: null,
            'caption'   => get_post( get_post_thumbnail_id() ) ? get_post( get_post_thumbnail_id() )->post_excerpt : '',
            'content'   => apply_filters( 'the_content', $post->post_content ),
            'badge'     => get_post_meta( $post->ID, 'kawabata_badge', true ) ?: null,
        ];
        wp_add_inline_script(
            'kawabata-babel',
            'var ARTICLE_DATA = ' . wp_json_encode( $article ) . ';',
            'after'
        );
    }
}
add_action( 'wp_enqueue_scripts', 'kawabata_single_article_data' );
