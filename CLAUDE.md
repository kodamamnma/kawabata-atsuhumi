# CLAUDE.md — 鹿児島地域交通通信社 ウェブサイト規約

## プロジェクト概要

単一HTMLファイル（React + Babel Standalone）で構成される鹿児島地域交通ニュースサイト。
外部ビルドツールなし。すべてのコードはHTMLファイル内の `<script type="text/babel">` に記述する。

---

## ファイル構成

```
index.html   — すべてのロジック・スタイル・データを含む単一ファイル
CLAUDE.md    — 本ファイル
```

---

## 依存ライブラリ（CDN固定バージョン）

| ライブラリ | バージョン | 用途 |
|---|---|---|
| React | 18.3.1 | UIフレームワーク |
| ReactDOM | 18.3.1 | DOMレンダリング |
| @babel/standalone | 7.29.0 | JSX変換 |
| Noto Sans JP / Noto Serif JP | Google Fonts | 日本語フォント |

バージョンは固定。integrity属性（SRI）を必ず付与すること。

---

## カラートークン

### CSS変数（`:root`）

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

### JSオブジェクト `C`（インラインスタイル用）

CSSと対応する定数オブジェクト。**インラインスタイルには必ずこの `C` オブジェクトを使う**。生のカラーコードをインラインに直書きしない。

```js
const C = {
  main: '#1B3A6B', mainDark: '#122851', mainLight: '#EEF3FA',
  sub: '#2E5FA3', subLight: '#D0DCF0',
  accent: '#E07B1A', accentDark: '#B85E0D',
  t1: '#0F1B2E', t2: '#4A5568', t3: '#7A8A9E',
  border: '#D8E4F0', bg: '#F4F7FB', white: '#FFFFFF',
};
```

---

## カテゴリ定義

### 一覧

```js
const CATS = ['すべて', '鉄道', '航空', '船舶', 'バス', '地域話題'];
```

### カテゴリ色マップ

```js
const CAT_COLORS = {
  '鉄道':   C.main,     // #1B3A6B
  '航空':   '#0D5F7E',
  '船舶':   '#1A6B4A',
  'バス':   C.sub,      // #2E5FA3
  '地域話題': '#6B3FA0',
  'その他': C.t2,
};
```

カテゴリを追加する場合は `CATS`・`CAT_COLORS` 両方を更新する。

---

## コンポーネント規約

### 命名

| コンポーネント | 役割 |
|---|---|
| `Img` | 画像（src失敗時はグラデーションプレースホルダー） |
| `Badge` | カテゴリ・ラベルバッジ |
| `SH` | セクション見出し（左ボーダー付き） |
| `CardH` | 横型記事カード（サムネ左、テキスト右） |
| `CardV` | 縦型記事カード（サムネ上、テキスト下） |
| `Header` | ページヘッダー（検索・SNSリンク含む） |
| `CategoryNav` | カテゴリ切り替えナビ |
| `Breaking` | 速報バナー |
| `Sidebar` | 右サイドバー（会社概要・SNS・連絡先） |
| `SearchResults` | 検索モーダル |
| `Footer` | フッター |

### スタイル指定

- **インラインスタイルのみ**使用する（外部CSSクラスを新設しない）
- グローバル `<style>` はリセット・フォント・変数・リンク色のみ
- ホバー効果は `onMouseEnter` / `onMouseLeave` で `e.currentTarget.style` を直接操作

### `Img` コンポーネント

```jsx
<Img h={高さpx} tone={'a'〜'f'} src={URL} style={{追加スタイル}} />
```

- `src` が未指定または読み込み失敗時 → `tone` に応じたグラデーション表示
- `tone` パレット: `a`（青灰）`b`（緑灰）`c`（茶灰）`d`（紫灰）`e`（青灰薄）`f`（肌灰）

### `Badge` コンポーネント

```jsx
<Badge color={CAT_COLORS[cat]} outline={false} small={false}>{children}</Badge>
```

- 速報バッジ → `color={C.accent}`
- 独自バッジ → `color={'#6B3FA0'}`
- アウトライン → `outline={true}`

---

## 記事データ構造

```js
{
  cat:     string,          // CATS のいずれか（'すべて'以外）
  title:   string,          // 記事タイトル
  time:    string,          // 例: '4月26日 18:30'
  tone:    'a'|'b'|'c'|'d'|'e'|'f',  // Img プレースホルダー色
  badge:   string|undefined, // '速報' | '独自' | undefined
  src:     string|undefined, // 画像URL（省略可）
  summary: string|undefined, // リード文（省略可）
  href:    string|undefined, // 記事URL（省略可、外部リンク）
}
```

記事データはすべて `ALL_ARTICLES` 配列に集約する。コンポーネント内に記事データを直書きしない。

---

## 画像

### Wix CDN形式

```js
const WIX = 'https://static.wixstatic.com/media/';
const IMGS = {
  キー: WIX + 'ハッシュ~mv2.jpg/v1/fill/w_600,h_400,fp_0.50_0.50,q_90,enc_avif,quality_auto/...',
};
```

- 画像URLは `IMGS` オブジェクトに集約し、`WIX` プレフィックスを使う
- 推奨サイズ: `w_600,h_400`, `q_90`, `enc_avif,quality_auto`
- バナー用: `w_1200,h_400`

---

## 外部リンク・SNS

| 媒体 | URL |
|---|---|
| X (Twitter) | `https://twitter.com/humitabphotnews` |
| note | `https://note.com/humitabinewsphot` |
| Instagram | `https://www.instagram.com/humitabiphoto/` |
| TikTok | `https://www.tiktok.com/@humitabitrafficnewsphoto` |
| コーポレートサイト | `https://www.humitabitrafficnews.com/` |
| ニュースサイト概要 | `https://www.humitabitrafficphotonews.com/about-3` |
| 全記事 | `https://www.humitabitrafficphotonews.com/all-news` |
| 概要案内 | `https://www.humitabitrafficnews.com/史旅編集-交通報道について` |
| 編集長メッセージ | `https://www.humitabitrafficnews.com/史旅編集-交通報道について` |
| メール | `humitabiphoto@gmail.com` |

外部リンクは必ず `target="_blank" rel="noreferrer"` を付与する。

---

## レイアウト

- **最大幅**: `1160px`、中央寄せ `margin: '0 auto'`
- **メイングリッド**: `gridTemplateColumns: '1fr 280px'` （左: コンテンツ, 右: サイドバー）
- **カードグリッド**: `repeat(2, 1fr)` gap `10px`
- **左パディング**: `16px`

---

## 状態管理

`useState` のみ使用。外部状態管理ライブラリは導入しない。

| state | 型 | 用途 |
|---|---|---|
| `cat` | string | 選択中カテゴリ |
| `searchOpen` | boolean | 検索バー表示 |
| `searchQuery` | string | 検索文字列 |
| `searching` | boolean | 検索モーダル表示 |

---

## 速報バナー

`Breaking` コンポーネント内のテキストを直接編集する。日付・内容が変わるたびに更新。

---

## コーディングルール

1. JSXはBabel Standaloneで変換。`type="text/babel"` を `<script>` に付与する。
2. `const { useState, useEffect } = React;` のように分割代入でReact APIを取得する。
3. コメントは「なぜそうしているか」が非自明な場合のみ1行で書く。何をしているかの説明は不要。
4. 記事リンクの `href` が実在しない場合は `'#'` を設定し、`target` 属性を省略する。
5. 新カテゴリ追加時: `CATS` → `CAT_COLORS` → `ALL_ARTICLES` の順で更新する。
6. 画像追加時: `IMGS` オブジェクトに追加してから `src={IMGS.キー}` で参照する。
7. `e.currentTarget.style` による直接DOM操作はホバー効果のみに限定する。
