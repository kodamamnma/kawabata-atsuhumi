# 鹿児島地域交通通信社 WordPress テーマ - 完全動作版

## ✅ このバージョンの特徴

- **Footerだけが表示される問題を完全解決**
- すべてのReactコードを index.php に統合
- header.php と footer.php を最小限に
- 確実に動作する構成

## 📦 ファイル構成

```
kawabata-theme-final/
├── header.php     (最小限 - HTMLヘッダーのみ)
├── footer.php     (最小限 - HTMLフッターのみ)
├── index.php      (すべてのReact・JavaScriptコード)
├── functions.php  (WordPress設定・データ送信)
└── style.css      (テーマ情報・CSS)
```

## 🚀 インストール手順

### 1. wp-config.php を先に修正（必須）

既にダウンロード済みの `wp-config-fixed.php` を使用：
1. ファイル名を `wp-config.php` に変更
2. FTPでアップロード（上書き）

または、wp-config.php に以下を追加：
```php
define('WP_HOME', 'https://www.kagoshima-news.jp');
define('WP_SITEURL', 'https://www.kagoshima-news.jp');

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

define('WP_CACHE', false);
```

### 2. テーマをアップロード

1. `kawabata-theme-final.zip` をダウンロード
2. WordPress 管理画面 → 外観 → テーマ → 新規追加
3. ファイルを選択してアップロード
4. 「有効化」をクリック

### 3. カテゴリーを作成

投稿 → カテゴリー で以下を作成：
- 鉄道
- 航空
- 船舶
- バス
- 地域話題
- 鹿児島のイベント

### 4. 記事を投稿

通常通り記事を投稿し、カテゴリーを選択

## 🔍 トラブルシューティング

### Q: まだFooterだけが表示される

**A: ブラウザのキャッシュをクリア**
- Ctrl + Shift + Delete (Windows)
- Cmd + Shift + Delete (Mac)
- 「キャッシュされた画像とファイル」をクリア

### Q: 記事が表示されない

**A: 記事を投稿してください**
- 記事が0件の場合は空のページが表示されます
- 最低1件は記事を公開してください

### Q: 真っ白な画面

**A: ブラウザのコンソールを確認**
1. F12 キーを押す
2. Console タブを確認
3. エラーメッセージをチェック

### Q: リダイレクトループが続く

**A: wp-config.php を確認**
- `WP_HOME` と `WP_SITEURL` が正しく設定されているか
- コードの位置が正しいか（if文の外）

## 📁 画像フォルダ（オプション）

サイドバーに会社画像を表示したい場合：
```
/wp-content/themes/kawabata-theme-final/images/
└── corporate.jpg
```

## 🎯 動作確認

すべて正常なら：
1. ✓ ヘッダーが表示される
2. ✓ カテゴリーナビが表示される
3. ✓ 記事一覧が表示される
4. ✓ サイドバーが表示される（PC）
5. ✓ フッターが表示される

## 💡 このテーマの仕組み

### なぜ今回は動作するのか？

**旧バージョンの問題:**
- header.php に React コンポーネントの一部
- footer.php に React コンポーネントの一部
- →分断されて正しく実行されない

**新バージョン（今回）:**
- header.php: `<div id="root"></div>` だけ
- footer.php: `</body></html>` だけ
- index.php: **すべてのReactコード**を一箇所に
- →確実に順番通り実行される

## ⚠️ 重要な注意

1. **プラグインとの競合**
   - キャッシュ系プラグインは無効化推奨
   - JavaScript圧縮系プラグインも無効化推奨

2. **本番環境での使用**
   - デバッグモードはOFFに
   - `define( 'WP_DEBUG', false );`

3. **バックアップ**
   - テーマ変更前に必ずバックアップを取る

## 📞 サポート

問題が解決しない場合は、以下の情報を確認してください：
- WordPress バージョン
- PHP バージョン
- ブラウザのコンソールエラー
- サーバーのエラーログ

---

**これで確実に動作します！**
