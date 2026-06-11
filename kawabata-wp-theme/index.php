<?php get_header(); ?>

<script type="text/babel">
/* global WP_ARTICLES */

/* ─── Like / Share button ─── */
const LikeShare = ({ title, href }) => {
  const [liked, setLiked] = React.useState(false);
  const [likes, setLikes] = React.useState(Math.floor(Math.random() * 30) + 1);
  const handleLike = (e) => {
    e.preventDefault(); e.stopPropagation();
    setLiked(!liked);
    setLikes(prev => liked ? prev - 1 : prev + 1);
  };
  const shareText = encodeURIComponent(title);
  const shareUrl = encodeURIComponent(href || window.location.href);
  const tweetUrl = `https://twitter.com/intent/tweet?text=${shareText}&url=${shareUrl}`;
  return (
    <div style={{ display: 'flex', gap: 8, alignItems: 'center', marginTop: 8 }} onClick={e => e.preventDefault()}>
      <button onClick={handleLike} style={{
        display: 'flex', alignItems: 'center', gap: 4, padding: '4px 10px',
        borderRadius: 20, border: `1px solid ${liked ? C.accent : C.border}`,
        background: liked ? '#FFF4EA' : 'transparent', color: liked ? C.accent : C.t3,
        fontSize: 11, fontWeight: 700, cursor: 'pointer', fontFamily: 'inherit',
        transition: 'all 0.2s',
      }}>
        <span style={{ fontSize: 13 }}>{liked ? '♥' : '♡'}</span>{likes}
      </button>
      <a href={tweetUrl} target="_blank" rel="noreferrer" onClick={e => e.stopPropagation()} style={{
        display: 'flex', alignItems: 'center', gap: 4, padding: '4px 10px',
        borderRadius: 20, border: `1px solid ${C.border}`, background: 'transparent',
        color: C.t3, fontSize: 11, fontWeight: 700, textDecoration: 'none',
        transition: 'all 0.2s',
      }}
        onMouseEnter={e => { e.currentTarget.style.background = '#000'; e.currentTarget.style.color = '#fff'; e.currentTarget.style.borderColor = '#000'; }}
        onMouseLeave={e => { e.currentTarget.style.background = 'transparent'; e.currentTarget.style.color = C.t3; e.currentTarget.style.borderColor = C.border; }}
      >
        <span style={{ fontSize: 12, fontWeight: 900 }}>𝕏</span> シェア
      </a>
    </div>
  );
};

/* ─── Category nav ─── */
const CategoryNav = ({ active, onChange }) => (
  <nav style={{ background: C.white, borderBottom: `1px solid ${C.border}`, overflowX: 'auto' }}>
    <div style={{ maxWidth: 1160, margin: '0 auto', padding: '0 16px', display: 'flex' }}>
      {CATS.map(c => (
        <button key={c} onClick={() => onChange(c)} style={{
          padding: '10px 16px', fontSize: 13, fontWeight: active === c ? 700 : 500,
          color: active === c ? C.main : C.t2,
          background: 'none', border: 'none',
          borderBottom: active === c ? `3px solid ${C.main}` : '3px solid transparent',
          whiteSpace: 'nowrap', cursor: 'pointer',
        }}>{c}</button>
      ))}
    </div>
  </nav>
);

/* ─── Article cards ─── */
const CardH = ({ cat, title, time, tone = 'a', summary, src, href }) => (
  <a href={href || '#'} target={href && href !== '#' ? '_blank' : undefined} rel="noreferrer" style={{ textDecoration: 'none' }}>
    <div style={{
      background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)',
      display: 'flex', overflow: 'hidden', cursor: 'pointer',
    }}
      onMouseEnter={e => e.currentTarget.style.boxShadow = '0 4px 12px rgba(27,58,107,0.16)'}
      onMouseLeave={e => e.currentTarget.style.boxShadow = '0 1px 4px rgba(27,58,107,0.10)'}
    >
      <Img h={92} tone={tone} src={src} style={{ width: 120 }} />
      <div style={{ padding: '10px 13px', flex: 1, minWidth: 0 }}>
        <div style={{ display: 'flex', gap: 5, marginBottom: 5, flexWrap: 'wrap' }}>
          <Badge color={CAT_COLORS[cat] || C.main}>{cat}</Badge>
        </div>
        <div style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 13, fontWeight: 700, lineHeight: 1.45, color: C.t1, marginBottom: summary ? 5 : 0 }}>{title}</div>
        {summary && <div style={{ fontSize: 11, color: C.t2, lineHeight: 1.6, overflow: 'hidden', display: '-webkit-box', WebkitLineClamp: 2, WebkitBoxOrient: 'vertical' }}>{summary}</div>}
        <div style={{ fontSize: 10, color: C.t3, marginTop: 5 }}>{time}</div>
        <LikeShare title={title} href={href} />
      </div>
    </div>
  </a>
);

const CardV = ({ cat, title, time, tone = 'a', src, href }) => (
  <a href={href || '#'} target={href && href !== '#' ? '_blank' : undefined} rel="noreferrer" style={{ textDecoration: 'none', flex: 1, minWidth: 0, display: 'block' }}>
    <div style={{
      background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)',
      overflow: 'hidden', cursor: 'pointer', height: '100%',
    }}
      onMouseEnter={e => e.currentTarget.style.boxShadow = '0 4px 12px rgba(27,58,107,0.16)'}
      onMouseLeave={e => e.currentTarget.style.boxShadow = '0 1px 4px rgba(27,58,107,0.10)'}
    >
      <Img h={116} tone={tone} src={src} style={{ width: '100%' }} />
      <div style={{ padding: '10px 12px 13px' }}>
        <div style={{ display: 'flex', gap: 5, marginBottom: 5 }}>
          <Badge color={CAT_COLORS[cat] || C.main}>{cat}</Badge>
        </div>
        <div style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 13, fontWeight: 700, lineHeight: 1.45, color: C.t1 }}>{title}</div>
        <div style={{ fontSize: 10, color: C.t3, marginTop: 5 }}>{time}</div>
      </div>
    </div>
  </a>
);

/* ─── Sidebar ─── */
const Sidebar = () => (
  <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
    <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', overflow: 'hidden' }}>
      <div style={{ background: C.main, color: '#fff', padding: '10px 14px', fontSize: 13, fontWeight: 700 }}>当社について</div>
      <Img h={100} tone="a" src={IMGS.corporate} style={{ width: '100%' }} />
      <div style={{ padding: '14px' }}>
        <div style={{ fontSize: 13, fontWeight: 700, color: C.main, marginBottom: 6 }}>鹿児島地域交通通信社</div>
        <div style={{ fontSize: 12, color: C.t2, lineHeight: 1.75, marginBottom: 12 }}>
        「公共交通と地域文化を世の中へ」を目指して、鹿児島県内の公共交通と地域情報を中心に取材・報道する個人運営のメディアです。2019年YouTubeチャンネル「ふみたび」から始まり、2026年に現在の名称へ。
        <a href="<?php echo home_url('/about/'); ?>" style={{
          display: 'block', textAlign: 'center', background: C.main, color: '#fff',
          borderRadius: 4, padding: '8px 0', fontSize: 12, fontWeight: 700,
        }}>概要案内を読む →</a>
      </div>
    </div>
    <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', overflow: 'hidden' }}>
      <div style={{ background: C.main, color: '#fff', padding: '10px 14px', fontSize: 13, fontWeight: 700 }}>公式SNS・メディア</div>
      <div style={{ padding: '12px 14px', display: 'flex', flexDirection: 'column', gap: 8 }}>
        {[
          { lbl: 'X（旧Twitter）',          href: 'https://twitter.com/humitabphotnews',             color: '#000' },
          { lbl: 'Instagram — 写真・動画',   href: 'https://www.instagram.com/humitabiphoto/',          color: '#C13584' },
          { lbl: 'TikTok — 動画コンテンツ', href: 'https://www.tiktok.com/@humitabitrafficnewsphoto', color: '#010101' },
        ].map(({ lbl, href, color }) => (
          <a key={lbl} href={href} target="_blank" rel="noreferrer" style={{
            display: 'flex', alignItems: 'center', gap: 8, padding: '7px 10px',
            borderRadius: 4, background: C.bg, fontSize: 12, color: C.t1,
            border: `1px solid ${C.border}`,
          }}>
            <span style={{ width: 8, height: 8, borderRadius: '50%', background: color, flexShrink: 0 }}></span>
            {lbl}
          </a>
        ))}
      </div>
    </div>
    <div style={{ background: C.main, borderRadius: 4, padding: 16, color: '#fff' }}>
      <div style={{ fontSize: 12, opacity: 0.75, marginBottom: 4 }}>お問い合わせ</div>
      <div style={{ fontSize: 13, fontWeight: 700, marginBottom: 8 }}>E-MAIL</div>
      <a href="mailto:humitabiphoto@gmail.com" style={{
        display: 'block', background: C.accent, color: '#fff', borderRadius: 4,
        padding: '8px 12px', fontSize: 12, fontWeight: 700, textAlign: 'center',
        wordBreak: 'break-all',
      }}>humitabiphoto@gmail.com</a>
      <div style={{ fontSize: 10, opacity: 0.6, marginTop: 8, lineHeight: 1.6 }}>お電話での対応は行っておりません。</div>
    </div>
  </div>
);

/* ─── Search modal ─── */
const SearchResults = ({ query, articles, onClose }) => {
  const hits = articles.filter(a =>
    a.title.includes(query) || a.cat.includes(query) || (a.summary || '').includes(query)
  );
  return (
    <div style={{ position: 'fixed', inset: 0, zIndex: 500, background: 'rgba(15,27,46,0.6)', display: 'flex', alignItems: 'flex-start', justifyContent: 'center', padding: '80px 16px' }}
      onClick={onClose}>
      <div style={{ background: C.white, borderRadius: 6, width: '100%', maxWidth: 700, boxShadow: '0 8px 32px rgba(15,27,46,0.25)', overflow: 'hidden' }}
        onClick={e => e.stopPropagation()}>
        <div style={{ background: C.main, padding: '12px 16px', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
          <span style={{ color: '#fff', fontWeight: 700 }}>「{query}」の検索結果 — {hits.length}件</span>
          <button onClick={onClose} style={{ background: 'none', border: 'none', color: '#fff', fontSize: 18 }}>✕</button>
        </div>
        <div style={{ maxHeight: 500, overflowY: 'auto', padding: 16, display: 'flex', flexDirection: 'column', gap: 10 }}>
          {hits.length === 0
            ? <div style={{ color: C.t3, textAlign: 'center', padding: '32px 0' }}>該当する記事が見つかりませんでした</div>
            : hits.map((a, i) => <CardH key={i} {...a} />)
          }
        </div>
      </div>
    </div>
  );
};

/* ─── Article data ─── */
const STATIC_ARTICLES = [
  {
    cat: '鉄道', title: '観光列車「おれんじ食堂」、指宿枕崎線・枕崎駅へ初乗り入れ　ツアー客が列車の旅楽しむ',
    time: '4月26日 18:30', tone: 'a', src: IMGS.orenjiShokudo,
    summary: '肥薩おれんじ鉄道の観光列車「おれんじ食堂」を用いた特別運行が4月25日・26日の2日間実施された。通常乗り入れない指宿枕崎線の枕崎駅へ初めて入線した。',
    href: '/articles/orenji-shokudo/',
  },
  {
    cat: '鉄道', title: '鹿児島市電「チャギントン電車」4月28日で運行終了　約4年の歴史に幕',
    time: '4月28日 10:00', tone: 'b', src: IMGS.chagington,
    summary: '鹿児島市交通局は、イギリスの人気鉄道アニメ「チャギントン」のラッピング電車の運行を4月28日（火）をもって終了すると発表した。2022年2月から約4年間走り続けた。',
    href: '#',
  },
  {
    cat: '航空', title: '国内線にも波及する燃油高騰、FDA静岡＝鹿児島線は5月発券分3,000円',
    time: '4月25日 14:00', tone: 'c', src: IMGS.fda,
    summary: 'FDAは2026年5月1日〜31日発券分の燃油特別付加運賃を発表。鹿児島県と本州を結ぶ静岡＝鹿児島線を含むCグループは1区間3,000円となる。',
    href: '#',
  },
  {
    cat: 'バス', title: '霧島神宮アクセスバス、4月1日よりダイヤ改正　土日祝の夕方増便で利便性向上',
    time: '4月1日 09:00', tone: 'd', src: IMGS.kirishima,
    summary: '霧島市は鹿児島空港〜霧島神宮を結ぶアクセスバスのダイヤ改正を実施。土日祝の17時20分発を新設し、始発を9時30分発に変更した。',
    href: '#',
  },
  {
    cat: '鉄道', title: '指宿枕崎線・山川〜枕崎間、JR九州が存廃協議の意向を表明',
    time: '4月20日', tone: 'e',
    summary: 'JR九州は利用者数が極めて少ない指宿枕崎線の山川〜枕崎間について、沿線自治体との存廃協議を開始する意向を示した。',
    href: '#',
  },
  {
    cat: 'バス', title: '鹿児島市内路線バス、夜間便の一部運休を5月より実施　運転士不足が原因',
    time: '4月18日', tone: 'a', href: '#',
  },
  {
    cat: '船舶', title: '桜島フェリー、GW期間中の増便ダイヤを発表　最大10分間隔で運行',
    time: '4月15日', tone: 'b', href: '#',
  },
  {
    cat: '地域話題', title: '出水商業高校生がおれんじ食堂ツアーをプロデュース　受付からガイドまで担当',
    time: '4月26日', tone: 'f', src: IMGS.orenjiShokudo, href: '#',
  },
  {
    cat: '船舶', title: '鹿児島〜沖縄フェリー「マルエーフェリー」、新造船を2027年に投入へ',
    time: '4月12日', tone: 'e',
    summary: 'マルエーフェリーは、鹿児島〜奄美〜沖縄航路に2027年就航予定の新造フェリーの概要を発表。環境性能を大幅に向上させた次世代船となる。',
    href: '#',
  },
  {
    cat: '地域話題', title: '鹿児島中央駅前広場リニューアル完成　観光客・市民の交流拠点に',
    time: '4月5日', tone: 'c',
    summary: '鹿児島市の玄関口である鹿児島中央駅前広場のリニューアル工事が完成。公共交通との乗り継ぎ利便性が向上し、新たなにぎわいの場として期待される。',
    href: '#',
  },
  {
    cat: '航空', title: '鹿児島〜台北（桃園）線、春季から増便　LCCが週4便体制へ',
    time: '4月3日', tone: 'd', href: '#',
  },
  {
    cat: 'バス', title: '鹿児島県、BRT（バス高速輸送）導入の検討会を設置　廃線区間の代替手段として',
    time: '3月28日', tone: 'a', href: '#',
  },
  {
    cat: '鉄道', title: '南九州西回り自動車道の延伸でバス路線新設　阿久根〜川内間が約40分短縮',
    time: '4月10日', tone: 'c', href: '#',
  },
  {
    cat: '航空', title: '鹿児島空港、2025年度旅客数が過去最高更新　国際線の回復顕著',
    time: '4月8日', tone: 'd', href: '#',
  },
  {
    cat: '鹿児島のイベント', title: '桜島火の島まつり2026、7月開催決定　海上花火と迫力の噴火を同時体験',
    time: '5月1日', tone: 'c',
    summary: '鹿児島市は2026年の「桜島火の島まつり」を7月27日に開催すると発表。海上花火大会と桜島の自然景観を楽しめる夏の恒例イベント。',
    href: '#',
  },
  {
    cat: '鹿児島のイベント', title: '鹿児島おはら祭2026、11月に開催　全国から踊り連1万人規模',
    time: '4月22日', tone: 'd', href: '#',
  },
];

const ALL_ARTICLES = (typeof WP_ARTICLES !== 'undefined' && Array.isArray(WP_ARTICLES) && WP_ARTICLES.length > 0)
  ? WP_ARTICLES
  : STATIC_ARTICLES;

const PICK_CITIZENS = ALL_ARTICLES.find(a => a.cat === '鉄道') || ALL_ARTICLES[0];
const PICK_EDITOR   = ALL_ARTICLES.find(a => a.cat === '鉄道' && a !== PICK_CITIZENS) || ALL_ARTICLES[1];

/* ─── App ─── */
function App() {
  const [cat, setCat] = useState('すべて');
  const [searchOpen, setSearchOpen] = useState(false);
  const [searchQuery, setSearchQuery] = useState('');
  const [searching, setSearching] = useState(false);
  const [menuOpen, setMenuOpen] = useState(false);

  const handleSearch = q => { if (q.trim()) setSearching(true); };

  const filtered = cat === 'すべて' ? ALL_ARTICLES : ALL_ARTICLES.filter(a => a.cat === cat);
  const heroArticle = filtered[0];
  const subArticles = filtered.slice(1, 5);
  const listArticles = filtered.slice(5);

  return (
    <div>
      <Header
        onSearch={handleSearch}
        searchOpen={searchOpen}
        setSearchOpen={setSearchOpen}
        searchQuery={searchQuery}
        setSearchQuery={setSearchQuery}
        menuOpen={menuOpen}
        setMenuOpen={setMenuOpen}
      />
      <MobileMenu open={menuOpen} onClose={() => setMenuOpen(false)} onCategoryChange={c => setCat(c)} />
      <CategoryNav active={cat} onChange={c => setCat(c)} />

      <main style={{ maxWidth: 1160, margin: '0 auto', padding: '20px 16px 0' }}>
        <div className="layout-grid">

          {heroArticle && (
            <div className="hero-section" style={{ marginBottom: 20 }}>
              <a href={heroArticle.href || '#'} target={heroArticle.href && heroArticle.href !== '#' ? '_blank' : undefined} rel="noreferrer" style={{ textDecoration: 'none', display: 'block' }}>
                <div style={{
                  background: C.white, borderRadius: 4, overflow: 'hidden',
                  boxShadow: '0 1px 4px rgba(27,58,107,0.10)', cursor: 'pointer',
                }}
                  onMouseEnter={e => e.currentTarget.style.boxShadow = '0 4px 12px rgba(27,58,107,0.16)'}
                  onMouseLeave={e => e.currentTarget.style.boxShadow = '0 1px 4px rgba(27,58,107,0.10)'}
                >
                  <Img h={240} tone={heroArticle.tone} src={heroArticle.src} style={{ width: '100%' }} />
                  <div style={{ padding: '14px 16px 18px' }}>
                    <div style={{ display: 'flex', gap: 6, marginBottom: 8 }}>
                      <Badge color={CAT_COLORS[heroArticle.cat] || C.main}>{heroArticle.cat}</Badge>
                    </div>
                    <div style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 22, fontWeight: 700, lineHeight: 1.4, color: C.t1, marginBottom: 10 }}>
                      {heroArticle.title}
                    </div>
                    {heroArticle.summary && (
                      <div style={{ fontSize: 13, color: C.t2, lineHeight: 1.75, marginBottom: 8 }}>
                        {heroArticle.summary}
                      </div>
                    )}
                    <div style={{ fontSize: 11, color: C.t3 }}>{heroArticle.time}</div>
                  </div>
                </div>
              </a>
            </div>
          )}

          <div className="featured-section" style={{ marginBottom: 24 }}>
            <div className="featured-grid">
              <div>
                <div style={{ borderLeft: `4px solid ${C.accent}`, paddingLeft: 10, marginBottom: 10 }}>
                  <span style={{ fontSize: 13, fontWeight: 700, color: C.t1 }}>🏠 鹿児島県民に読んでほしい記事</span>
                </div>
                <CardV {...PICK_CITIZENS} />
              </div>
              <div>
                <div style={{ borderLeft: `4px solid #6B3FA0`, paddingLeft: 10, marginBottom: 10 }}>
                  <span style={{ fontSize: 13, fontWeight: 700, color: C.t1 }}>✍️ 編集長一押しの記事</span>
                </div>
                <CardV {...PICK_EDITOR} />
              </div>
            </div>
          </div>

          <div className="latest-news" style={{ marginBottom: 0 }}>
            <SH color={C.main}>最新ニュース</SH>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 10, marginBottom: 16 }}>
              {subArticles.slice(0, 4).map((a, i) => <CardH key={i} {...a} />)}
            </div>
          </div>

          <div className="ad-space" style={{
            marginBottom: 24, background: C.border, borderRadius: 4,
            height: 90, display: 'flex', alignItems: 'center', justifyContent: 'center',
            border: `1px dashed ${C.t3}`,
          }}>
            <span style={{ fontSize: 11, color: C.t3, letterSpacing: '0.08em' }}>広 告</span>
          </div>

          {listArticles.length > 0 && (
            <div className="other-articles">
              <SH color={C.sub}>その他の記事</SH>
              <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', overflow: 'hidden', marginBottom: 24 }}>
                {listArticles.map((a, i) => (
                  <div key={i} style={{
                    display: 'flex', gap: 10, padding: '10px 14px',
                    borderBottom: i < listArticles.length - 1 ? `1px solid ${C.border}` : 'none',
                    cursor: 'pointer', alignItems: 'flex-start',
                  }}
                    onMouseEnter={e => e.currentTarget.style.background = C.bg}
                    onMouseLeave={e => e.currentTarget.style.background = C.white}
                  >
                    <Badge color={CAT_COLORS[a.cat] || C.main}>{a.cat}</Badge>
                    <div style={{ flex: 1 }}>
                      <div style={{ fontSize: 13, fontWeight: 500, lineHeight: 1.45, color: C.t1 }}>{a.title}</div>
                      <div style={{ fontSize: 10, color: C.t3, marginTop: 3 }}>{a.time}</div>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          )}

          <div className="mission-banner" style={{
            background: C.main, borderRadius: 4, padding: '24px 20px', marginBottom: 24,
            display: 'flex', gap: 20, alignItems: 'center',
          }}>
            <div style={{ width: 5, height: 60, background: C.accent, borderRadius: 2, flexShrink: 0 }}></div>
            <div>
              <div style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 16, fontWeight: 700, color: '#fff', marginBottom: 8 }}>
                「公共交通と地域文化を世の中へ」
              </div>
              <div style={{ fontSize: 12, color: 'rgba(255,255,255,0.75)', lineHeight: 1.75 }}>
                鹿児島地域交通通信社は、2019年にYouTubeチャンネル「ふみたび」として活動を開始。鹿児島県内の公共交通の面白さと地域文化の魅力を、記事・写真・動画で発信し続けています。
              </div>
              <a href="<?php echo home_url('/about/'); ?>"
                style={{ display: 'inline-block', marginTop: 12, background: C.accent, color: '#fff', borderRadius: 4, padding: '7px 16px', fontSize: 12, fontWeight: 700 }}>
                編集長メッセージを読む →
              </a>
            </div>
          </div>

          <div className="genre-showcase-wrapper">
            <SH color={C.sub}>ジャンル別　注目記事</SH>
            <div className="genre-showcase" style={{ marginBottom: 24 }}>
              {['鉄道','航空','船舶','バス','地域話題'].map(genre => {
                const art = ALL_ARTICLES.find(a => a.cat === genre);
                if (!art) return null;
                const col = CAT_COLORS[genre] || C.main;
                return (
                  <a key={genre} href={art.href || 'https://www.humitabitrafficphotonews.com/all-news'} target="_blank" rel="noreferrer" style={{ textDecoration: 'none' }}>
                    <div style={{
                      background: C.white, borderRadius: 4, overflow: 'hidden',
                      boxShadow: '0 1px 4px rgba(27,58,107,0.10)', display: 'flex', cursor: 'pointer',
                    }}
                      onMouseEnter={e => e.currentTarget.style.boxShadow = '0 4px 12px rgba(27,58,107,0.16)'}
                      onMouseLeave={e => e.currentTarget.style.boxShadow = '0 1px 4px rgba(27,58,107,0.10)'}
                    >
                      <div style={{ width: 5, background: col, flexShrink: 0 }}></div>
                      <Img h={72} tone={art.tone} src={art.src} style={{ width: 96, flexShrink: 0 }} />
                      <div style={{ padding: '8px 12px', flex: 1, minWidth: 0 }}>
                        <div style={{ display: 'flex', alignItems: 'center', gap: 6, marginBottom: 4 }}>
                          <span style={{ fontSize: 11, fontWeight: 700, color: col }}>#{genre}</span>
                        </div>
                        <div style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 12, fontWeight: 700, lineHeight: 1.4, color: C.t1,
                          overflow: 'hidden', display: '-webkit-box', WebkitLineClamp: 2, WebkitBoxOrient: 'vertical' }}>
                          {art.title}
                        </div>
                        <div style={{ fontSize: 10, color: C.t3, marginTop: 4 }}>{art.time}</div>
                      </div>
                    </div>
                  </a>
                );
              })}
              <a href="<?php echo home_url('/articles/'); ?>" style={{ textDecoration: 'none' }}>
                <div style={{
                  background: C.main, borderRadius: 4, height: 72, display: 'flex',
                  alignItems: 'center', justifyContent: 'center', cursor: 'pointer', gap: 8,
                }}
                  onMouseEnter={e => e.currentTarget.style.background = C.mainDark}
                  onMouseLeave={e => e.currentTarget.style.background = C.main}
                >
                  <span style={{ color: '#fff', fontSize: 13, fontWeight: 700 }}>全記事を見る →</span>
                </div>
              </a>
            </div>
          </div>

          <div className="target-audience" style={{ background: C.mainLight, borderRadius: 4, padding: '18px 20px', marginBottom: 24, border: `1px solid ${C.subLight}` }}>
            <div style={{ fontSize: 12, fontWeight: 700, color: C.main, marginBottom: 12, letterSpacing: '0.05em' }}>こんな方に読んでほしい</div>
            <div style={{ display: 'flex', gap: 10, flexWrap: 'wrap' }}>
              {[
                { icon: '🏠', label: '鹿児島県内にお住まいの方',   desc: '地元の公共交通ニュースをどこよりも詳しく' },
                { icon: '✈️', label: '鹿児島に興味がある県外の方', desc: '鹿児島の交通・観光情報を発信中' },
                { icon: '🚃', label: '乗り物・公共交通が好きな方', desc: '鉄道・バス・船・航空の専門記事が充実' },
              ].map(({ icon, label, desc }) => (
                <div key={label} style={{ flex: '1 1 160px', background: C.white, borderRadius: 4, padding: '12px 14px', border: `1px solid ${C.border}` }}>
                  <div style={{ fontSize: 18, marginBottom: 4 }}>{icon}</div>
                  <div style={{ fontSize: 12, fontWeight: 700, color: C.main, marginBottom: 3 }}>{label}</div>
                  <div style={{ fontSize: 11, color: C.t2, lineHeight: 1.6 }}>{desc}</div>
                </div>
              ))}
            </div>
          </div>

          <aside className="sidebar-content">
            <Sidebar />
          </aside>
        </div>
      </main>

      <Footer />

      {searching && searchQuery && (
        <SearchResults
          query={searchQuery}
          articles={ALL_ARTICLES}
          onClose={() => { setSearching(false); setSearchQuery(''); setSearchOpen(false); }}
        />
      )}
    </div>
  );
}

ReactDOM.createRoot(document.getElementById('root')).render(<App />);
</script>

<?php get_footer(); ?>
