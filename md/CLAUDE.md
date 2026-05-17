# CLAUDE.md — 鹿児島地域交通通信社 ウェブサイト規約

## プロジェクト概要

単一HTMLファイル（React + Babel Standalone）で構成される鹿児島地域交通ニュースサイト。
外部ビルドツールなし。すべてのコードはHTMLファイル内の `<script type="text/babel">` に記述する。

### サイト名称

| 言語 | 名称 |
|---|---|
| 日本語 | 鹿児島地域交通通信社 |
| 英語 | Kagoshima regional transport news agency |

---

## ファイル構成

```
index.html   — すべてのロジック・スタイル・データを含む単一ファイル
CLAUDE.md    — 開発規約・プロジェクト概要
history.md   — 時系列の変更履歴
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
const CATS = ['すべて', '鉄道', '航空', '船舶', 'バス', '地域話題', '鹿児島のイベント'];
```

### カテゴリ色マップ

```js
const CAT_COLORS = {
  '鉄道':   C.main,     // #1B3A6B
  '航空':   '#0D5F7E',
  '船舶':   '#1A6B4A',
  'バス':   C.sub,      // #2E5FA3
  '地域話題': '#6B3FA0',
  '鹿児島のイベント': '#B85E0D',
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
| `Header` | ページヘッダー（検索・ハンバーガーメニューボタン含む） |
| `MobileMenu` | ハンバーガーメニューオーバーレイ（カテゴリ・概要・SNS・連絡先） |
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
| 概要案内 | `about.html` |
| 編集長メッセージ | `https://www.humitabitrafficnews.com/史旅編集-交通報道について` |
| メール | `humitabiphoto@gmail.com` |

外部リンクは必ず `target="_blank" rel="noreferrer"` を付与する。

---

## レイアウト

- **最大幅**: `1160px`、中央寄せ `margin: '0 auto'`
- **メイングリッド**: `gridTemplateColumns: '1fr 280px'` （左: コンテンツ, 右: サイドバー）
- **カードグリッド**: `repeat(2, 1fr)` gap `10px`
- **左パディング**: `16px`

### レスポンシブ対応状況

- 現状、スマホ用のレスポンシブ対応は **未実装**
- グリッドレイアウトやサイドバーがスマホでもそのまま表示される
- 将来的にメディアクエリまたはインラインスタイルによるレスポンシブ対応を予定

---

## 状態管理

`useState` のみ使用。外部状態管理ライブラリは導入しない。

| state | 型 | 用途 |
|---|---|---|
| `cat` | string | 選択中カテゴリ |
| `searchOpen` | boolean | 検索バー表示 |
| `searchQuery` | string | 検索文字列 |
| `searching` | boolean | 検索モーダル表示 |
| `menuOpen` | boolean | ハンバーガーメニュー表示 |

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

---

# カスタマイズガイドライン（汎用デザイン規約）

> **注意**: 以下は新規HTML/CSSプロジェクト向けの汎用デザイン規約である。上記の「プロジェクト固有ルール」と衝突する場合は、**プロジェクト固有の値が優先**される。

## はじめに

本ガイドラインは、ホームページ制作におけるデザインの一貫性を保ち、効率的な作業を推進することを目的とする。対象読者は、ホームページのデザインおよびコーディングを担当する者である。本ガイドラインの遵守は、高品質なホームページ制作の実現に不可欠である。参照すべきドキュメントは、基本デザインルールおよび共通コンポーネント定義書である。

---

## 基本デザインルール

### カラールール

| 項目 | 値 |
|---|---|
| 背景カラー | `#f0f0f0` |
| メインカラー | プロジェクトごとに設定 |
| アクセントカラー | プロジェクトごとに設定 |
| テキストカラー | `#222` |

### フォントルール

**デフォルトフォント**: Noto Sans JP / Noto Serif JP

#### 見出しフォント

| 要素 | サイズ | font-weight | line-height |
|---|---|---|---|
| H1 | 48px | Bold (700) | 1.2 |
| H2 | 40px | Bold (700) | 1.2 |
| H3 | 32px | Medium (500) | 1.3 |
| H4 | 24px | Medium (500) | 1.4 |
| H5 | 16px | Regular (400) | 1.5 |
| H6 | 8px | Regular (400) | 1.5 |

- `letter-spacing`: 必要に応じて指定（例: `0em`）

#### 本文

- フォントファミリー: Noto Sans JP
- ウェイト: Regular (400)
- サイズ: 16px
- line-height: 1.6
- letter-spacing: 必要に応じて指定（例: `0.05em`）

#### 注釈・キャプション

- フォントファミリー: Noto Sans JP
- ウェイト: Regular (400) または Light (300)
- サイズ: 14px
- line-height: 1.5

#### ヘッダー文字サイズ

- ヘッダー内のテキスト: **12px**

#### レスポンシブ時のフォントサイズ

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

---

## 余白ルール

### ヘッダー・ヒーロー・フッター

| 要素 | margin | padding |
|---|---|---|
| ヘッダー `<header>` | `margin: 0` | 垂直: `16px 0`、水平: `2.5%` |
| ヒーローセクション | `margin: 0` | — |
| フッター `<footer>` | `margin: 0` | 垂直: `24px 0`、水平: `2.5%` |

### main タグ

- `padding`: `2.5%`（小さな画面では `1%`）
- 水平パディング: `2.5%`

### 主要セクション間

- 垂直マージン: 原則 **40px**

### main タグ内 垂直マージン

| 要素の関係 | margin |
|---|---|
| 見出し直後の段落 | `margin-bottom: 16px` |
| 段落同士の間 | `margin-bottom: 16px` |
| 画像直前・直後の段落 | `margin-top: 24px`, `margin-bottom: 24px` |
| リスト直前・直後の段落 | `margin-top: 24px`, `margin-bottom: 24px` |
| 水平線 | `margin-top: 32px`, `margin-bottom: 32px` |

### レスポンシブ時

- 垂直セクション間マージン（小画面）: **20px**
- 水平方向パディング: **5%**

---

## 画像の扱いルール

| 項目 | 規定 |
|---|---|
| 画像形式 | 原則 WebP (`.webp`) |
| ロゴ形式 | SVG (`.svg`) 推奨、不可の場合 WebP |
| アニメーションGIF | 使用を避ける。`<video>` + MP4 を検討 |
| alt属性 | 必ず適切な内容を記述。装飾目的は `alt=""` |
| Lazy Loading | 初期表示不要な画像に `loading="lazy"` を積極導入 |
| CSSルール | `max-width: 100%; height: auto;` を適用（原則） |
| `<img>`タグ | `width` 属性と `height` 属性を記述 |
| 著作権 | 遵守する。フリー素材は利用規約確認・クレジット表記 |

### レスポンシブイメージ推奨

```html
<picture>
  <source media="(max-width: 767px)" srcset="image-mobile.webp">
  <source media="(min-width: 768px)" srcset="image-desktop.webp">
  <img src="image-fallback.webp" alt="説明">
</picture>
```

---

## バナーサイズ

| 種類 | サイズ |
|---|---|
| 一般的なバナー | 468×60 |
| パソコンのバナー | 728×90 |
| パソコンのサイドバーのバナー | 120×600 |

---

## 共通コンポーネント

### ボタン（`.button` クラス）

**構造**:
```html
<button class="button [modifier]"><span>テキスト</span></button>
```
リンク時は `<a>` タグに `.button` クラス。

**スタイリング**:

| 状態 | テキストカラー | 背景色 | ボーダー |
|---|---|---|---|
| 通常 | `#f0f0f0` | `green` | `1px solid green` |
| ホバー | `green` | `transparent` | `1px solid green` |

- パディング: `12px 24px`
- 角丸: `4px`

**バリエーション**:

| クラス | 用途 |
|---|---|
| `.button-primary` | 主要アクション |
| `.button-secondary` | 二次アクション（テキスト: green、背景: transparent、ボーダー: 1px solid green） |
| `.button-text` | テキストリンク風（背景・ボーダーなし） |

**注意事項**:
- `<button>` タグは `type` 属性を設定（submit, button, reset）
- リンクの場合は `href` 属性を記述
- テキストはアクション内容を明確に

### 見出し（`.heading` クラス）

**構造**: `<h1>` 〜 `<h6>` タグ使用。必要に応じて `.heading` クラス。

**modifier クラス**:

| クラス | 対応タグ | font-size |
|---|---|---|
| `.heading-level1` | `<h1>` | 48px |
| `.heading-level2` | `<h2>` | 40px |
| `.heading-level3` | `<h3>` | 32px |
| `.heading-level4` | `<h4>` | 24px |
| `.heading-level5` | `<h5>` | 16px |
| `.heading-level6` | `<h6>` | 8px |

**注意事項**:
- `<h1>` タグは原則ページに一つのみ
- `.heading-levelX` クラスでスタイル統一

### ハンバーガーメニュー（`.hamburger-morph` クラス）

**HTML構造**:
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

**CSS**:
```css
/* ハンバーガーボタン本体 */
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

.hamburger-morph__icon {
  width: 100%;
  height: 100%;
}

/* 3本線のスタイルとアニメーション */
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

/* active 時の変化 */
.hamburger-morph.active .hamburger-morph__line:nth-child(1) {
  stroke-dasharray: 90 207;
  stroke-dashoffset: -134;
}
.hamburger-morph.active .hamburger-morph__line:nth-child(2) {
  stroke-dasharray: 1 60;
  stroke-dashoffset: -30;
}
.hamburger-morph.active .hamburger-morph__line:nth-child(3) {
  stroke-dasharray: 90 207;
  stroke-dashoffset: -134;
}

/* ナビゲーションメニュー */
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

.nav-morph.active {
  clip-path: circle(150% at calc(100% - 44px) 44px);
}

.nav-morph__wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
}

.nav-morph__list {
  margin: 0;
  padding: 2.5%;
  list-style: none;
  text-align: center;
  border-radius: 24px;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
}

/* メニュー項目のフェードイン */
.nav-morph__item {
  opacity: 0;
  transition: opacity 0.2s ease, transform 0.2s ease;
}

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
.nav-morph__hover {
  transition: transform 0.3s ease;
}
```

**JavaScript**:
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

  // メニューリンクのホバーエフェクト
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

### カード型レイアウト（`.card` クラス）

**スタイリング**:
- `.card`: 背景色、ボーダー、シャドウ、角丸
- `.card-body`: タイトル、テキスト、ボタンの配置と余白
- `.card-title`: カードタイトル（`.heading-level3` 適用可）
- `.card-text`: 説明文
- デバイス幅 **767px以下** で一列表示

### フォーム要素

**クラス**:
- `.form-group`: ラベルと入力フィールドのグループ化
- `.form-control`: テキスト入力、セレクトボックスの基本スタイル
- `.form-button`: 送信ボタン（`.button` クラスと併用）

**注意事項**:
- `<label>` の `for` 属性と `<input>` の `id` 属性を適切に関連付け
- プレースホルダーはラベルの代替としない
- バリデーション・エラーメッセージを適切に表示
- `aria-` 属性を使用

---

## レスポンシブデザイン

### ブレークポイント

| デバイス | 条件 |
|---|---|
| スマートフォン | `max-width: 767px` |
| タブレット | `min-width: 768px` かつ `max-width: 1024px` |
| PC・デスクトップ | `min-width: 1025px` |

### viewport 設定

```html
<meta name="viewport" content="width=device-width, initial-scale=1.0">
```

### メディアクエリ

```css
@media screen and (max-width: 767px) { /* スマートフォン向け */ }
@media screen and (min-width: 768px) and (max-width: 1024px) { /* タブレット向け */ }
@media screen and (min-width: 1025px) { /* PC・デスクトップ向け */ }
```

### レイアウト方針

- **スマートフォン**: シングルカラム、ハンバーガーメニュー、`max-width: 100%`
- **タブレット**: 2カラム検討、水平メニュー検討
- **PC・デスクトップ**: 複数カラム/グリッド活用、ホバーエフェクト

### 柔軟なユニット

固定ピクセル (`px`) だけでなく、相対ユニット (`%`, `em`, `rem`, `vw`, `vh`) を積極的に使用。

---

## アクセシビリティ

- **色のコントラスト比**: WCAG 2.0 AA 基準を遵守
- **キーボード操作**: ナビゲーション・フォーム要素をキーボードで操作可能に
- **aria属性**: WAI-ARIA属性を適切に使用
- ハンバーガーメニューに `aria-controls`、`aria-expanded` を設定

---

## JavaScript ルール

- 使用するライブラリやフレームワークはプロジェクトごとに制限・推奨を設定
- コーディング規約（変数の命名規則、コード構造など）を遵守
- DOMContentLoaded イベント内で初期化処理を行う

---

## タグのクラス名規約

| 要素 | クラス名 |
|---|---|
| 見出し | `.heading` をつける |
| ハンバーガーメニューボタン | `.hamburger-morph` |
| ナビゲーション | `.nav-morph` |
| ボタン | `.button` |
| カード | `.card` |
| フォームグループ | `.form-group` |
| フォーム入力 | `.form-control` |

---

## 更新履歴

詳細は [history.md](history.md) を参照。

### 2026-05-01
- **英語名称の正式化**: `KAGOSHIMA TRAFFIC NEWS` から `Kagoshima regional transport news agency` へ全ての表記を変更。
- **レスポンシブ・フォントサイズの実装**: ヘッダー内の「鹿児島地域交通通信社」「公共交通と地域文化を世の中へ」「Kagoshima regional transport news agency」に `clamp()` を適用。画面幅に応じて文字サイズが自動縮小し、1行に収まるように調整。
- **ハンバーガーメニューの実装**:
    - ヘッダー右端に「メニュー」ラベル付きのハンバーガーボタンを設置。
    - フルスクリーンオーバーレイ形式の `MobileMenu` コンポーネントを実装。
    - メニュー内に「カテゴリ」「当社について」「公式SNS」「お問い合わせ」を集約。
    - メニューがヘッダーの下から表示されるようにレイアウトを調整。
- **ヘッダー要素の整理**: 「概要案内」ボタンおよび「検索」ボタン（入力欄含む）を削除し、ハンバーガーメニューへ統合。

