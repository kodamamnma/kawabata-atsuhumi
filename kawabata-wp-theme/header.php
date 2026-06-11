<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="root"></div>
<script type="text/babel">
const { useState, useEffect } = React;

/* ─── Color tokens ─── */
const C = {
  main: '#1B3A6B', mainDark: '#122851', mainLight: '#EEF3FA',
  sub: '#2E5FA3', subLight: '#D0DCF0',
  accent: '#E07B1A', accentDark: '#B85E0D',
  t1: '#0F1B2E', t2: '#4A5568', t3: '#7A8A9E',
  border: '#D8E4F0', bg: '#F4F7FB', white: '#FFFFFF',
};

const CAT_COLORS = {
  '鉄道': C.main, '航空': '#0D5F7E', '船舶': '#1A6B4A',
  'バス': C.sub, '地域話題': '#6B3FA0', '鹿児島のイベント': '#B85E0D', 'その他': C.t2,
};

const CATS = ['すべて', '鉄道', '航空', '船舶', 'バス', '地域話題', '鹿児島のイベント'];

/* ─── Images ─── */
const WIX = 'https://static.wixstatic.com/media/';
const IMGS = {
  orenjiShokudo: WIX + '5c3d68_d3607e0bed854215949bde07a0d50443~mv2.jpg/v1/fill/w_600,h_400,fp_0.50_0.50,q_90,enc_avif,quality_auto/5c3d68_d3607e0bed854215949bde07a0d50443~mv2.jpg',
  chagington:    WIX + '5c3d68_f1c0c291c0524258b294d22504d110c5~mv2.jpg/v1/fill/w_600,h_400,fp_0.50_0.50,q_90,enc_avif,quality_auto/5c3d68_f1c0c291c0524258b294d22504d110c5~mv2.jpg',
  fda:           WIX + '5c3d68_934c2e0bba0442e5a23866867d38ec57~mv2.jpg/v1/fill/w_600,h_400,fp_0.50_0.50,q_90,enc_avif,quality_auto/5c3d68_934c2e0bba0442e5a23866867d38ec57~mv2.jpg',
  kirishima:     WIX + '5c3d68_eafce25422044b07b1990ea4b0c99d90~mv2.webp/v1/fill/w_600,h_400,al_c,q_90,enc_avif,quality_auto/5c3d68_eafce25422044b07b1990ea4b0c99d90~mv2.webp',
  corporate:     WIX + '5c3d68_37f490f2219240859901a9958b0c1d92~mv2.jpg/v1/fill/w_600,h_400,al_c,q_80,enc_avif,quality_auto/5c3d68_37f490f2219240859901a9958b0c1d92~mv2.jpg',
  banner:        WIX + '5c3d68_7689e252580e4cc7a76481f5a9ddf184~mv2.jpg/v1/fill/w_1200,h_400,al_c,q_80,enc_avif,quality_auto/5c3d68_7689e252580e4cc7a76481f5a9ddf184~mv2.jpg',
  editor:        '<?php echo get_template_directory_uri(); ?>/images/editor.jpg',
};

/* ─── Img ─── */
const Img = ({ h, tone = 'a', style = {}, src }) => {
  const pals = {
    a: ['#b8c8d8','#d8e4ec'], b: ['#b8c8b8','#d4e0d4'], c: ['#c8c4b4','#e0dcd0'],
    d: ['#c4b8c8','#dcd4e0'], e: ['#b8c0d0','#ced8e4'], f: ['#c8b8a8','#e0d4c4'],
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

/* ─── SH ─── */
const SH = ({ children, color = C.main, extra }) => (
  <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', borderLeft: `4px solid ${color}`, paddingLeft: 10, marginBottom: 12 }}>
    <span style={{ fontSize: 15, fontWeight: 700, color: C.t1 }}>{children}</span>
    {extra && <span style={{ fontSize: 11, color: C.sub }}>{extra}</span>}
  </div>
);

/* ─── Header ─── */
const Header = ({ menuOpen, setMenuOpen }) => (
  <header style={{ background: C.white, borderBottom: `4px solid ${C.main}`, position: 'sticky', top: 0, zIndex: 200 }}>
    <div style={{ background: C.main, color: 'rgba(255,255,255,0.75)', padding: '4px 0' }}>
      <div style={{ maxWidth: 1160, margin: '0 auto', padding: '0 16px', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
        <span style={{ fontSize: 'clamp(8px,2.5vw,11px)', whiteSpace: 'nowrap' }}>公共交通と地域文化を世の中へ</span>
        <div style={{ display: 'flex', gap: 16 }}>
          {[['X', 'https://twitter.com/humitabphotnews'], ['Instagram', 'https://www.instagram.com/humitabiphoto/'], ['TikTok', 'https://www.tiktok.com/@humitabitrafficnewsphoto']].map(([lbl, href]) => (
            <a key={lbl} href={href} target="_blank" rel="noreferrer" style={{ color: 'rgba(255,255,255,0.75)', fontSize: 'clamp(8px,2.5vw,11px)' }}>{lbl}</a>
          ))}
        </div>
      </div>
    </div>
    <div style={{ maxWidth: 1160, margin: '0 auto', padding: '0 16px', height: 56, display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
      <a href="<?php echo home_url('/'); ?>" style={{ display: 'flex', alignItems: 'center', gap: 10, textDecoration: 'none' }}>
        <div style={{ width: 5, height: 44, background: C.accent, borderRadius: 2 }}></div>
        <div>
          <div style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 'clamp(13px,4.5vw,20px)', fontWeight: 700, color: C.main, lineHeight: 1.1, letterSpacing: -0.5, whiteSpace: 'nowrap' }}>鹿児島地域交通通信社</div>
          <div style={{ fontSize: 'clamp(7px,2vw,10px)', color: C.t3, letterSpacing: 1, marginTop: 1, whiteSpace: 'nowrap' }}>Kagoshima regional transport news agency</div>
        </div>
      </a>
      <button onClick={() => setMenuOpen(!menuOpen)} style={{ background: 'none', border: 'none', padding: '2px 4px', display: 'flex', flexDirection: 'column', alignItems: 'center', gap: 2, cursor: 'pointer' }}>
        <div style={{ width: 24, height: 18, display: 'flex', flexDirection: 'column', justifyContent: 'space-between' }}>
          {[0, 1, 2].map(i => (
            <span key={i} style={{
              display: 'block', width: 24, height: 2.5, background: C.main, borderRadius: 2,
              transition: 'all 0.3s ease',
              transform: i === 0 && menuOpen ? 'translateY(7.75px) rotate(45deg)' : i === 2 && menuOpen ? 'translateY(-7.75px) rotate(-45deg)' : 'none',
              opacity: i === 1 && menuOpen ? 0 : 1,
            }}></span>
          ))}
        </div>
        <span style={{ fontSize: 9, color: C.t2, fontWeight: 700, letterSpacing: '0.05em', lineHeight: 1 }}>メニュー</span>
      </button>
    </div>
  </header>
);

/* ─── MobileMenu ─── */
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
        { label: 'すべての記事', action: () => { onCategoryChange && onCategoryChange('すべて'); onClose(); } },
        { label: '🚃 鉄道',    action: () => { onCategoryChange && onCategoryChange('鉄道'); onClose(); } },
        { label: '✈️ 航空',    action: () => { onCategoryChange && onCategoryChange('航空'); onClose(); } },
        { label: '🚢 船舶',    action: () => { onCategoryChange && onCategoryChange('船舶'); onClose(); } },
        { label: '🚌 バス',    action: () => { onCategoryChange && onCategoryChange('バス'); onClose(); } },
        { label: '📍 地域話題', action: () => { onCategoryChange && onCategoryChange('地域話題'); onClose(); } },
      ],
    },
    {
      title: 'コンテンツ',
      items: [
        { label: '記事一覧', href: '<?php echo home_url("/articles/"); ?>' },
        { label: '概要案内', href: '<?php echo home_url("/about/"); ?>' },
      ],
    },
    {
      title: '公式SNS・メディア',
      items: [
        { label: 'X（旧Twitter）', href: 'https://twitter.com/humitabphotnews',             dot: '#000' },
        { label: 'note',           href: 'https://note.com/humitabinewsphot',                dot: '#1A1A1A' },
        { label: 'Instagram',      href: 'https://www.instagram.com/humitabiphoto/',          dot: '#C13584' },
        { label: 'TikTok',         href: 'https://www.tiktok.com/@humitabitrafficnewsphoto', dot: '#010101' },
      ],
    },
  ];
  return (
    <div style={{ position: 'fixed', top: 85, left: 0, right: 0, bottom: 0, zIndex: 190, background: 'rgba(15,27,46,0.55)' }} onClick={onClose}>
      <div style={{ position: 'absolute', top: 0, right: 0, width: '100%', maxWidth: 360, height: '100%', background: C.white, overflowY: 'auto', boxShadow: '-4px 0 24px rgba(15,27,46,0.15)', padding: '48px 0 32px' }} onClick={e => e.stopPropagation()}>
        {menuSections.map((section, si) => (
          <div key={si} style={{ padding: '0 24px', marginBottom: 24 }}>
            <div style={{ fontSize: 11, fontWeight: 700, color: C.t3, letterSpacing: '0.1em', textTransform: 'uppercase', marginBottom: 10, paddingBottom: 6, borderBottom: `2px solid ${C.border}` }}>{section.title}</div>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 2 }}>
              {section.items.map((item, ii) => (
                item.href ? (
                  <a key={ii} href={item.href} target="_blank" rel="noreferrer" onClick={onClose} style={{ display: 'flex', alignItems: 'center', gap: 10, padding: '10px 12px', borderRadius: 6, fontSize: 14, color: C.t1, textDecoration: 'none' }}
                    onMouseEnter={e => e.currentTarget.style.background = C.bg}
                    onMouseLeave={e => e.currentTarget.style.background = 'transparent'}
                  >
                    {item.dot && <span style={{ width: 8, height: 8, borderRadius: '50%', background: item.dot, flexShrink: 0 }}></span>}
                    {item.label}
                  </a>
                ) : (
                  <button key={ii} onClick={item.action} style={{ display: 'flex', alignItems: 'center', gap: 10, padding: '10px 12px', borderRadius: 6, fontSize: 14, color: C.t1, background: 'none', border: 'none', cursor: 'pointer', textAlign: 'left', width: '100%', fontFamily: 'inherit' }}
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
        <div style={{ padding: '0 24px' }}>
          <div style={{ background: C.main, borderRadius: 8, padding: 20, color: '#fff' }}>
            <div style={{ fontSize: 11, opacity: 0.75, marginBottom: 4 }}>お問い合わせ</div>
            <div style={{ fontSize: 14, fontWeight: 700, marginBottom: 10 }}>E-MAIL</div>
            <a href="mailto:humitabiphoto@gmail.com" style={{ display: 'block', background: C.accent, color: '#fff', borderRadius: 6, padding: '10px 14px', fontSize: 13, fontWeight: 700, textAlign: 'center', wordBreak: 'break-all', textDecoration: 'none' }}>humitabiphoto@gmail.com</a>
            <div style={{ fontSize: 10, opacity: 0.6, marginTop: 8, lineHeight: 1.6 }}>お電話での対応は行っておりません。</div>
          </div>
        </div>
      </div>
    </div>
  );
};

/* ─── Footer ─── */
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
          ['Instagram',      'https://www.instagram.com/humitabiphoto/'],
          ['TikTok',         'https://www.tiktok.com/@humitabitrafficnewsphoto'],
          ['お問い合わせ',       '<?php echo home_url("/contact/"); ?>'],
          ['プライバシーポリシー', '<?php echo home_url("/privacy/"); ?>'],
        ].map(([lbl, href]) => (
          <a key={lbl} href={href} target="_blank" rel="noreferrer" style={{ color: 'rgba(255,255,255,0.55)', fontSize: 12 }}>{lbl}</a>
        ))}
      </div>
      <div style={{ borderTop: '1px solid rgba(255,255,255,0.1)', paddingTop: 16, display: 'flex', justifyContent: 'space-between', flexWrap: 'wrap', gap: 8 }}>
        <div style={{ fontSize: 11, color: 'rgba(255,255,255,0.35)' }}>© 鹿児島地域交通通信社 All Rights Reserved.</div>
        <div style={{ fontSize: 11, color: 'rgba(255,255,255,0.35)' }}>E-MAIL: humitabiphoto@gmail.com</div>
      </div>
    </div>
  </footer>
);
</script>
