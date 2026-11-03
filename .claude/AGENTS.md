# AGENTS.md — 鹿児島地域交通通信社 ウェブサイト

このリポジトリで作業するエージェント（Claude Code・Codex など）向けの規約。
次の2ファイルを統合したもの（2026-11-03）。

| 統合元 | 内容 | 本書での位置 |
|---|---|---|
| `HP/.claude/CLAUDE.md`（リポジトリの2つ上の階層） | 全案件共通の作業ルール | 第1部 |
| `.claude/CLAUDE.md`（統合後に削除） | このサイトの規約＋汎用デザイン規約 | 第2部・第3部 |

本書中のパスは、すべてリポジトリ直下からの表記。

統合時に、実装と食い違っていた記述（単一HTML構成・記事データの置き場所・レスポンシブ未実装など）は、`.claude/README.md` と `php/` のコードに合わせて書き直した。

### ルールが衝突したときの優先順位

1. 第2部「プロジェクト規約」（このサイト固有の値・書き方）
2. 第1部「作業ルール」
3. 第3部「汎用デザイン規約」

例：第1部は「CSSはBEM・`:root` 変数」だが、このサイトはReactのインラインスタイル＋`C` オブジェクトで書く（第2部が優先）。

---

# 第1部 作業ルール（全案件共通）

「どう振る舞うか」の定義。案件固有の情報（配色・技術構成など）は第2部と `.claude/README.md` に置く。

## 1-0. セッション開始時の手順

1. `.claude/README.md` を読む（案件の前提・仕様・現在地）
2. `.claude/history.md` の**上から5件**を読む（直近の経緯・未解決事項）
3. 不足があれば作業前に質問する。**推測で進めない**

## 1-1. 応答フォーマット

依頼を受けたら、次の4ブロックで整理してから着手する。

| ブロック | 内容 |
|---|---|
| 指示 | 何をするか（1行） |
| 前提 | README/historyから拾った関連情報 |
| 入力 | 読む・使うファイル、素材、参考サイト |
| 出力 | 生成・変更するファイルと、その完了条件 |

前提に不足・矛盾があれば、この段階で止めて確認する。

## 1-2. コードを書く前の禁止事項

- 対象ファイルを**読まずに**編集しない
- ファイル全体を書き直さない（該当箇所のみ差分で修正）
- `.claude/README.md` に無いライブラリ・CDN・フレームワークを勝手に追加しない
- 新しい色・フォント・余白の値を勝手に作らない（デザイントークンを使う）
- 依頼されていないリファクタリング・ファイル削除・構成変更をしない
- 本番環境・DB・公開ファイルへの破壊的操作は必ず確認を取る

## 1-3. 実装規約（共通）

- 1回の依頼 = 1つの関心事。まとめて壊さない
- 既存のコードスタイル（インデント・命名・構造）に合わせる
- コメントは「なぜそうしたか」を書く。「何をしているか」は書かない
- HTML：セクションごとに `<!-- ▼ セクション名 -->` 形式で区切る／`h1` は1ページに1つ・見出しレベルを飛ばさない／画像には必ず `alt`（装飾画像は `alt=""`）／更新担当が非エンジニアの場合、テキスト部分は編集しやすい平易な構造にする
- CSS：デザイントークンは `:root` のCSS変数のみ／クラス名はBEM／モバイルファースト（`min-width` でPCを上書き）／ブレークポイントはREADMEの値のみ／長くなったらセクション単位で分割しREADMEの構成表を更新　※このサイトでは第2部の書き方が優先
- JavaScript：素のJSで書けるものにライブラリを入れない／DOM取得は存在チェックしてから使う／アニメーションは `prefers-reduced-motion` に配慮する
- SEO / パフォーマンス（全ページ必須）：`title` / `meta description` / OGP / favicon／画像は WebP・`loading="lazy"`・`width`/`height` 指定／リンク切れ・404の確認　※このサイトでは title・OGP 等は AIOSEO が出力する（第2部参照）

## 1-4. 作業完了時の手続き（省略しない）

1. `.claude/history.md` の**先頭**に1エントリ追記（形式は既存エントリに合わせる：見出し「## 日付（要旨）」→ 変更点 → 「未対応・留意点」）
2. 仕様・構成・トークンが変わったら `.claude/README.md` の該当セクションを上書き更新
3. 変更点を3行以内で報告し、**確認してほしい箇所**を明示する

## 1-5. 迷ったときの優先順位

1. クライアントの事業目的
2. 更新担当者の運用しやすさ
3. 表示速度・アクセシビリティ
4. 見た目の新しさ

## 1-6. 質問してよい／すべき場面

- 仕様がREADMEに無い、または矛盾している
- デザイン意図の解釈が2通り以上ある
- 影響範囲が依頼の外に及ぶ
- クライアント確認が必要な内容（文言・料金・実名）

---

# 第2部 プロジェクト規約（鹿児島地域交通通信社）

## 2-1. 概要

| 項目 | 内容 |
|---|---|
| 日本語名称 | 鹿児島地域交通通信社 |
| 英語名称 | Kagoshima regional transport news agency |
| 本番ドメイン | `kagoshima-news.jp` |
| コンセプト | 「公共交通と地域文化を世の中へ」。鹿児島県内の公共交通・地域情報を取材・報道する個人運営メディア |

WordPressテーマの各PHPテンプレート内に、React＋Babel Standalone のJSXを `<script type="text/babel">` で直接書く構成。ビルドツールはない。

## 2-2. ファイル構成

```
php/                    本番で稼働中のWordPressテーマ（こちらが正）
├── style.css           テーマ情報・:root 変数・リセット・レイアウト用クラス
├── functions.php       テーマ設定、CDN読み込みとSRI付与、記事データの受け渡し
├── header.php          <head>・計測タグ・共通コンポーネント（C / IMGS / Img / Badge / SH / Header / MobileMenu / Footer / track）
├── footer.php          共通フッター
├── index.php           トップ
├── archive.php         記事一覧・カテゴリアーカイブ
├── page-articles.php   固定ページ「記事一覧」（archive.php を require）
├── single.php          記事詳細
├── page-about.php      概要案内（私たちについて）
├── page-contact.php    お問い合わせ
└── page-privacy.php    プライバシーポリシー
plugins/kawabata-contact-form/   自作プラグイン（お問い合わせの受信・保存・通知）
html/                   初期プロトタイプ（静的HTML）。本番には使われていない
.claude/README.md       案件の前提・構成・デプロイ・残課題
.claude/history.md      変更履歴（最新が先頭）
.claude/AGENTS.md       本書（開発規約）
.claude/CLAUDE.md       Claude Code に本書を自動で読ませるための1行（@AGENTS.md）。規約は書かない
```

- 仕様変更時は `php/` を直す。`html/` は原則追従させない（変える場合は README・history に明記）。
- サイドバーは独立ファイルではなく、各テンプレート内の `Sidebar` コンポーネント。
- デプロイは GitHub Actions が `php/` のみをFTPSで配信する。`plugins/` は対象外（管理画面からzipでアップロード）。

## 2-3. 依存ライブラリ（CDN固定バージョン）

| ライブラリ | バージョン | 用途 |
|---|---|---|
| React | 18.3.1 | UIフレームワーク |
| ReactDOM | 18.3.1 | DOMレンダリング |
| @babel/standalone | 7.29.0 | JSX変換 |
| Noto Sans JP / Noto Serif JP | Google Fonts | 日本語フォント |

- バージョンは固定。`functions.php` で読み込み、integrity属性（SRI）を必ず付与する。
- WordPressプラグイン：**All in One SEO** が title / description / canonical / OGP / JSON-LD / sitemap を出力する。テーマ側で同じ機能を作らない。
- 計測：GTM（`GTM-T6RB6ZMF`）経由で GA4・Microsoft Clarity。クリック計測は `header.php` の `track(name, params)` で dataLayer に送る（`contact_click` / `sns_click` / `article_click` / `contact_submit`）。

## 2-4. カラートークン

### CSS変数（`php/style.css` の `:root`）

```css
--main:        #1B3A6B   /* メインブルー */
--main-dark:   #122851
--main-light:  #EEF3FA
--sub:         #2E5FA3   /* サブブルー */
--sub-light:   #D0DCF0
--accent:      #E07B1A   /* アクセントオレンジ */
--accent-dark: #B85E0D
--text-1:      #0F1B2E   /* 本文メイン */
--text-2:      #4A5568   /* 本文サブ */
--text-3:      #7A8A9E   /* 補助テキスト */
--border:      #D8E4F0
--bg:          #F4F7FB
--white:       #FFFFFF
```

### JSオブジェクト `C`（インラインスタイル用・`header.php`）

CSSと対応する定数。**インラインスタイルには必ず `C` を使う**。生のカラーコードを直書きしない。

```js
const C = {
  main: '#1B3A6B', mainDark: '#122851', mainLight: '#EEF3FA',
  sub: '#2E5FA3', subLight: '#D0DCF0',
  accent: '#E07B1A', accentDark: '#B85E0D',
  t1: '#0F1B2E', t2: '#4A5568', t3: '#7A8A9E',
  border: '#D8E4F0', bg: '#F4F7FB', white: '#FFFFFF',
};
```

## 2-5. カテゴリ定義

```js
const CATS = ['すべて', '鉄道', '航空', '船舶', 'バス', '地域話題', '鹿児島のイベント', '記者のひとりごと'];

const CAT_COLORS = {
  '鉄道':   C.main,     // #1B3A6B
  '航空':   '#0D5F7E',
  '船舶':   '#1A6B4A',
  'バス':   C.sub,      // #2E5FA3
  '地域話題': '#6B3FA0',
  '鹿児島のイベント': '#B85E0D',
  '記者のひとりごと': '#C2185B',
  'その他': C.t2,
};
```

- カテゴリ名はWordPress管理画面のカテゴリ名と完全一致させる（一致しない記事は「その他」になる）。
- `CATS`・`CAT_COLORS` は `header.php` と `archive.php` の2か所に定義がある。追加時は WordPress のカテゴリ作成 → 両ファイルの `CATS`・`CAT_COLORS` → `functions.php` のカテゴリ優先順位（2か所）を更新する。
- トップの「鹿児島県民に読んでほしい記事」枠はスラッグ `kagoshima`、「編集長一押しの記事」枠は `henshutyo` の最新記事1件（`kawabata_get_pick()`）。この2カテゴリは `CATS` には入れない。

## 2-6. コンポーネント規約

### 命名

| コンポーネント | 定義場所 | 役割 |
|---|---|---|
| `Img` | header.php | 画像（src失敗時はグラデーションプレースホルダー） |
| `Badge` | header.php | カテゴリ・ラベルバッジ |
| `SH` | header.php | セクション見出し（左ボーダー付き） |
| `Header` | header.php | ページヘッダー（ハンバーガーメニューボタン含む） |
| `MobileMenu` | header.php | メニューオーバーレイ（カテゴリ・概要・SNS・お問い合わせ） |
| `Footer` | header.php | フッター |
| `CardH` / `CardV` | index.php・archive.php | 横型／縦型の記事カード |
| `CategoryNav` | index.php・archive.php | カテゴリ切り替えナビ |
| `SearchResults` | index.php | 検索モーダル |
| `Sidebar` | 各テンプレート | 右サイドバー（会社概要・SNS・お問い合わせ） |

### スタイル指定

- 部品の見た目は**インラインスタイル**で書く（`C` を使う）。
- `style.css` に置くのは、リセット・フォント・変数・リンク色と、メディアクエリが必要なレイアウト用クラス（`.layout-grid` / `.sidebar-content` / `.featured-grid` / `.genre-showcase`）のみ。新しいクラスは、インラインでは書けないレスポンシブ対応に限って追加する。
- 記事本文（WordPressの投稿HTML）の装飾は `single.php` 冒頭の `<style>`（`.article-body` 配下）で行う。
- ホバー効果は `onMouseEnter` / `onMouseLeave` で `e.currentTarget.style` を直接操作する。直接DOM操作はホバー効果のみに限定する。

### `Img`

```jsx
<Img h={高さpx} tone={'a'〜'f'} src={URL} alt="説明" style={{追加スタイル}} />
```

- `src` が未指定または読み込み失敗時 → `tone` に応じたグラデーション表示
- `tone`：`a`（青灰）`b`（緑灰）`c`（茶灰）`d`（紫灰）`e`（青灰薄）`f`（肌灰）

### `Badge`

```jsx
<Badge color={CAT_COLORS[cat]} outline={false} small={false}>{children}</Badge>
```

- 速報 → `color={C.accent}`／独自 → `color={'#6B3FA0'}`／アウトライン → `outline={true}`

## 2-7. 記事データ

記事は WordPress の投稿から `functions.php` が作り、JSのグローバル変数で渡す。**コンポーネント内に記事データを直書きしない。**

| 変数 | 作る関数 | 中身 |
|---|---|---|
| `WP_ARTICLES` | `kawabata_get_articles()` | 一覧（最新25件／カテゴリページではそのカテゴリ）。全ページで出力 |
| `WP_PICK_CITIZENS` / `WP_PICK_EDITOR` | `kawabata_get_pick()` | トップのピックアップ2枠（無ければ `null`） |
| `ARTICLE_DATA` | `kawabata_single_article_data()` | 記事詳細ページの1件 |
| `WP_CURRENT_PAGE` / `WP_MAX_PAGES` | — | 一覧のページ送り |

`index.php`・`archive.php` は `WP_ARTICLES` を `ALL_ARTICLES` に受けて使う。

一覧の1件（`kawabata_format_article()`）：

```js
{
  cat:       string,          // CATS のいずれか（'すべて'以外）または 'その他'
  title:     string,
  time:      string,          // 例: '4月26日 18:30'
  tone:      'a'|'b'|'c'|'d'|'e'|'f',
  badge:     string|null,     // '速報' | '独自' | null
  summary:   string|null,     // 抜粋
  src:       string|null,     // アイキャッチ（medium）
  src_large: string|null,     // アイキャッチ（large）。トップ記事の大画像用
  href:      string,          // パーマリンク
}
```

`ARTICLE_DATA` は上記に加えて `cat_link` / `published` / `updated` / `author` / `tags` / `caption` / `content`（本文HTML）を持つ（`src` は large）。

## 2-8. 画像

- 記事の画像は WordPress のアイキャッチ（メディアライブラリ）を使う。
- テンプレートで使う固定画像は `header.php` の `IMGS` に集約し、`src={IMGS.キー}` で参照する。
  - Wix CDN の画像は `WIX` プレフィックスを使う（推奨 `w_600,h_400,q_90,enc_avif,quality_auto`／バナーは `w_1200,h_400`）。
  - テーマ内の画像は `get_template_directory_uri()` で参照する（例：`IMGS.editor` = `representative_top.webp`）。

## 2-9. 外部リンク・SNS

| 媒体 | URL |
|---|---|
| X | `https://x.com/kagoshimanewsjp` |
| note | `https://note.com/humitabinewsphot` |
| Instagram | `https://www.instagram.com/kagoshimanewsjp/` |
| TikTok | `https://www.tiktok.com/@humitabitrafficnewsphoto` |
| コーポレートサイト | `https://www.humitabitrafficnews.com/` |
| 編集長メッセージ（旧サイト） | `https://www.humitabitrafficnews.com/史旅編集-交通報道について` |
| 概要案内 | `/about/` |
| 記事一覧 | `/articles/` |
| お問い合わせ | `/contact/`（`?type=tip` 等でご用件を選んだ状態で開く） |
| メール | `info@kagoshima-news.jp`（プライバシーポリシー・フッターの表記のみ。導線は /contact/ に統一し mailto は使わない） |

- 外部リンクは必ず `target="_blank" rel="noreferrer"` を付与する。
- 記事リンクの `href` が無い場合は `'#'` を設定し、`target` 属性を省略する。

## 2-10. お問い合わせフォーム

- 画面は `php/page-contact.php`、受信は自作プラグイン `plugins/kawabata-contact-form/`（`POST /wp-json/kawabata/v1/contact`）。
- 受信内容は管理画面「お問い合わせ」に保存し、`info@kagoshima-news.jp` に通知する。
- ご用件のキー（`tip` / `coverage` / `usage` / `ad` / `feedback` / `other`）は、プラグインの `kcf_types()` と `page-contact.php` の `INQUIRY_TYPES` で一致させる。

## 2-11. レイアウト

- **最大幅**：`1160px`、中央寄せ `margin: '0 auto'`、左右パディング `16px`
- **メイングリッド**：`.layout-grid`（`1fr 280px`、列間 `20px`）。サイドバーは `.sidebar-content`
- **カードグリッド**：`repeat(2, 1fr)`、gap `10px`

### レスポンシブ対応状況

- ブレークポイントは `767px`（`style.css`）。スマホではメイングリッドを1列にし、サイドバーを非表示、ピックアップ枠を1列にする。
- ヘッダーの文字サイズは `clamp()` で画面幅に合わせて縮小する。
- タブレット幅（768〜1024px）専用の調整は未実装。

## 2-12. 状態管理

`useState` のみ使用。外部状態管理ライブラリは導入しない。

| state | 主な場所 | 用途 |
|---|---|---|
| `cat` | index.php・archive.php | 選択中カテゴリ |
| `searchOpen` / `searchQuery` / `searching` | index.php | 検索バー・検索文字列・検索モーダル |
| `menuOpen` | 全テンプレート | ハンバーガーメニュー表示 |

## 2-13. コーディングルール

1. JSXは Babel Standalone で変換する。`<script type="text/babel">` に書く。
2. React API は `header.php` の `const { useState, useEffect } = React;` で取得済み。他のAPIは使う場所で分割代入する（例：`const { useRef } = React;`）。
3. PHPの値は JSX 内に `<?php echo ... ?>` で埋め込む（URLは `home_url()` / `get_permalink()` 等を使い、ドメインを直書きしない）。
4. コメントは「なぜそうしているか」が非自明な場合のみ1行で書く。
5. PHPは WordPress の関数でエスケープする（`esc_html` / `esc_attr` / `esc_url` / `esc_js`）。JSに渡すデータは `wp_json_encode()` を使う。
6. キャッシュ系・JS圧縮系プラグインは React/Babel のインライン実行と競合しやすいため使わない。

---

# 第3部 汎用デザイン規約（カスタマイズガイドライン）

> **注意**：新規HTML/CSSプロジェクト向けの汎用規約。第2部と衝突する場合は**第2部が優先**。このサイトでは、色・部品の書き方（`.button` 等のクラス、緑系の配色、`.hamburger-morph`）は採用しておらず、既存の `C` トークンと React コンポーネントを使う。

## 3-1. 基本デザインルール

### カラールール

| 項目 | 値 |
|---|---|
| 背景カラー | `#f0f0f0` |
| メインカラー | プロジェクトごとに設定 |
| アクセントカラー | プロジェクトごとに設定 |
| テキストカラー | `#222` |

### フォントルール

**デフォルトフォント**：Noto Sans JP / Noto Serif JP

| 要素 | サイズ | font-weight | line-height |
|---|---|---|---|
| H1 | 48px | Bold (700) | 1.2 |
| H2 | 40px | Bold (700) | 1.2 |
| H3 | 32px | Medium (500) | 1.3 |
| H4 | 24px | Medium (500) | 1.4 |
| H5 | 16px | Regular (400) | 1.5 |
| H6 | 8px | Regular (400) | 1.5 |

- `letter-spacing`：必要に応じて指定（例：`0em`）
- 本文：Noto Sans JP／Regular (400)／16px／line-height 1.6／letter-spacing 必要に応じて（例：`0.05em`）
- 注釈・キャプション：Noto Sans JP／Regular (400) または Light (300)／14px／line-height 1.5
- ヘッダー内のテキスト：**12px**

```css
/* スマートフォン */
@media screen and (max-width: 767px) {
  h1 { font-size: 32px; }
  p { font-size: 14px; }
}
/* PC・デスクトップ */
@media screen and (min-width: 1025px) {
  h1 { font-size: 48px; }
  p { font-size: 16px; }
}
```

## 3-2. 余白ルール

| 要素 | margin | padding |
|---|---|---|
| ヘッダー `<header>` | `margin: 0` | 垂直 `16px 0`、水平 `2.5%` |
| ヒーローセクション | `margin: 0` | — |
| フッター `<footer>` | `margin: 0` | 垂直 `24px 0`、水平 `2.5%` |

- `main`：`padding: 2.5%`（小さな画面では `1%`）
- 主要セクション間の垂直マージン：原則 **40px**（小画面 **20px**）、小画面の水平パディング **5%**

| main内の要素の関係 | margin |
|---|---|
| 見出し直後の段落 | `margin-bottom: 16px` |
| 段落同士の間 | `margin-bottom: 16px` |
| 画像直前・直後の段落 | `margin-top: 24px`, `margin-bottom: 24px` |
| リスト直前・直後の段落 | `margin-top: 24px`, `margin-bottom: 24px` |
| 水平線 | `margin-top: 32px`, `margin-bottom: 32px` |

## 3-3. 画像の扱い

| 項目 | 規定 |
|---|---|
| 画像形式 | 原則 WebP (`.webp`) |
| ロゴ形式 | SVG 推奨、不可の場合 WebP |
| アニメーションGIF | 避ける。`<video>` + MP4 を検討 |
| alt属性 | 必ず適切な内容。装飾目的は `alt=""` |
| Lazy Loading | 初期表示不要な画像に `loading="lazy"` |
| CSS | `max-width: 100%; height: auto;`（原則） |
| `<img>` | `width` / `height` 属性を記述 |
| 著作権 | 遵守。フリー素材は利用規約確認・クレジット表記 |

```html
<picture>
  <source media="(max-width: 767px)" srcset="image-mobile.webp">
  <source media="(min-width: 768px)" srcset="image-desktop.webp">
  <img src="image-fallback.webp" alt="説明">
</picture>
```

バナーサイズ：一般 468×60／PC 728×90／PCサイドバー 120×600

## 3-4. 共通コンポーネント（汎用）

### ボタン（`.button`）

```html
<button class="button [modifier]"><span>テキスト</span></button>
```

| 状態 | テキスト | 背景 | ボーダー |
|---|---|---|---|
| 通常 | `#f0f0f0` | `green` | `1px solid green` |
| ホバー | `green` | `transparent` | `1px solid green` |

- パディング `12px 24px`、角丸 `4px`
- `.button-primary`（主要）／`.button-secondary`（二次：文字 green・背景 transparent・ボーダー 1px solid green）／`.button-text`（テキストリンク風）
- `<button>` には `type` 属性、リンクには `href`。テキストはアクション内容を明確に

### 見出し（`.heading`）

- `.heading-level1`〜`.heading-level6`（48 / 40 / 32 / 24 / 16 / 8px）
- `<h1>` は原則ページに一つ

### ハンバーガーメニュー（`.hamburger-morph`）

```html
<button class="hamburger-morph" aria-label="メニュー" aria-controls="morph-menu" aria-expanded="false">
  <svg class="hamburger-morph__icon" width="48" height="48" viewBox="0 0 100 100">
    <path class="hamburger-morph__line" d="M 20,29 H 80 C 80,29 94.5,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058" />
    <path class="hamburger-morph__line" d="M 20,50 H 80" />
    <path class="hamburger-morph__line" d="M 20,71 H 80 C 80,71 94.5,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942" />
  </svg>
</button>

<nav id="morph-menu" class="nav-morph" aria-hidden="true">
  <div class="nav-morph__wrapper">
    <ul class="nav-morph__list">
      <li class="nav-morph__item">
        <a href="" class="nav-morph__link"><span class="nav-morph__text">ホーム</span></a>
      </li>
      <li class="nav-morph__item">
        <a href="concept/" class="nav-morph__link"><span class="nav-morph__text">私たちについて</span></a>
      </li>
      <li class="nav-morph__item">
        <a href="contact/" class="nav-morph__link"><span class="nav-morph__text">お問い合わせ</span></a>
      </li>
      <li class="nav-morph__item nav-morph__sns">
        <span class="nav-morph__text">SNS</span>
        <div class="nav-social-icons">
          <a href="" class="nav-social-icon"><i class="fab fa-instagram"></i><span>Instagram</span></a>
          <a href="" class="nav-social-icon"><i class="fab fa-facebook"></i><span>Facebook</span></a>
        </div>
      </li>
    </ul>
  </div>
</nav>
```

```css
.hamburger-morph {
  position: relative;
  z-index: 1000;
  width: 48px;
  height: 48px;
  padding: 0;
  background-color: #4caf50;
  border-radius: 50%;
  border: none;
  cursor: pointer;
}
.hamburger-morph__icon { width: 100%; height: 100%; }

.hamburger-morph__line {
  fill: none;
  stroke: white;
  stroke-width: 6;
  transition: stroke-dasharray 600ms cubic-bezier(0.4, 0, 0.2, 1),
              stroke-dashoffset 600ms cubic-bezier(0.4, 0, 0.2, 1);
}
.hamburger-morph__line:nth-child(1) { stroke-dasharray: 60 207; }
.hamburger-morph__line:nth-child(2) { stroke-dasharray: 60 60; }
.hamburger-morph__line:nth-child(3) { stroke-dasharray: 60 207; }

.hamburger-morph.active .hamburger-morph__line:nth-child(1) { stroke-dasharray: 90 207; stroke-dashoffset: -134; }
.hamburger-morph.active .hamburger-morph__line:nth-child(2) { stroke-dasharray: 1 60; stroke-dashoffset: -30; }
.hamburger-morph.active .hamburger-morph__line:nth-child(3) { stroke-dasharray: 90 207; stroke-dashoffset: -134; }

.nav-morph {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  background: rgba(255, 255, 255, 0.9);
  clip-path: circle(0% at calc(100% - 44px) 44px);
  transition: clip-path 0.7s cubic-bezier(0.4, 0, 0.2, 1);
  z-index: 900;
}
.nav-morph.active { clip-path: circle(150% at calc(100% - 44px) 44px); }
.nav-morph__wrapper { display: flex; align-items: center; justify-content: center; height: 100vh; }
.nav-morph__list {
  margin: 0;
  padding: 2.5%;
  list-style: none;
  text-align: center;
  border-radius: 24px;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
}

.nav-morph__item { opacity: 0; transition: opacity 0.2s ease, transform 0.2s ease; }
.nav-morph.active .nav-morph__item { opacity: 1; }
.nav-morph.active .nav-morph__item:nth-child(1) { transition-delay: 0.3s; }
.nav-morph.active .nav-morph__item:nth-child(2) { transition-delay: 0.4s; }
.nav-morph.active .nav-morph__item:nth-child(3) { transition-delay: 0.5s; }
.nav-morph.active .nav-morph__item:nth-child(4) { transition-delay: 0.6s; }

.nav-morph__link {
  position: relative;
  display: inline-block;
  padding: 20px;
  font-size: 28px;
  color: #4caf50;
  text-decoration: none;
  overflow: hidden;
}
.nav-morph__text,
.nav-morph__hover { transition: transform 0.3s ease; }
```

```js
document.addEventListener('DOMContentLoaded', function() {
  const hamburger = document.querySelector('.hamburger-morph');
  const nav = document.querySelector('.nav-morph');

  if (hamburger) {
    hamburger.addEventListener('click', () => {
      hamburger.classList.toggle('active');
      nav.classList.toggle('active');

      const isOpen = hamburger.classList.contains('active');
      hamburger.setAttribute('aria-expanded', isOpen);
      nav.setAttribute('aria-hidden', !isOpen);
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });
  }

  const menuLinks = document.querySelectorAll('.nav-morph__link');
  menuLinks.forEach(link => {
    link.addEventListener('mouseenter', () => {
      link.querySelector('.nav-morph__text').style.transform = 'translateY(-100%)';
      if (link.querySelector('.nav-morph__hover')) {
        link.querySelector('.nav-morph__hover').style.transform = 'translateY(-100%)';
      }
    });
    link.addEventListener('mouseleave', () => {
      link.querySelector('.nav-morph__text').style.transform = 'translateY(0)';
      if (link.querySelector('.nav-morph__hover')) {
        link.querySelector('.nav-morph__hover').style.transform = 'translateY(0)';
      }
    });
  });
});
```

### カード型レイアウト（`.card`）

- `.card`（背景色・ボーダー・シャドウ・角丸）／`.card-body`／`.card-title`（`.heading-level3` 適用可）／`.card-text`
- 767px以下で一列表示

### フォーム要素

- `.form-group`（ラベルと入力のグループ）／`.form-control`（入力・セレクト）／`.form-button`（`.button` と併用）
- `<label>` の `for` と `<input>` の `id` を関連付ける（JSXでは `htmlFor`）
- プレースホルダーをラベルの代わりにしない
- バリデーション・エラーメッセージを適切に表示し、`aria-` 属性を使う

## 3-5. レスポンシブデザイン

| デバイス | 条件 |
|---|---|
| スマートフォン | `max-width: 767px` |
| タブレット | `min-width: 768px` かつ `max-width: 1024px` |
| PC・デスクトップ | `min-width: 1025px` |

```html
<meta name="viewport" content="width=device-width, initial-scale=1.0">
```

```css
@media screen and (max-width: 767px) { /* スマートフォン向け */ }
@media screen and (min-width: 768px) and (max-width: 1024px) { /* タブレット向け */ }
@media screen and (min-width: 1025px) { /* PC・デスクトップ向け */ }
```

- スマートフォン：シングルカラム、ハンバーガーメニュー、`max-width: 100%`
- タブレット：2カラム・水平メニューを検討
- PC：複数カラム／グリッド、ホバーエフェクト
- `px` だけでなく `%` / `em` / `rem` / `vw` / `vh` も使う

## 3-6. アクセシビリティ

- 色のコントラスト比：WCAG 2.0 AA
- ナビゲーション・フォームをキーボードで操作可能に
- WAI-ARIA属性を適切に使う。ハンバーガーメニューには `aria-controls` / `aria-expanded`

## 3-7. JavaScript ルール（汎用）

- ライブラリ・フレームワークはプロジェクトごとに制限・推奨を設定（このサイトは2-3の表のみ）
- 命名規則・コード構造の規約を守る
- 初期化は DOMContentLoaded 内で行う（このサイトでは React の `useEffect` を使う）

## 3-8. タグのクラス名規約（汎用）

| 要素 | クラス名 |
|---|---|
| 見出し | `.heading` |
| ハンバーガーメニューボタン | `.hamburger-morph` |
| ナビゲーション | `.nav-morph` |
| ボタン | `.button` |
| カード | `.card` |
| フォームグループ | `.form-group` |
| フォーム入力 | `.form-control` |

---

## 更新履歴

変更履歴は [.claude/history.md](history.md) に記録する（最新が先頭）。
