kawabata-wp-theme/
├── style.css                    # テーマ情報
├── functions.php                # WordPress設定・関数
│
├── header.php                   # 共通ヘッダー（最小限）
├── footer.php                   # 共通フッター（最小限）
├── sidebar.php                  # サイドバーコンポーネント
│
├── index.php                    # トップページ・記事一覧
├── single.php                   # 個別記事ページ
├── archive.php                  # カテゴリ・タグアーカイブ
├── page.php                     # 固定ページ（デフォルト）
│
├── page-about.php               # 「当社について」ページ
├── page-contact.php             # 「お問い合わせ」ページ
├── page-privacy.php             # 「プライバシーポリシー」ページ
│
├── 404.php                      # 404エラーページ
│
├── images/                      # 画像フォルダ
│   ├── corporate.jpg
│   └── editor.jpg
│
└── README.md                    # テーマ説明文書

以下のプロンプトを使用してください。各ファイルごとに分けて実行することを推奨します。

---

## 1. sidebar.php 作成プロンプト

```
# sidebar.php 作成タスク

## 目的
`kawabata-wp-theme/sidebar.php` を作成する。元となるのは各HTMLファイル内の `Sidebar` コンポーネント。

## 元ファイル
- `index.html`
- `about.html`
- `article.html`
- `articles.html`

これらのファイルに共通して存在する `Sidebar` コンポーネント（または類似のサイドバー関連コード）を抽出する。

## 抽出対象コード
以下の要素を含む `Sidebar` コンポーネント全体:
- 「当社について」セクション（会社画像、説明文、リンク）
- 「公式SNS・メディア」セクション（X, Instagram, TikTok）
- 「お問い合わせ」セクション（メールアドレス）

HTMLファイル内の該当箇所:
```jsx
const Sidebar = () => (
  <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
    {/* 当社について */}
    <div style={{ background: C.white, ... }}>
      ...
    </div>
    {/* SNS */}
    <div style={{ background: C.white, ... }}>
      ...
    </div>
    {/* お問い合わせ */}
    <div style={{ background: C.main, ... }}>
      ...
    </div>
  </div>
);
```

## WordPress固有の置き換え

### 画像パス
```javascript
// 置き換え前
const IMGS = {
  corporate: WIX + '5c3d68_37f490f2219240859901a9958b0c1d92~mv2.jpg/...',
};

// 置き換え後
const IMGS = {
  corporate: '<?php echo get_template_directory_uri(); ?>/images/corporate.jpg',
};
```

### リンク
```javascript
// 置き換え前
<a href="about.html">概要案内を読む →</a>

// 置き換え後
<a href="<?php echo get_permalink(get_page_by_path('about')); ?>">概要案内を読む →</a>
```

### ホームURL
```javascript
// 置き換え前
<a href="index.html">記事一覧を見る →</a>

// 置き換え後
<a href="<?php echo home_url('/'); ?>">記事一覧を見る →</a>
```

## ファイル構造テンプレート

```php
<?php
/**
 * サイドバーテンプレート
 * 
 * @package kawabata
 */
?>

<script type="text/babel">
// ========================================
// カラートークン（既にheader.phpで定義されている想定）
// グローバル変数 C が利用可能
// ========================================

// ========================================
// サイドバーコンポーネント
// ========================================
const SidebarWidget = () => {
  // 画像パス
  const IMGS = {
    corporate: '<?php echo get_template_directory_uri(); ?>/images/corporate.jpg',
  };

  // サブヘッダーコンポーネント
  const SideHead = ({ children, color = C.main }) => (
    <div style={{ background: color, color: '#fff', padding: '10px 14px', fontSize: 13, fontWeight: 700 }}>
      {children}
    </div>
  );

  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
      
      {/* ここに index.html の Sidebar コンポーネント内容を貼り付け */}
      {/* WordPress固有の置き換えを適用 */}
      
    </div>
  );
};

// サイドバーをレンダリング
if (document.getElementById('sidebar-root')) {
  ReactDOM.createRoot(document.getElementById('sidebar-root')).render(<SidebarWidget />);
}
</script>

<!-- マウントポイント -->
<div id="sidebar-root"></div>
```

## 実行手順

1. `index.html` から `Sidebar` コンポーネントの全コードをコピー
2. 上記テンプレートの `{/* ここに... */}` 部分に貼り付け
3. WordPress固有の置き換えを実行
4. 完成した `sidebar.php` の全文を出力

## 注意事項
- **省略禁止**: `// ... 省略 ...` などは使わず、全コードを記述
- **コンポーネント依存**: `Img` コンポーネントなど他の依存コンポーネントも必要なら含める
- **グローバル変数**: `C`（カラートークン）は既に定義されている前提
```

---

## 2. single.php 作成プロンプト

```
# single.php 作成タスク

## 目的
`kawabata-wp-theme/single.php` を作成する。元となるのは `article.html`。

## 元ファイル
- `article.html`

このファイルに含まれる記事詳細ページのReactコード全体を抽出する。

## 抽出対象コード

### メインコンポーネント
- `App()` 関数（記事ページのメインコンポーネント）
- 記事データ構造 `ARTICLE`
- 関連記事 `RELATED` または `RELATED_ARTICLES`
- シェアボタン `ShareBar`
- 関連記事セクション `RelatedArticles`

### ユーティリティコンポーネント
- `Header`
- `MobileMenu`
- `Footer`
- `Sidebar`（または `<?php get_sidebar(); ?>` で置き換え）
- `Img`, `Badge` 等

## WordPress固有の置き換え

### 記事データの取得
```javascript
// 置き換え前
const ARTICLE = {
  cat: '鉄道',
  badge: '独自',
  title: '観光列車「おれんじ食堂」、指宿枕崎線・枕崎駅へ初乗り入れ...',
  published: '2026年4月26日 18:30',
  ...
};

// 置き換え後
const ARTICLE = (typeof ARTICLE_DATA !== 'undefined') ? ARTICLE_DATA : {
  cat: '鉄道',
  title: '記事タイトル',
  published: '',
  content: '',
  ...
};
```

### パンくずリスト
```javascript
// 置き換え前
<a href="index.html" style={{ color: C.sub }}>トップ</a>

// 置き換え後
<a href="<?php echo home_url('/'); ?>" style={{ color: C.sub }}>トップ</a>
```

### 記事本文の表示
```javascript
// 置き換え前
<div className="article-body">
  {/* 静的HTML */}
</div>

// 置き換え後
<div className="article-body" 
     dangerouslySetInnerHTML={{ __html: ARTICLE.content }} />
```

### サイドバー
```javascript
// 置き換え前
<Sidebar />

// 置き換え後（sidebar.phpを使う場合）
直接PHPを埋め込む:
<aside className="sidebar-content">
  <?php get_sidebar(); ?>
</aside>
```

## ファイル構造テンプレート

```php
<?php
/**
 * 個別記事ページテンプレート
 * 
 * @package kawabata
 */
get_header();
?>

<!-- 記事本文用スタイル -->
<style>
.article-body p { font-size: 15px; line-height: 2.0; color: #1a2940; margin-bottom: 20px; }
.article-body h2 { font-family: 'Noto Serif JP', serif; font-size: 19px; ... }
/* article.html の <style> セクション内の .article-body 関連CSSをすべてコピー */
</style>

<div id="root"></div>

<script type="text/babel">
const { useState, useEffect } = React;

// ========================================
// カラートークン
// ========================================
const C = { /* index.html と同じ */ };
const CAT_COLORS = { /* index.html と同じ */ };

// ========================================
// WordPress から渡される記事データ
// ========================================
const ARTICLE = (typeof ARTICLE_DATA !== 'undefined') ? ARTICLE_DATA : {
  cat: '鉄道',
  badge: null,
  title: '記事タイトル',
  published: '',
  updated: '',
  author: '',
  tags: [],
  src: null,
  caption: '',
  content: '',
};

// ========================================
// ユーティリティコンポーネント
// ========================================
// article.html から以下をコピー:
// - Img
// - Badge
// - ShareBar
// - RelatedArticles
// - Header
// - MobileMenu
// - Footer

// ========================================
// メインコンポーネント
// ========================================
function App() {
  const [menuOpen, setMenuOpen] = useState(false);
  const pageUrl = window.location.href;

  return (
    <div>
      <Header menuOpen={menuOpen} setMenuOpen={setMenuOpen} />
      <MobileMenu open={menuOpen} onClose={() => setMenuOpen(false)} />

      {/* パンくずリスト */}
      <div style={{ background: C.white, borderBottom: `1px solid ${C.border}` }}>
        <div style={{ maxWidth: 1160, margin: '0 auto', padding: '8px 16px', ... }}>
          <a href="<?php echo home_url('/'); ?>" style={{ color: C.sub }}>トップ</a>
          <span>›</span>
          <a href="<?php echo get_post_type_archive_link('post'); ?>" style={{ color: C.sub }}>{ARTICLE.cat}</a>
          <span>›</span>
          <span style={{ color: C.t1, ... }}>{ARTICLE.title}</span>
        </div>
      </div>

      <main style={{ maxWidth: 1160, margin: '0 auto', padding: '24px 16px 0' }}>
        <div className="layout-grid">

          {/* 記事ヘッダー */}
          <div style={{ background: C.white, ... }}>
            {/* article.html の記事ヘッダー部分をコピー */}
          </div>

          {/* アイキャッチ画像 */}
          <div style={{ background: C.white, ... }}>
            {/* article.html の画像部分をコピー */}
          </div>

          {/* 記事本文 */}
          <div className="article-body" 
               dangerouslySetInnerHTML={{ __html: ARTICLE.content }} />

          {/* タグ */}
          <div style={{ background: C.white, ... }}>
            {/* article.html のタグ部分をコピー */}
          </div>

          {/* シェアボタン */}
          <div style={{ background: C.white, ... }}>
            <ShareBar title={ARTICLE.title} href={pageUrl} />
          </div>

          {/* 関連記事 */}
          <RelatedArticles />

          {/* サイドバー */}
          <aside className="sidebar-content" style={{ position: 'relative' }}>
            <div style={{ position: 'sticky', top: 96 }}>
              <?php get_sidebar(); ?>
            </div>
          </aside>

        </div>
      </main>

      <Footer />
    </div>
  );
}

ReactDOM.createRoot(document.getElementById('root')).render(<App />);
</script>

<?php get_footer(); ?>
```

## 実行手順

1. `article.html` の `<script type="text/babel">` 内のコード全体をコピー
2. 上記テンプレートに貼り付け
3. WordPress固有の置き換えを実行
4. 完成した `single.php` の全文を出力

## 注意事項
- **完全コピー**: `article.html` のReactコード全体を省略なしでコピー
- **ARTICLE_DATA**: `functions.php` で定義される変数（既存コード参照）
- **サイドバー**: `<?php get_sidebar(); ?>` で `sidebar.php` を読み込み
```

---

## 3. page-about.php 作成プロンプト

```
# page-about.php 作成タスク

## 目的
`kawabata-wp-theme/page-about.php` を作成する。元となるのは `about.html`。

## 元ファイル
- `about.html`

このファイルに含まれる「当社について」ページのReactコード全体を抽出する。

## 抽出対象コード

### メインコンポーネント
- `App()` 関数（会社概要ページのメインコンポーネント）
- `TimelineItem` コンポーネント（年表）
- `InfoRow` コンポーネント（会社概要テーブル）
- 年表データ `timeline`

### ユーティリティコンポーネント
- `Header`
- `MobileMenu`
- `Footer`
- `Sidebar`
- `Img`, `SH` 等

## WordPress固有の置き換え

### リンク
```javascript
// 置き換え前
<a href="index.html">トップ</a>

// 置き換え後
<a href="<?php echo home_url('/'); ?>">トップ</a>
```

### 画像パス
```javascript
// 置き換え前
const IMGS = {
  corporate: WIX + '...',
  editor: WIX + '...',
};

// 置き換え後
const IMGS = {
  corporate: '<?php echo get_template_directory_uri(); ?>/images/corporate.jpg',
  editor: '<?php echo get_template_directory_uri(); ?>/images/editor.jpg',
};
```

## ファイル構造テンプレート

```php
<?php
/**
 * Template Name: 当社について
 * 
 * @package kawabata
 */
get_header();
?>

<div id="root"></div>

<script type="text/babel">
const { useState, useEffect } = React;

// ========================================
// カラートークン
// ========================================
const C = { /* index.html と同じ */ };

// ========================================
// 画像パス
// ========================================
const IMGS = {
  corporate: '<?php echo get_template_directory_uri(); ?>/images/corporate.jpg',
  editor: '<?php echo get_template_directory_uri(); ?>/images/editor.jpg',
};

// ========================================
// ユーティリティコンポーネント
// ========================================
// about.html から以下をコピー:
// - Img
// - SH (セクション見出し)
// - TimelineItem
// - InfoRow
// - Header
// - MobileMenu
// - Sidebar
// - Footer

// ========================================
// メインコンポーネント
// ========================================
function App() {
  const [menuOpen, setMenuOpen] = useState(false);

  const timeline = [
    { year: '2019', events: [{ month: '3月', text: 'YouTubeチャンネル「ふみたび」開設', accent: true }] },
    // about.html の timeline 配列全体をコピー
  ];

  return (
    <div>
      <Header menuOpen={menuOpen} setMenuOpen={setMenuOpen} />
      <MobileMenu open={menuOpen} onClose={() => setMenuOpen(false)} />

      {/* パンくずリスト */}
      <div style={{ background: C.white, borderBottom: `1px solid ${C.border}` }}>
        <div style={{ maxWidth: 1160, margin: '0 auto', ... }}>
          <a href="<?php echo home_url('/'); ?>" style={{ color: C.sub }}>トップ</a>
          <span>›</span>
          <span style={{ color: C.t1 }}>当社について</span>
        </div>
      </div>

      <main style={{ maxWidth: 1160, margin: '0 auto', padding: '24px 16px 0' }}>
        <div className="layout-grid">

          {/* about.html の main セクション内容を全コピー */}

          {/* サイドバー */}
          <aside className="sidebar-content">
            <?php get_sidebar(); ?>
          </aside>

        </div>
      </main>

      <Footer />
    </div>
  );
}

ReactDOM.createRoot(document.getElementById('root')).render(<App />);
</script>

<?php get_footer(); ?>
```

## 実行手順

1. `about.html` の `<script type="text/babel">` 内のコード全体をコピー
2. 上記テンプレートに貼り付け
3. WordPress固有の置き換えを実行
4. 完成した `page-about.php` の全文を出力
```

---

## 4. page-contact.php 作成プロンプト

```
# page-contact.php 作成タスク

## 目的
`kawabata-wp-theme/page-contact.php` を作成する。元となるのは `contact.html`。

## 元ファイル
- `contact.html`

このファイルに含まれるお問い合わせフォームのReactコード全体を抽出する。

## 抽出対象コード

### メインコンポーネント
- `App()` 関数（お問い合わせページのメインコンポーネント）
- `Input` コンポーネント（フォーム入力フィールド）
- フォーム送信ロジック（`handleSubmit`）

### ユーティリティコンポーネント
- `Header`
- `MobileMenu`
- `Footer`

## WordPress固有の置き換え

### リンク
```javascript
// 置き換え前
<a href="index.html">トップ</a>

// 置き換え後
<a href="<?php echo home_url('/'); ?>">トップ</a>
```

## ファイル構造テンプレート

```php
<?php
/**
 * Template Name: お問い合わせ
 * 
 * @package kawabata
 */
get_header();
?>

<div id="root"></div>

<script type="text/babel">
const { useState, useEffect } = React;

// ========================================
// カラートークン
// ========================================
const C = { /* index.html と同じ */ };

// ========================================
// コンポーネント
// ========================================
// contact.html から以下をコピー:
// - Input (フォーム入力コンポーネント)
// - Header
// - MobileMenu
// - Footer

// ========================================
// メインコンポーネント
// ========================================
function App() {
  const [menuOpen, setMenuOpen] = useState(false);
  const [isSubmitted, setIsSubmitted] = useState(false);

  const handleSubmit = (e) => {
    e.preventDefault();
    setIsSubmitted(true);
  };

  return (
    <div>
      <Header menuOpen={menuOpen} setMenuOpen={setMenuOpen} />
      <MobileMenu open={menuOpen} onClose={() => setMenuOpen(false)} />

      {/* contact.html の main セクション内容を全コピー */}

      <Footer />
    </div>
  );
}

ReactDOM.createRoot(document.getElementById('root')).render(<App />);
</script>

<?php get_footer(); ?>
```

## 実行手順

1. `contact.html` の `<script type="text/babel">` 内のコード全体をコピー
2. 上記テンプレートに貼り付け
3. WordPress固有の置き換えを実行
4. 完成した `page-contact.php` の全文を出力
```

---

## 5. page-privacy.php 作成プロンプト

（`page-contact.php` と同様の構造で `privacy.html` を元に作成）

---

## 6. 404.php 作成プロンプト

```
# 404.php 作成タスク

## 目的
`kawabata-wp-theme/404.php` を作成する。404エラーページ。

## 元ファイル
- なし（新規作成）

## 参考デザイン
- `index.html` のレイアウトを踏襲
- ヘッダー・フッターは共通コンポーネント使用

## ファイル構造テンプレート

```php
<?php
/**
 * 404 エラーページテンプレート
 * 
 * @package kawabata
 */
get_header();
?>

<div id="root"></div>

<script type="text/babel">
const { useState } = React;

const C = { /* カラートークン */ };

// Header, MobileMenu, Footer を index.html からコピー

function App() {
  const [menuOpen, setMenuOpen] = useState(false);

  return (
    <div>
      <Header menuOpen={menuOpen} setMenuOpen={setMenuOpen} />
      <MobileMenu open={menuOpen} onClose={() => setMenuOpen(false)} />

      <main style={{ maxWidth: 720, margin: '0 auto', padding: '80px 16px', textAlign: 'center' }}>
        <div style={{ fontSize: 120, fontWeight: 700, color: C.main, marginBottom: 24 }}>404</div>
        <h1 style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 24, fontWeight: 700, color: C.t1, marginBottom: 16 }}>
          ページが見つかりません
        </h1>
        <p style={{ fontSize: 14, color: C.t2, lineHeight: 1.8, marginBottom: 32 }}>
          お探しのページは削除されたか、URLが変更された可能性があります。
        </p>
        <a href="<?php echo home_url('/'); ?>" 
           style={{ display: 'inline-block', background: C.main, color: '#fff', borderRadius: 4, padding: '12px 32px', fontSize: 14, fontWeight: 700, textDecoration: 'none' }}>
          トップページへ戻る
        </a>
      </main>

      <Footer />
    </div>
  );
}

ReactDOM.createRoot(document.getElementById('root')).render(<App />);
</script>

<?php get_footer(); ?>
```

## 実行手順

1. 上記テンプレートをベースに作成
2. `Header`, `MobileMenu`, `Footer` を `index.html` からコピー
3. 完成した `404.php` の全文を出力
```

---

## 使用方法

1. **優先順位順に実行**:
   - `sidebar.php` → `single.php` → `page-about.php` → `page-contact.php`

2. **各プロンプトを個別に実行**:
   - 一度に全ファイル作成を依頼すると省略される可能性が高いため、**1ファイルずつ**実行

3. **検証**:
   - 各ファイル作成後、ブラウザでWordPressサイトを確認

このプロンプト群で完全なPHPファイルセットが作成できます。

---

## デプロイ自動化とステージング環境構築の手順（2026/05/17追記）

これまでのやり取りで実施した、GitHub Actionsを用いたFTPデプロイ環境の構築と、ステージング（テスト）環境の構築フローについて記録します。

### 1. GitHub Actions デプロイフローのFTP移行
元々SSH（rsync）で構築されていたデプロイフローを、より一般的で設定が容易なFTPデプロイ（`SamKirkland/FTP-Deploy-Action`）に移行しました。

- **対象ファイル**: `.github/workflows/deploy-production.yml` および `deploy-staging.yml`
- **変更内容**:
  - `webfactory/ssh-agent` や `rsync` などのコマンドステップを削除。
  - 代わりに `FTP-Deploy-Action` を導入。
  - `local-dir: ./kawabata-wp-theme/` を指定し、テーマフォルダの中身だけをデプロイするよう修正。
  - 変更ファイルのみを効率的に同期するため、`actions/checkout` に `fetch-depth: 2` を追加。
  - 不要ファイル（`.git`, `.github`, `README.md`）を `exclude` 指定。

### 2. GitHub Secrets の構成
本番環境とステージング環境が同一のレンタルサーバー（同一FTPアカウント）にある場合を想定し、接続情報は共通化し、デプロイ先のパスのみを分離する設計としました。

必要なシークレット（Settings > Secrets and variables > Actions）:
- `FTP_SERVER`: FTPサーバーのホスト名（共通）
- `FTP_USERNAME`: FTPのユーザー名（共通）
- `FTP_PASSWORD`: FTPのパスワード（共通）
- `PRODUCTION_THEME_PATH`: 本番のテーマフォルダへのパス
  - 例: `/public_html/wp-content/themes/kawabata-wp-theme/`
- `STAGING_THEME_PATH`: ステージングのテーマフォルダへのパス
  - 例: `/public_html/test/wp-content/themes/kawabata-wp-theme/`

**【重要】** パスはFTPで接続した際に見えるルートからのフルパスとし、**最初と最後に必ず `/` をつける**必要があります。

### 3. ステージング環境の安全な構築方法
開発やテストを安全に行うため、本番環境と全く同じ状態（記事データ、画像、プラグイン等）を持ったステージング環境を作ることが推奨されます。単純なFTPでのファイルコピーではデータベース周りの不具合が起きるため、以下の方法を取ります。

- **推奨手順（プラグインによる完全複製）**:
  1. 本番のWordPressに `All-in-One WP Migration` プラグインをインストール。
  2. 「エクスポート」から全データを `.wpress` という1つの圧縮ファイルとしてダウンロードする。
  3. レンタルサーバー上のテスト用ディレクトリ（例: `/public_html/test/`）に、空のWordPressを新規インストールする。
  4. テスト用WordPressにも同じプラグインを入れ、さきほどダウンロードした `.wpress` ファイルを「インポート」する。
- **補足**: エックスサーバーなどの高機能なレンタルサーバーでは、管理画面の「WordPressコピー機能」を使うことでボタン1つでこの作業が完了します。

---

## トラブルシューティング記録

### 1. JSONデータを含むインラインスクリプトのパースエラー（2026/05/17追記）

**【事象】**
React・Babelを使用したWordPressテーマにおいて、ブラウザのコンソールに `Uncaught SyntaxError: Unexpected identifier 'sha384'` というエラーが表示され、画面が正しく描画されない問題が発生しました。

**【原因】**
`functions.php` 内の `script_loader_tag` フィルターで、CDNスクリプトに対して SRI（Subresource Integrity）属性を付与する処理に問題がありました。
単純に `str_replace(' src=', ...)` を使って置換していたため、`wp_add_inline_script()` によって出力された記事本文（JSONデータ）内の画像タグ `<img src="...">` の ` src=` までもが置換対象となってしまいました。
その結果、JSON文字列内に意図しないダブルクォーテーションや文字列（`integrity="sha384-...`）が混入し、JavaScriptの構文エラー（SyntaxError）を引き起こしていました。

**【修正内容】**
`str_replace` を `preg_replace` に変更し、置換対象を `<script ...>` タグが持つ `src=` 属性のみに厳密に限定しました。さらに置換回数を1回（`1`）に制限することで、インラインのJSONデータが安全に保たれるようになりました。

```php
// functions.php での修正内容
add_filter( 'script_loader_tag', function ( $tag, $handle ) {
    $integrity_map = [
        'kawabata-react'     => 'sha384-hD6/rw4ppMLGNu3tX5cjIb+uRZ7UkRJ6BPkLpg4hAu/6onKUg4lLsHAs9EBPT82L',
        'kawabata-react-dom' => 'sha384-u6aeetuaXnQ38mYT8rp6sbXaQe3NL9t+IBXmnYxwkUI2Hw4bsp2Wvmx4yRQF1uAm',
        'kawabata-babel'     => 'sha384-m08KidiNqLdpJqLq95G/LEi8Qvjl/xUYll3QILypMoQ65QorJ9Lvtp2RXYGBFj1y',
    ];
    if ( isset( $integrity_map[ $handle ] ) ) {
        // <script> タグの src= に限定して1回だけ置換
        $tag = preg_replace(
            '/(<script\b[^>]*?) src=/i',
            '$1 integrity="' . $integrity_map[ $handle ] . '" crossorigin="anonymous" src=',
            $tag,
            1
        );
    }
    return $tag;
}, 10, 2 );
```