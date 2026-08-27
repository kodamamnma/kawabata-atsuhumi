# Project History - 鹿児島地域交通通信社

このファイルは、プロジェクトの変更履歴を時系列（最新順）で記録するものです。

## 2026-08-28

- **記事一覧ページ：過去記事が25件までしか閲覧できない不具合を修正**（`kawabata-wp-theme`）
  - クライアントより「記事一覧から過去記事が全部見れない」と報告。原因は `functions.php` の `kawabata_get_articles()` が `numberposts => 25`（最新25件固定）で投稿を取得しており、`archive.php` にページネーション機構が一切なかったため、25件を超える過去記事にアクセスする手段が存在しなかったこと。
  - `kawabata_get_articles()` を `get_posts()` から `WP_Query` ベースに変更し、`paged` 引数と `max_num_pages` を扱えるようにした（戻り値を配列 `[articles, max_pages]` の連想配列に変更。呼び出し元は `kawabata_enqueue()` のみで影響範囲は限定的）。
  - `kawabata_enqueue()` で現在の `paged`/`page` クエリ変数を取得し、`WP_CURRENT_PAGE` / `WP_MAX_PAGES` をJSに渡すよう追加。
  - `archive.php` に `Pagination` コンポーネントを新規実装（ページ番号送り方式、`get_pagenum_link()` のテンプレート置換パターンでURL生成）。「すべて」カテゴリ表示時のみ表示（カテゴリタブ切り替えは従来通りクライアントサイドフィルタのため、ページ送りとの整合性を考慮）。
  - 1ページあたりの件数（25件）は変更せず維持。件数上限の変更や「もっと見る」ボタン方式は今回未対応（クライアントにページ番号送り方式を確認済み）。
- **散らばっていた `.md` ファイルの整理**
  - `md/wordpress.md`（テーマ構築用プロンプト集）、`git_history.md`（6/11作業ログ）、`kawabata-wp-theme/README.md`（テーマ導入手順・旧版）を廃止し、内容を精査のうえ `CLAUDE.md` / `history.md` / `README.md` の該当箇所へ統合。詳細は各日付のエントリおよび `README.md` を参照。

## 2026-07-08

- **SEO対策：メタタグ実装の試行と方針転換、画像alt属性の最適化**（`kawabata-wp-theme`）
  - Search Console上で「鹿児島 情報発信」等のクエリがインプレッションはあるがクリック0だった問題を受け対応を開始。
  - 当初 `functions.php` に `kawabata_seo_meta()` を実装し、`<title>`/description/canonical/OGP/JSON-LDをテーマ側で動的出力しようとしたが、本番サイト（kagoshima-news.jp）を実機確認した結果 **All in One SEO (AIOSEO) 4.9.9 プラグインが既に有効化されており、記事ごとのtitle/description/canonical/OGP/Twitter Card/JSON-LD（BlogPosting・BreadcrumbList・Organization・Person）をすべて動的生成済み**であることが判明。テーマ側で重複実装するとタグの二重出力（無効なHTML、クローラー混乱）を招くため、`kawabata_seo_meta()` は撤回・削除し、`header.php`/`functions.php` を元の状態に戻した。
  - **教訓**: WordPressサイトのSEO対策時は、コードを書く前に必ず本番HTMLソース（`curl`等）を確認し、稼働中のSEOプラグイン（AIOSEO/Yoast等）の有無を把握すること。テーマファイルの静的解析だけでは既存のプラグイン挙動は分からない。
  - **robots.txt / サイトマップ確認**: 問題なし。`robots.txt` は `/wp-admin/` を除き全許可、`Sitemap: https://kagoshima-news.jp/sitemap.xml` と `sitemap.rss` を参照。AIOSEOが `post-sitemap.xml`/`page-sitemap.xml`/`category-sitemap.xml`/`addl-sitemap.xml` を自動生成・最新化しており対応不要。
  - **画像alt属性の最適化（実施）**: 共通 `Img` コンポーネント（`header.php`）が `alt` プロパティ自体を持たず、記事サムネイル画像に代替テキストが一切出力されていなかった。`alt` propを追加し、`index.php`・`archive.php`・`single.php`・`page-about.php` の全呼び出し箇所で記事タイトル（`title`/`item.title`/`art.title`/`heroArticle.title`）または適切な説明文（会社紹介写真・編集長写真等）を渡すよう修正。
  - 残課題：AIOSEOのタイトルテンプレート設定（トップページタイトルの先頭に不要な「|」が出ている等）はプラグイン管理画面側の設定なので、コード対応の範囲外。Search Consoleのクリック率推移は今後の管理画面側での継続観察が必要。

## 2026-06-24

- **WordPress テーマ カテゴリ表示バグ修正**（`kawabata-wp-theme`）
  - `index.php` 268-269行目: `PICK_CITIZENS` / `PICK_EDITOR` が両方 `cat === '鉄道'` を参照していた問題を修正。それぞれ正しいカテゴリ名（`鹿児島県民に読んでほしい記事` / `編集長一押しの記事`）に変更。
  - `functions.php`: `kawabata_get_articles()` と `kawabata_single_article_data()` のカテゴリマッチングをスラッグ＋名前の二重判定から名前の完全一致のみにシンプル化。`get_term_by` のスラッグフォールバックも削除。
  - 今後カテゴリを追加する場合は `functions.php` の `$priority_names` 配列と `index.php` の `CATS` 配列の両方を更新すること。

## 2026-06-11

- **Gitコミット履歴の巻き戻し作業（カテゴリ優先順位の試行錯誤）**（旧 `git_history.md` より統合）
  - 同日中に「カテゴリ優先順位 修正」（`738a666`）を目標状態として作業していたが、その後の「カテゴリ修正-2」で Revert/Reapply を複数回繰り返す試行錯誤が発生し、最終的に目標だった `738a666` の変更自体まで打ち消されてしまった。
  - 復旧方法として、強制プッシュによる履歴改変は行わず、`738a666` から一時ブランチ `develop-restored` を作成し、`git restore --source=develop-restored --worktree --staged .` で作業ツリーを丸ごと上書きしたうえで新規コミット（`9bab6d5`）として `main` に反映。コミット履歴自体は保持したまま、内容のみ目標状態に復元した。
  - **教訓**: 同一対象への Revert/Reapply の往復は変更の追跡を困難にする。方針を変える場合は都度 Revert するのではなく、目標コミットへ内容を復元する新規コミットを作る方が履歴が読みやすい。

## 2026-05-17

- **デプロイ自動化とステージング環境構築**（`.github/workflows/`、旧 `md/wordpress.md` より統合）
  - SSH（rsync）ベースだったGitHub Actionsのデプロイフローを `SamKirkland/FTP-Deploy-Action` によるFTPデプロイへ移行（`deploy-production.yml` / `deploy-staging.yml`）。`local-dir` を `./kawabata-wp-theme/` に限定し、`.git`/`.github`/`README.md` を除外。
  - 本番・ステージインが同一レンタルサーバーである前提で、FTP接続情報（`FTP_SERVER`/`FTP_USERNAME`/`FTP_PASSWORD`）は共通のGitHub Secretsとし、デプロイ先パスのみ `PRODUCTION_THEME_PATH` / `STAGING_THEME_PATH` で分離。
  - ステージング環境は単純なFTPコピーではDB周りが壊れるため、`All-in-One WP Migration` プラグインによる `.wpress` エクスポート/インポートで本番を丸ごと複製する方式を採用。詳細な運用手順は `README.md` の「デプロイ構成」を参照。
- **JSONインラインスクリプトのパースエラー修正**（`kawabata-wp-theme/functions.php`、旧 `md/wordpress.md` より統合）
  - CDNスクリプトにSRI（`integrity`属性）を付与する `script_loader_tag` フィルターで `str_replace(' src=', ...)` を使っていたため、`wp_add_inline_script()` が出力する記事本文JSON内の `<img src="...">` の ` src=` まで誤って置換され、JSON文字列が破損して `Uncaught SyntaxError` が発生していた。
  - `str_replace` を `preg_replace('/(<script\b[^>]*?) src=/i', ..., 1)` に変更し、`<script>` タグの `src=` のみ・1回限りに置換対象を限定して解決。この実装は現行の `functions.php` にそのまま残っている。

## 2026-05-01

- **英語名称の正式化**
  - `KAGOSHIMA TRAFFIC NEWS` から `Kagoshima regional transport news agency` へ全ての表記を変更。
  - フッター、ヘッダー、メタデータ等の整合性を確保。
- **レスポンシブ・タイポグラフィの実装**
  - ヘッダー内のタイトルおよびキャッチフレーズに `clamp()` 関数を導入。
  - 画面幅に応じてフォントサイズが流動的に変化し、スマートフォン表示でも1行に収まるように調整。
- **ナビゲーションの刷新（ハンバーガーメニュー導入）**
  - ヘッダー右端にラベル付きのハンバーガーボタンを設置。
  - `MobileMenu` コンポーネントを新規実装し、フルスクリーンオーバーレイ形式でカテゴリや会社情報を提供。
  - これに伴い、ヘッダーに配置されていた「概要案内」ボタンおよび「検索バー」をメニュー内へ統合・整理。
- **レイアウトの微調整**
  - メニューがヘッダーの下から出現するように z-index と position を調整。
  - メニュー展開時の背景スクロールを防止する処理を追加。

## 2026-04-30

- **開発規約（CLAUDE.md）の整備**
  - デザインガイドラインおよび共通コンポーネント規約を `CLAUDE.md` に統合。
  - プロジェクト固有のルールと汎用ルールの優先順位を定義。
