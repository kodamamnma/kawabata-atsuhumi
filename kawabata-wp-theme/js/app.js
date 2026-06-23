/* global WP_ARTICLES */
const { useState, useEffect } = React;

/* ─── Color tokens ─── */
const C = {
  main: '#1B3A6B', mainDark: '#122851', mainLight: '#EEF3FA',
  sub: '#2E5FA3', subLight: '#D0DCF0',
  accent: '#E07B1A', accentDark: '#B85E0D',
  t1: '#0F1B2E', t2: '#4A5568', t3: '#7A8A9E',
  border: '#D8E4F0', bg: '#F4F7FB', white: '#FFFFFF',
};

/* ─── Placeholder / real image ─── */
const Img = ({ h, tone = 'a', style = {}, src }) => {
  const pals = {
    a: ['#b8c8d8','#d8e4ec'],
    b: ['#b8c8b8','#d4e0d4'],
    c: ['#c8c4b4','#e0dcd0'],
    d: ['#c4b8c8','#dcd4e0'],
    e: ['#b8c0d0','#ced8e4'],
    f: ['#c8b8a8','#e0d4c4'],
  };
  const [c1, c2] = pals[tone] || pals.a;
  const [err, setErr] = React.useState(false);
  if (src && !err) {
    return <img src={src} onError={() => setErr(true)}
      style={{ height: h, flexShrink: 0, objectFit: 'cover', display: 'block', ...style }} />;
  }
  return <div style={{ height: h, background: `linear-gradient(135deg,${c1},${c2})`, flexShrink: 0, ...style }} />;
};

/* ─── Badge ─── */
const Badge = ({ children, color, outline = false, small = false }) => {
  const bg = color || C.main;
  return (
    <span style={{
      display: 'inline-block', fontSize: small ? 9 : 10, fontWeight: 700,
      padding: small ? '1px 5px' : '2px 7px', borderRadius: 2, lineHeight: 1.4,
      background: outline ? 'transparent' : bg,
      color: outline ? bg : '#fff',
      border: outline ? `1px solid ${bg}` : 'none',
      flexShrink: 0,
    }}>{children}</span>
  );
};

/* ─── Category colors ─── */
const CAT_COLORS = {
  '鉄道': C.main, '航空': '#0D5F7E', '船舶': '#1A6B4A',
  'バス': C.sub, '地域話題': '#6B3FA0', '鹿児島のイベント': '#B85E0D', 'その他': C.t2,
};

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

/* ─── Section head ─── */
const SH = ({ children, color = C.main, extra }) => (
  <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', borderLeft: `4px solid ${color}`, paddingLeft: 10, marginBottom: 12 }}>
    <span style={{ fontSize: 15, fontWeight: 700, color: C.t1 }}>{children}</span>
    {extra && <span style={{ fontSize: 11, color: C.sub }}>{extra}</span>}
  </div>
);

/* ═══════════════════════════════════
   HEADER
══════════════════════════════════ */
const Header = ({ onSearch, searchOpen, setSearchOpen, searchQuery, setSearchQuery, menuOpen, setMenuOpen }) => (
  <header style={{ background: C.white, borderBottom: `4px solid ${C.main}`, position: 'sticky', top: 0, zIndex: 200 }}>
    {/* Top utility bar */}
    <div style={{ background: C.main, color: 'rgba(255,255,255,0.75)', padding: '4px 0' }}>
      <div style={{ maxWidth: 1160, margin: '0 auto', padding: '0 16px', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
        <span style={{ fontSize: 'clamp(8px, 2.5vw, 11px)', whiteSpace: 'nowrap' }}>公共交通と地域文化を世の中へ</span>
        <div style={{ display: 'flex', gap: 16 }}>
          {[['X (Twitter)', 'https://twitter.com/humitabphotnews'], ['Instagram', 'https://www.instagram.com/humitabiphoto/'], ['TikTok', 'https://www.tiktok.com/@humitabitrafficnewsphoto']].map(([lbl, href]) => (
            <a key={lbl} href={href} target="_blank" rel="noreferrer" style={{ color: 'rgba(255,255,255,0.75)', fontSize: 'clamp(8px, 2.5vw, 11px)' }}>{lbl}</a>
          ))}
        </div>
      </div>
    </div>
    {/* Main header row */}
    <div style={{ maxWidth: 1160, margin: '0 auto', padding: '0 16px', height: 56, display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: 16 }}>
      {/* Logo */}
      <a href="/" style={{ display: 'flex', alignItems: 'center', gap: 10, textDecoration: 'none' }}>
        <div style={{ width: 5, height: 44, background: C.accent, borderRadius: 2 }}></div>
        <div>
          <div style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 'clamp(13px, 4.5vw, 20px)', fontWeight: 700, color: C.main, lineHeight: 1.1, letterSpacing: -0.5, whiteSpace: 'nowrap' }}>鹿児島地域交通通信社</div>
          <div style={{ fontSize: 'clamp(7px, 2vw, 10px)', color: C.t3, letterSpacing: 1, marginTop: 1, whiteSpace: 'nowrap' }}>Kagoshima regional transport news agency</div>
        </div>
      </a>
      {/* Actions */}
      <div style={{ display: 'flex', alignItems: 'center' }}>
        {/* Hamburger menu button */}
        <button onClick={() => setMenuOpen(!menuOpen)} style={{
          background: 'none', border: 'none', padding: '2px 4px',
          display: 'flex', flexDirection: 'column', alignItems: 'center', gap: 2, cursor: 'pointer',
        }}>
          <div style={{ width: 24, height: 18, display: 'flex', flexDirection: 'column', justifyContent: 'space-between' }}>
            <span style={{ display: 'block', width: 24, height: 2.5, background: C.main, borderRadius: 2, transition: 'all 0.3s ease', transform: menuOpen ? 'translateY(7.75px) rotate(45deg)' : 'none' }}></span>
            <span style={{ display: 'block', width: 24, height: 2.5, background: C.main, borderRadius: 2, transition: 'all 0.3s ease', opacity: menuOpen ? 0 : 1 }}></span>
            <span style={{ display: 'block', width: 24, height: 2.5, background: C.main, borderRadius: 2, transition: 'all 0.3s ease', transform: menuOpen ? 'translateY(-7.75px) rotate(-45deg)' : 'none' }}></span>
          </div>
          <span style={{ fontSize: 9, color: C.t2, fontWeight: 700, letterSpacing: '0.05em', lineHeight: 1 }}>メニュー</span>
        </button>
      </div>
    </div>
  </header>
);

/* ═══════════════════════════════════
   MOBILE MENU OVERLAY
══════════════════════════════════ */
const MobileMenu = ({ open, onClose, onCategoryChange }) => {
  useEffect(() => {
    document.body.style.overflow = open ? 'hidden' : '';
    return () => { document.body.style.overflow = ''; };
  }, [open]);

  if (!open) return null;

  const menuSections = [
    {
      title: 'カテゴリ',
      items: [
        { label: 'すべての記事', action: () => { onCategoryChange('すべて'); onClose(); } },
        { label: '🚃 鉄道', action: () => { onCategoryChange('鉄道'); onClose(); } },
        { label: '✈️ 航空', action: () => { onCategoryChange('航空'); onClose(); } },
        { label: '🚢 船舶', action: () => { onCategoryChange('船舶'); onClose(); } },
        { label: '🚌 バス', action: () => { onCategoryChange('バス'); onClose(); } },
        { label: '📍 地域話題', action: () => { onCategoryChange('地域話題'); onClose(); } },
      ],
    },
    {
      title: 'コンテンツ',
      items: [
        { label: '記事一覧', href: '/articles/' },
        { label: '概要案内', href: '/about/' },
      ],
    },
    {
      title: '公式SNS・メディア',
      items: [
        { label: 'X（旧Twitter）— 交通速報', href: 'https://twitter.com/humitabphotnews', dot: '#000' },
        { label: 'note — 過去の交通記事', href: 'https://note.com/humitabinewsphot', dot: '#1A1A1A' },
        { label: 'Instagram — 写真・動画', href: 'https://www.instagram.com/humitabiphoto/', dot: '#C13584' },
        { label: 'TikTok — 動画コンテンツ', href: 'https://www.tiktok.com/@humitabitrafficnewsphoto', dot: '#010101' },
      ],
    },
  ];

  return (
    <div style={{
      position: 'fixed', top: 85, left: 0, right: 0, bottom: 0, zIndex: 190,
      background: 'rgba(15,27,46,0.55)',
      transition: 'opacity 0.3s ease',
    }} onClick={onClose}>
      <div style={{
        position: 'absolute', top: 0, right: 0, width: '100%', maxWidth: 360,
        height: '100%', background: C.white, overflowY: 'auto',
        boxShadow: '-4px 0 24px rgba(15,27,46,0.15)',
        padding: '48px 0 32px',
      }} onClick={e => e.stopPropagation()}>
        {menuSections.map((section, si) => (
          <div key={si} style={{ padding: '0 24px', marginBottom: 24 }}>
            <div style={{
              fontSize: 11, fontWeight: 700, color: C.t3, letterSpacing: '0.1em',
              textTransform: 'uppercase', marginBottom: 10, paddingBottom: 6,
              borderBottom: `2px solid ${C.border}`,
            }}>{section.title}</div>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 2 }}>
              {section.items.map((item, ii) => (
                item.href ? (
                  <a key={ii} href={item.href} target="_blank" rel="noreferrer" onClick={onClose} style={{
                    display: 'flex', alignItems: 'center', gap: 10, padding: '10px 12px',
                    borderRadius: 6, fontSize: 14, color: C.t1, textDecoration: 'none',
                    transition: 'background 0.15s',
                  }}
                    onMouseEnter={e => e.currentTarget.style.background = C.bg}
                    onMouseLeave={e => e.currentTarget.style.background = 'transparent'}
                  >
                    {item.dot && <span style={{ width: 8, height: 8, borderRadius: '50%', background: item.dot, flexShrink: 0 }}></span>}
                    {item.label}
                  </a>
                ) : (
                  <button key={ii} onClick={item.action} style={{
                    display: 'flex', alignItems: 'center', gap: 10, padding: '10px 12px',
                    borderRadius: 6, fontSize: 14, color: C.t1, background: 'none',
                    border: 'none', cursor: 'pointer', textAlign: 'left', width: '100%',
                    fontFamily: 'inherit', transition: 'background 0.15s',
                  }}
                    onMouseEnter={e => e.currentTarget.style.background = C.bg}
                    onMouseLeave={e => e.currentTarget.style.background = 'transparent'}
                  >
                    {item.label}
                  </button>
                )
              ))}
            </div>
          </div>
        ))}

        {/* Contact section */}
        <div style={{ padding: '0 24px', marginBottom: 24 }}>
          <div style={{
            background: C.main, borderRadius: 8, padding: 20, color: '#fff',
          }}>
            <div style={{ fontSize: 11, opacity: 0.75, marginBottom: 4 }}>お問い合わせ</div>
            <div style={{ fontSize: 14, fontWeight: 700, marginBottom: 10 }}>E-MAIL</div>
            <a href="mailto:kagoshimaregionaltransport@kagoshima-news.jp" style={{
              display: 'block', background: C.accent, color: '#fff', borderRadius: 6,
              padding: '10px 14px', fontSize: 13, fontWeight: 700, textAlign: 'center',
              wordBreak: 'break-all', textDecoration: 'none',
            }}>kagoshimaregionaltransport@kagoshima-news.jp</a>
            <div style={{ fontSize: 10, opacity: 0.6, marginTop: 8, lineHeight: 1.6 }}>お電話での対応は行っておりません。</div>
          </div>
        </div>
      </div>
    </div>
  );
};

/* ═══════════════════════════════════
   CATEGORY NAV
══════════════════════════════════ */
const CATS = ['すべて','鉄道','航空','船舶','バス','地域話題','鹿児島のイベント'];
const CategoryNav = ({ active, onChange }) => (
  <nav style={{ background: C.white, borderBottom: `1px solid ${C.border}`, overflowX: 'auto' }}>
    <div style={{ maxWidth: 1160, margin: '0 auto', padding: '0 16px', display: 'flex' }}>
      {CATS.map(c => (
        <button key={c} onClick={() => onChange(c)} style={{
          padding: '10px 16px', fontSize: 13, fontWeight: active === c ? 700 : 500,
          color: active === c ? C.main : C.t2,
          background: 'none', border: 'none',
          borderBottom: active === c ? `3px solid ${C.main}` : '3px solid transparent',
          whiteSpace: 'nowrap',
        }}>{c}</button>
      ))}
    </div>
  </nav>
);

/* ═══════════════════════════════════
   ARTICLE CARDS
══════════════════════════════════ */
const CardH = ({ cat, title, time, badge, tone = 'a', summary, src, href }) => (
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

const CardV = ({ cat, title, time, badge, tone = 'a', src, href }) => (
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

/* ═══════════════════════════════════
   SIDEBAR
══════════════════════════════════ */
const Sidebar = () => (
  <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
    {/* About box */}
    <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', overflow: 'hidden' }}>
      <div style={{ background: C.main, color: '#fff', padding: '10px 14px', fontSize: 13, fontWeight: 700 }}>当社について</div>
      <Img h={100} tone="a" src={IMGS.corporate} style={{ width: '100%' }} />
      <div style={{ padding: '14px' }}>
        <div style={{ fontSize: 13, fontWeight: 700, color: C.main, marginBottom: 6 }}>鹿児島地域交通通信社</div>
        <div style={{ fontSize: 12, color: C.t2, lineHeight: 1.75, marginBottom: 12 }}>
          「公共交通と地域文化を世の中へ」を目指して、鹿児島県内の公共交通と地域情報を中心に取材・報道する個人運営のメディアです。2019年YouTubeチャンネル「ふみたび」から始まり、2026年に現在の名称へ。
        </div>
        <a href="/about/" style={{
          display: 'block', textAlign: 'center', background: C.main, color: '#fff',
          borderRadius: 4, padding: '8px 0', fontSize: 12, fontWeight: 700,
        }}>概要案内を読む →</a>
      </div>
    </div>

    {/* SNS links */}
    <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', overflow: 'hidden' }}>
      <div style={{ background: C.main, color: '#fff', padding: '10px 14px', fontSize: 13, fontWeight: 700 }}>公式SNS・メディア</div>
      <div style={{ padding: '12px 14px', display: 'flex', flexDirection: 'column', gap: 8 }}>
        {[
          { lbl: 'X（旧Twitter）', href: 'https://twitter.com/humitabphotnews', color: '#000' },
          { lbl: 'Instagram — 写真・動画', href: 'https://www.instagram.com/humitabiphoto/', color: '#C13584' },
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

    {/* Contact */}
    <div style={{ background: C.main, borderRadius: 4, padding: 16, color: '#fff' }}>
      <div style={{ fontSize: 12, opacity: 0.75, marginBottom: 4 }}>お問い合わせ</div>
      <div style={{ fontSize: 13, fontWeight: 700, marginBottom: 8 }}>E-MAIL</div>
      <a href="mailto:kagoshimaregionaltransport@kagoshima-news.jp" style={{
        display: 'block', background: C.accent, color: '#fff', borderRadius: 4,
        padding: '8px 12px', fontSize: 12, fontWeight: 700, textAlign: 'center',
        wordBreak: 'break-all',
      }}>kagoshimaregionaltransport@kagoshima-news.jp</a>
      <div style={{ fontSize: 10, opacity: 0.6, marginTop: 8, lineHeight: 1.6 }}>お電話での対応は行っておりません。</div>
    </div>
  </div>
);

/* ═══════════════════════════════════
   SEARCH MODAL
══════════════════════════════════ */
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

/* ═══════════════════════════════════
   FOOTER
══════════════════════════════════ */
const Footer = () => (
  <footer style={{ background: C.mainDark, marginTop: 48, padding: '32px 0 20px' }}>
    <div style={{ maxWidth: 1160, margin: '0 auto', padding: '0 16px' }}>
      <div style={{ display: 'flex', gap: 10, alignItems: 'center', marginBottom: 16 }}>
        <div style={{ width: 4, height: 32, background: C.accent, borderRadius: 2 }}></div>
        <div>
          <div style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 16, fontWeight: 700, color: '#fff' }}>鹿児島地域交通通信社</div>
          <div style={{ fontSize: 10, color: 'rgba(255,255,255,0.45)', letterSpacing: 1 }}>Kagoshima regional transport news agency</div>
        </div>
      </div>
      <div style={{ display: 'flex', gap: 20, flexWrap: 'wrap', marginBottom: 20 }}>
        {[
          ['X（旧Twitter）', 'https://twitter.com/humitabphotnews'],
          ['Instagram', 'https://www.instagram.com/humitabiphoto/'],
          ['TikTok', 'https://www.tiktok.com/@humitabitrafficnewsphoto'],
          ['お問い合わせ', '/contact/'],
          ['プライバシーポリシー', '/privacy/'],
        ].map(([lbl, href]) => (
          <a key={lbl} href={href} target="_blank" rel="noreferrer" style={{ color: 'rgba(255,255,255,0.55)', fontSize: 12 }}>{lbl}</a>
        ))}
      </div>
      <div style={{ borderTop: '1px solid rgba(255,255,255,0.1)', paddingTop: 16, display: 'flex', justifyContent: 'space-between', flexWrap: 'wrap', gap: 8 }}>
        <div style={{ fontSize: 11, color: 'rgba(255,255,255,0.35)' }}>© 鹿児島地域交通通信社 All Rights Reserved.</div>
        <div style={{ fontSize: 11, color: 'rgba(255,255,255,0.35)' }}>E-MAIL: kagoshimaregionaltransport@kagoshima-news.jp</div>
      </div>
    </div>
  </footer>
);

/* ═══════════════════════════════════
   DATA
   WP_ARTICLES が PHP から渡されている場合はそれを使用し、
   ない場合は以下の静的フォールバックデータを使用する。
══════════════════════════════════ */
const WIX = 'https://static.wixstatic.com/media/';
const IMGS = {
  orenjiShokudo: WIX + '5c3d68_d3607e0bed854215949bde07a0d50443~mv2.jpg/v1/fill/w_600,h_400,fp_0.50_0.50,q_90,enc_avif,quality_auto/5c3d68_d3607e0bed854215949bde07a0d50443~mv2.jpg',
  chagington:    WIX + '5c3d68_f1c0c291c0524258b294d22504d110c5~mv2.jpg/v1/fill/w_600,h_400,fp_0.50_0.50,q_90,enc_avif,quality_auto/5c3d68_f1c0c291c0524258b294d22504d110c5~mv2.jpg',
  fda:           WIX + '5c3d68_934c2e0bba0442e5a23866867d38ec57~mv2.jpg/v1/fill/w_600,h_400,fp_0.50_0.50,q_90,enc_avif,quality_auto/5c3d68_934c2e0bba0442e5a23866867d38ec57~mv2.jpg',
  kirishima:     WIX + '5c3d68_eafce25422044b07b1990ea4b0c99d90~mv2.webp/v1/fill/w_600,h_400,al_c,q_90,enc_avif,quality_auto/5c3d68_eafce25422044b07b1990ea4b0c99d90~mv2.webp',
  corporate:     WIX + '5c3d68_37f490f2219240859901a9958b0c1d92~mv2.jpg/v1/fill/w_600,h_400,al_c,q_80,enc_avif,quality_auto/5c3d68_37f490f2219240859901a9958b0c1d92~mv2.jpg',
  banner:        WIX + '5c3d68_7689e252580e4cc7a76481f5a9ddf184~mv2.jpg/v1/fill/w_1200,h_400,al_c,q_80,enc_avif,quality_auto/5c3d68_7689e252580e4cc7a76481f5a9ddf184~mv2.jpg',
};

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

/* WordPress から渡された投稿があればそちらを優先 */
const ALL_ARTICLES = (typeof WP_ARTICLES !== 'undefined' && Array.isArray(WP_ARTICLES) && WP_ARTICLES.length > 0)
  ? WP_ARTICLES
  : STATIC_ARTICLES;

/* ─── 特集記事データ ─── */
const PICK_CITIZENS = ALL_ARTICLES.find(a => a.badge === 'citizens') || ALL_ARTICLES[0];
const PICK_EDITOR   = ALL_ARTICLES.find(a => a.badge === 'editor')   || ALL_ARTICLES[1];

/* ═══════════════════════════════════
   MAIN APP
══════════════════════════════════ */
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
      <CategoryNav active={cat} onChange={c => { setCat(c); }} />

      <main style={{ maxWidth: 1160, margin: '0 auto', padding: '20px 16px 0' }}>
        <div className="layout-grid">
          {/* Hero */}
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

          {/* 特集：2列並び */}
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

          {/* 最新ニュース */}
          <div className="latest-news" style={{ marginBottom: 0 }}>
            <SH color={C.main}>最新ニュース</SH>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 10, marginBottom: 16 }}>
              {subArticles.slice(0, 4).map((a, i) => <CardH key={i} {...a} />)}
            </div>
          </div>

          {/* 広告枠 */}
          <div className="ad-space" style={{
            marginBottom: 24, background: C.border, borderRadius: 4,
            height: 90, display: 'flex', alignItems: 'center', justifyContent: 'center',
            border: `1px dashed ${C.t3}`,
          }}>
            <span style={{ fontSize: 11, color: C.t3, letterSpacing: '0.08em' }}>広 告</span>
          </div>

          {/* その他の記事 */}
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

          {/* Mission strip */}
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
              <a href="/about/"
                style={{ display: 'inline-block', marginTop: 12, background: C.accent, color: '#fff', borderRadius: 4, padding: '7px 16px', fontSize: 12, fontWeight: 700 }}>
                編集長メッセージを読む →
              </a>
            </div>
          </div>

          {/* ジャンル別注目記事 */}
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
              <a href="/articles/" style={{ textDecoration: 'none' }}>
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

          {/* こんな方に読んでほしい */}
          <div className="target-audience" style={{ background: C.mainLight, borderRadius: 4, padding: '18px 20px', marginBottom: 24, border: `1px solid ${C.subLight}` }}>
            <div style={{ fontSize: 12, fontWeight: 700, color: C.main, marginBottom: 12, letterSpacing: '0.05em' }}>こんな方に読んでほしい</div>
            <div style={{ display: 'flex', gap: 10, flexWrap: 'wrap' }}>
              {[
                { icon: '🏠', label: '鹿児島県内にお住まいの方', desc: '地元の公共交通ニュースをどこよりも詳しく' },
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

          {/* ── RIGHT SIDEBAR ── */}
          <aside className="sidebar-content">
            <Sidebar />
          </aside>
        </div>
      </main>

      <Footer />

      {/* Search modal */}
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
