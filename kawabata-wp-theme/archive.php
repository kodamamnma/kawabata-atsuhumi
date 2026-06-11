<?php get_header(); ?>

<script type="text/babel">
const { useState } = React;

const CAT_COLORS = {
  '鉄道': C.main, '航空': '#0D5F7E', '船舶': '#1A6B4A',
  'バス': C.sub, '地域話題': '#6B3FA0', '鹿児島のイベント': '#B85E0D', 'その他': C.t2,
};

const CATS = ['すべて', '鉄道', '航空', '船舶', 'バス', '地域話題', '鹿児島のイベント'];

const IMGS = {
  corporate: '<?php echo get_template_directory_uri(); ?>/images/corporate.jpg',
};

const ALL_ARTICLES = (typeof WP_ARTICLES !== 'undefined' && Array.isArray(WP_ARTICLES) && WP_ARTICLES.length > 0)
  ? WP_ARTICLES
  : [];

/* ─── LikeShare ─── */
const LikeShare = ({ title, href }) => {
  const [liked, setLiked] = React.useState(false);
  const [likes, setLikes] = React.useState(Math.floor(Math.random() * 30) + 1);
  const handleLike = e => { e.preventDefault(); e.stopPropagation(); setLiked(!liked); setLikes(p => liked ? p - 1 : p + 1); };
  const tweetUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(href || window.location.href)}`;
  return (
    <div style={{ display: 'flex', gap: 8, alignItems: 'center', marginTop: 8 }} onClick={e => e.preventDefault()}>
      <button onClick={handleLike} style={{ display: 'flex', alignItems: 'center', gap: 4, padding: '4px 10px', borderRadius: 20, border: `1px solid ${liked ? C.accent : C.border}`, background: liked ? '#FFF4EA' : 'transparent', color: liked ? C.accent : C.t3, fontSize: 11, fontWeight: 700, cursor: 'pointer', fontFamily: 'inherit' }}>
        <span style={{ fontSize: 13 }}>{liked ? '♥' : '♡'}</span>{likes}
      </button>
      <a href={tweetUrl} target="_blank" rel="noreferrer" onClick={e => e.stopPropagation()} style={{ display: 'flex', alignItems: 'center', gap: 4, padding: '4px 10px', borderRadius: 20, border: `1px solid ${C.border}`, background: 'transparent', color: C.t3, fontSize: 11, fontWeight: 700, textDecoration: 'none' }}
        onMouseEnter={e => { e.currentTarget.style.background = '#000'; e.currentTarget.style.color = '#fff'; e.currentTarget.style.borderColor = '#000'; }}
        onMouseLeave={e => { e.currentTarget.style.background = 'transparent'; e.currentTarget.style.color = C.t3; e.currentTarget.style.borderColor = C.border; }}
      >
        <span style={{ fontSize: 12, fontWeight: 900 }}>𝕏</span> シェア
      </a>
    </div>
  );
};

/* ─── CardH ─── */
const CardH = ({ cat, title, time, badge, tone = 'a', summary, src, href }) => (
  <a href={href || '#'} target={href ? '_blank' : undefined} rel="noreferrer" style={{ textDecoration: 'none' }}>
    <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', display: 'flex', overflow: 'hidden', cursor: 'pointer' }}
      onMouseEnter={e => e.currentTarget.style.boxShadow = '0 4px 12px rgba(27,58,107,0.16)'}
      onMouseLeave={e => e.currentTarget.style.boxShadow = '0 1px 4px rgba(27,58,107,0.10)'}
    >
      <Img h={92} tone={tone} src={src} style={{ width: 120 }} />
      <div style={{ padding: '10px 13px', flex: 1, minWidth: 0 }}>
        <div style={{ display: 'flex', gap: 5, marginBottom: 5, flexWrap: 'wrap' }}>
          <Badge color={CAT_COLORS[cat] || C.main}>{cat}</Badge>
          {badge && <Badge color={badge === '速報' ? C.accent : badge === '独自' ? '#6B3FA0' : C.sub}>{badge}</Badge>}
        </div>
        <div style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 13, fontWeight: 700, lineHeight: 1.45, color: C.t1, marginBottom: summary ? 5 : 0 }}>{title}</div>
        {summary && <div style={{ fontSize: 11, color: C.t2, lineHeight: 1.6, overflow: 'hidden', display: '-webkit-box', WebkitLineClamp: 2, WebkitBoxOrient: 'vertical' }}>{summary}</div>}
        <div style={{ fontSize: 10, color: C.t3, marginTop: 5 }}>{time}</div>
        <LikeShare title={title} href={href} />
      </div>
    </div>
  </a>
);

/* ─── CategoryNav ─── */
const CategoryNav = ({ active, onChange }) => (
  <nav style={{ background: C.white, borderBottom: `1px solid ${C.border}`, overflowX: 'auto' }}>
    <div style={{ maxWidth: 1160, margin: '0 auto', padding: '0 16px', display: 'flex' }}>
      {CATS.map(c => (
        <button key={c} onClick={() => onChange(c)} style={{ padding: '10px 16px', fontSize: 13, fontWeight: active === c ? 700 : 500, color: active === c ? C.main : C.t2, background: 'none', border: 'none', borderBottom: active === c ? `3px solid ${C.main}` : '3px solid transparent', whiteSpace: 'nowrap' }}>{c}</button>
      ))}
    </div>
  </nav>
);

/* ─── Sidebar ─── */
const Sidebar = () => (
  <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
    <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', overflow: 'hidden' }}>
      <div style={{ background: C.main, color: '#fff', padding: '10px 14px', fontSize: 13, fontWeight: 700 }}>当社について</div>
      <img src={IMGS.corporate} alt="" onError={e => e.currentTarget.style.display='none'} style={{ width: '100%', height: 100, objectFit: 'cover', display: 'block' }} />
      <div style={{ padding: 14 }}>
        <div style={{ fontSize: 13, fontWeight: 700, color: C.main, marginBottom: 6 }}>鹿児島地域交通通信社</div>
        <div style={{ fontSize: 12, color: C.t2, lineHeight: 1.75, marginBottom: 12 }}>
          「公共交通と地域文化を世の中へ」を目指して、鹿児島県内の公共交通と地域情報を中心に取材・報道する個人運営のメディアです。2019年YouTubeチャンネル「ふみたび」から始まり、2026年に現在の名称へ。
        </div>
        <a href="<?php echo get_permalink(get_page_by_path('about')); ?>" style={{ display: 'block', textAlign: 'center', background: C.main, color: '#fff', borderRadius: 4, padding: '8px 0', fontSize: 12, fontWeight: 700 }}>概要案内を読む →</a>
      </div>
    </div>
    <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', overflow: 'hidden' }}>
      <div style={{ background: C.main, color: '#fff', padding: '10px 14px', fontSize: 13, fontWeight: 700 }}>公式SNS・メディア</div>
      <div style={{ padding: '12px 14px', display: 'flex', flexDirection: 'column', gap: 8 }}>
        {[
          { lbl: 'X（旧Twitter）', href: 'https://twitter.com/humitabphotnews', color: '#000' },
          { lbl: 'Instagram — 写真・動画', href: 'https://www.instagram.com/humitabiphoto/', color: '#C13584' },
          { lbl: 'TikTok — 動画コンテンツ', href: 'https://www.tiktok.com/@humitabitrafficnewsphoto', color: '#010101' },
          { lbl: 'note — 過去の交通記事', href: 'https://note.com/humitabinewsphot', color: '#1A1A1A' },
        ].map(({ lbl, href, color }) => (
          <a key={lbl} href={href} target="_blank" rel="noreferrer" style={{ display: 'flex', alignItems: 'center', gap: 8, padding: '7px 10px', borderRadius: 4, background: C.bg, fontSize: 12, color: C.t1, border: `1px solid ${C.border}` }}>
            <span style={{ width: 8, height: 8, borderRadius: '50%', background: color, flexShrink: 0 }}></span>
            {lbl}
          </a>
        ))}
      </div>
    </div>
    <div style={{ background: C.main, borderRadius: 4, padding: 16, color: '#fff' }}>
      <div style={{ fontSize: 12, opacity: 0.75, marginBottom: 4 }}>お問い合わせ</div>
      <div style={{ fontSize: 13, fontWeight: 700, marginBottom: 8 }}>E-MAIL</div>
      <a href="mailto:humitabiphoto@gmail.com" style={{ display: 'block', background: C.accent, color: '#fff', borderRadius: 4, padding: '8px 12px', fontSize: 12, fontWeight: 700, textAlign: 'center', wordBreak: 'break-all' }}>humitabiphoto@gmail.com</a>
      <div style={{ fontSize: 10, opacity: 0.6, marginTop: 8, lineHeight: 1.6 }}>お電話での対応は行っておりません。</div>
    </div>
  </div>
);

function App() {
  const [cat, setCat] = useState('すべて');
  const [menuOpen, setMenuOpen] = useState(false);

  const filtered = cat === 'すべて' ? ALL_ARTICLES : ALL_ARTICLES.filter(a => a.cat === cat);

  return (
    <div>
      <Header menuOpen={menuOpen} setMenuOpen={setMenuOpen} />
      <MobileMenu open={menuOpen} onClose={() => setMenuOpen(false)} onCategoryChange={c => setCat(c)} />
      <CategoryNav active={cat} onChange={c => setCat(c)} />

      <div style={{ background: C.white, borderBottom: `1px solid ${C.border}` }}>
        <div style={{ maxWidth: 1160, margin: '0 auto', padding: '8px 16px', display: 'flex', gap: 6, alignItems: 'center', fontSize: 12, color: C.t3 }}>
          <a href="<?php echo home_url('/'); ?>" style={{ color: C.sub }}>トップ</a>
          <span>›</span>
          <span style={{ color: C.t1 }}>記事一覧</span>
          {cat !== 'すべて' && <><span>›</span><span style={{ color: C.t1 }}>{cat}</span></>}
        </div>
      </div>

      <main style={{ maxWidth: 1160, margin: '0 auto', padding: '20px 16px 0' }}>
        <div className="layout-grid">
          <div>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'baseline', marginBottom: 16, borderLeft: `4px solid ${C.main}`, paddingLeft: 10 }}>
              <h1 style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 18, fontWeight: 700, color: C.t1 }}>
                {cat === 'すべて' ? '記事一覧' : cat}
              </h1>
              <span style={{ fontSize: 12, color: C.t3 }}>{filtered.length}件</span>
            </div>

            {filtered.length > 0 ? (
              <div style={{ display: 'flex', flexDirection: 'column', gap: 10, marginBottom: 24 }}>
                {filtered.map((a, i) => <CardH key={i} {...a} />)}
              </div>
            ) : (
              <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', padding: '48px 0', textAlign: 'center', marginBottom: 24 }}>
                <div style={{ fontSize: 14, color: C.t3 }}>このカテゴリの記事はまだありません</div>
              </div>
            )}
          </div>

          <aside className="sidebar-content">
            <Sidebar />
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
