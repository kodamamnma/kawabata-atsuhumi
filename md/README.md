# kawabata-atsuhumi — 鹿児島地域交通通信社

## サイト概要

- 日本語名称: 鹿児島地域交通通信社
- 英語名称: Kagoshima regional transport news agency
- 本番ドメイン: `kagoshima-news.jp`
- コンセプト: 「公共交通と地域文化を世の中へ」。鹿児島県内の公共交通・地域情報を中心に取材・報道する個人運営メディア（2019年YouTube「ふみたび」から、2026年に現名称へ）
- デザイン規約・コンポーネント仕様・カラートークン等は `CLAUDE.md` を参照

## リポジトリ構成

2つの実装が同居している。

- ルート直下の `*.html`（`index.html` / `articles.html` / `article.html` / `about.html` / `contact.html` / `privacy.html`）
  静的HTML＋React（`@babel/standalone`）による初期プロトタイプ。`kawabata-wp-theme/` の各PHPテンプレートは、これらのHTMLファイルのReactコードを元に作成された（例: `articles.html` → `archive.php`、`article.html` → `single.php`、`about.html` → `page-about.php`、`contact.html` → `page-contact.php`、`privacy.html` → `page-privacy.php`）。仕様変更時にどちらか一方だけ直して不整合を起こさないよう注意する。
- `kawabata-wp-theme/` — **本番で稼働中のWordPressテーマ**。実質的にこちらが正。

### kawabata-wp-theme/ ファイル構成（現状）

```
kawabata-wp-theme/
├── style.css          テーマ情報・CSS
├── functions.php       テーマ設定、記事データ取得（kawabata_get_articles）、SRI付与、ピックアップ設定メタボックス
├── header.php           共通ヘッダー（<head>、カラートークン C、Header/MobileMenu/Img/Badge等の共通コンポーネント）
├── footer.php            共通フッター
├── index.php             トップページ
├── archive.php           記事一覧・カテゴリアーカイブ（ページネーションあり、2026-08-28〜）
├── single.php             個別記事ページ
├── page-about.php         「私たちについて」固定ページ
├── page-contact.php       「お問い合わせ」固定ページ
├── page-privacy.php       プライバシーポリシー固定ページ
├── js/app.js              補助JS
└── top-template.png       参考画像
```

- サイドバーは独立ファイル化されておらず、各テンプレート内に `Sidebar` コンポーネントとして直接実装されている。
- `404.php` は未作成（現状はWordPress標準の404挙動に依存）。

## WordPress管理画面での初期セットアップ

- `wp-config.php` に以下が必要（本番URLとhttps判定）:
  ```php
  define('WP_HOME', 'https://www.kagoshima-news.jp');
  define('WP_SITEURL', 'https://www.kagoshima-news.jp');
  if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
      $_SERVER['HTTPS'] = 'on';
  }
  define('WP_CACHE', false);
  ```
- 投稿 → カテゴリー に以下を作成しておく必要がある: `鉄道` / `航空` / `船舶` / `バス` / `地域話題` / `鹿児島のイベント` / `記者考察`（`鹿児島県民に読んでほしい記事` / `編集長一押しの記事` は記事ごとのピックアップ設定メタボックスから付与）
- サイドバーの会社紹介画像は `kawabata-wp-theme/images/corporate.jpg` を配置すると表示される（未配置の場合は非表示にフォールバック）
- キャッシュ系・JS圧縮系プラグインはReact/Babelインライン実行と競合しやすいため無効化推奨

## 有効化プラグイン

- **All in One SEO (AIOSEO) 4.9.9** — 記事ごとの title/description/canonical/OGP/Twitter Card/JSON-LD、および `sitemap.xml` 系を自動生成。テーマ側で同等の機能を重複実装しないこと（[history.md](history.md) 2026-07-08参照）。

## デプロイ構成（GitHub Actions / FTP）

- `.github/workflows/deploy-production.yml` / `deploy-staging.yml` が `SamKirkland/FTP-Deploy-Action` で `kawabata-wp-theme/` 配下のみをFTPデプロイする（`.git` / `.github` / `README.md` は除外）。
- 本番・ステージングは同一レンタルサーバー・同一FTPアカウントを想定し、接続情報は共通シークレット、デプロイ先パスのみ分離:
  - `FTP_SERVER` / `FTP_USERNAME` / `FTP_PASSWORD`（共通）
  - `PRODUCTION_THEME_PATH`（例: `/public_html/wp-content/themes/kawabata-wp-theme/`）
  - `STAGING_THEME_PATH`（例: `/public_html/test/wp-content/themes/kawabata-wp-theme/`）
  - パスは先頭・末尾に必ず `/` を付ける。
- ステージング環境を本番と同一データで作る場合、単純なFTPコピーはDB不整合を起こすため、`All-in-One WP Migration` プラグインで `.wpress` としてエクスポート→テスト用WordPressにインポートする方式を使う（エックスサーバー等は「WordPressコピー機能」でも可）。

## 外部リンク・SNS

コンポーネント実装での参照先は `CLAUDE.md` の「外部リンク・SNS」表を参照。

## 残課題

- `sidebar.php` / `404.php` は当初計画されていたが未作成のまま（サイドバーは各テンプレートにインライン実装されており実質不要になった可能性が高い。404は要否含め未確認）。
- AIOSEOのタイトルテンプレート設定はプラグイン管理画面側の調整が必要（[history.md](history.md) 2026-07-08参照）。

---
詳細な変更履歴は [history.md](history.md) を参照。
