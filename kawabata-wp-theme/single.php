<?php get_header(); ?>

<style>
/* 記事本文スタイル */
.article-body p { font-size: 15px; line-height: 2.0; color: #1a2940; margin-bottom: 20px; }
.article-body h2 { font-family: 'Noto Serif JP', serif; font-size: 19px; font-weight: 700; color: var(--main); margin: 32px 0 14px; padding: 10px 16px; border-left: 4px solid var(--accent); background: var(--main-light); border-radius: 0 4px 4px 0; }
.article-body h3 { font-family: 'Noto Serif JP', serif; font-size: 16px; font-weight: 700; color: var(--text-1); margin: 24px 0 10px; padding-bottom: 6px; border-bottom: 2px solid var(--border); }
.article-body figure { margin: 24px 0; }
.article-body figure img { width: 100%; border-radius: 4px; display: block; }
.article-body figcaption { font-size: 12px; color: var(--text-3); margin-top: 6px; text-align: center; line-height: 1.6; }
.article-body blockquote { border-left: 4px solid var(--sub); padding: 12px 20px; background: var(--main-light); margin: 20px 0; border-radius: 0 4px 4px 0; font-size: 14px; color: var(--text-2); line-height: 1.85; }
.article-body ul, .article-body ol { padding-left: 22px; margin-bottom: 18px; }
.article-body li { font-size: 15px; line-height: 1.9; color: #1a2940; margin-bottom: 4px; }
.article-body .info-box { background: #FFF8F0; border: 1px solid var(--accent); border-radius: 4px; padding: 16px 20px; margin: 24px 0; }
.article-body .info-box-title { font-size: 12px; font-weight: 700; color: var(--accent); letter-spacing: 0.08em; margin-bottom: 8px; }
.article-body .info-box p { font-size: 13px; margin-bottom: 0; color: var(--text-2); }
.article-body table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 13px; }
.article-body th { background: var(--main); color: #fff; padding: 10px 14px; text-align: left; font-weight: 700; }
.article-body td { padding: 9px 14px; border-bottom: 1px solid var(--border); color: var(--text-2); line-height: 1.7; }
.article-body tr:nth-child(even) td { background: var(--main-light); }
</style>

<script type="text/babel">
/* ─── WordPress から渡される個別記事データ ─── */
const ARTICLE = (typeof ARTICLE_DATA !== 'undefined') ? ARTICLE_DATA : {
  cat: '鉄道',
  badge: null,
  title: '記事タイトル',
  published: '',
  updated: '',
  author: '',
  tags: [],
  src: null,
  caption: '',
  content: '',
};

/* ─── ShareBar ─── */
const ShareBar = ({ title, href }) => {
  const enc = encodeURIComponent;
  const tweetUrl = `https://twitter.com/intent/tweet?text=${enc(title)}&url=${enc(href || window.location.href)}`;
  const lineUrl  = `https://line.me/R/msg/text/?${enc(title + ' ' + (href || window.location.href))}`;

  return (
    <div style={{ display: 'flex', gap: 10, flexWrap: 'wrap', alignItems: 'center', marginBottom: 8 }}>
      <a href={tweetUrl} target="_blank" rel="noreferrer" style={{ display: 'flex', alignItems: 'center', gap: 6, padding: '8px 16px', borderRadius: 20, border: `1px solid ${C.border}`, background: C.white, color: C.t1, fontSize: 13, fontWeight: 700, textDecoration: 'none' }}
        onMouseEnter={e => { e.currentTarget.style.background='#000'; e.currentTarget.style.color='#fff'; e.currentTarget.style.borderColor='#000'; }}
        onMouseLeave={e => { e.currentTarget.style.background=C.white; e.currentTarget.style.color=C.t1; e.currentTarget.style.borderColor=C.border; }}
      >
        <span style={{ fontWeight: 900 }}>𝕏</span> X でシェア
      </a>
      <a href={lineUrl} target="_blank" rel="noreferrer" style={{ display: 'flex', alignItems: 'center', gap: 6, padding: '8px 16px', borderRadius: 20, border: '1px solid #06C755', background: C.white, color: '#06C755', fontSize: 13, fontWeight: 700, textDecoration: 'none' }}
        onMouseEnter={e => { e.currentTarget.style.background='#06C755'; e.currentTarget.style.color='#fff'; }}
        onMouseLeave={e => { e.currentTarget.style.background=C.white; e.currentTarget.style.color='#06C755'; }}
      >
        LINE で送る
      </a>
    </div>
  );
};

/* ─── RelatedArticles ─── */
const RELATED_ARTICLES = (typeof WP_ARTICLES !== 'undefined' && Array.isArray(WP_ARTICLES))
  ? WP_ARTICLES.filter(a => a.cat === ARTICLE.cat).slice(0, 3)
  : [];

const RelatedArticles = () => (
  <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', padding: 20, marginBottom: 24 }}>
    <div style={{ borderLeft: `4px solid ${C.accent}`, paddingLeft: 10, marginBottom: 16 }}>
      <span style={{ fontSize: 15, fontWeight: 700, color: C.t1 }}>関連記事</span>
    </div>
    {RELATED_ARTICLES.length > 0 ? (
      <div style={{ display: 'flex', flexDirection: 'column', gap: 0 }}>
        {RELATED_ARTICLES.map((item, i) => (
          <a key={i} href={item.href || '#'} style={{ display: 'flex', gap: 12, padding: '10px 0', textDecoration: 'none', borderBottom: i < RELATED_ARTICLES.length - 1 ? `1px solid ${C.border}` : 'none', alignItems: 'center' }}
            onMouseEnter={e => e.currentTarget.querySelector('.rel-title').style.color = C.sub}
            onMouseLeave={e => e.currentTarget.querySelector('.rel-title').style.color = C.t1}
          >
            {item.src
              ? <img src={item.src} alt="" onError={e => e.currentTarget.style.display='none'} style={{ width: 80, height: 56, objectFit: 'cover', borderRadius: 3, flexShrink: 0 }} />
              : <div style={{ width: 80, height: 56, background: C.mainLight, borderRadius: 3, flexShrink: 0 }} />
            }
            <div style={{ flex: 1 }}>
              <span style={{ fontSize: 9, fontWeight: 700, padding: '1px 5px', borderRadius: 2, background: CAT_COLORS[item.cat] || C.main, color: '#fff' }}>{item.cat}</span>
              <div className="rel-title" style={{ fontSize: 13, fontWeight: 700, lineHeight: 1.5, color: C.t1, marginTop: 4, transition: 'color 0.15s' }}>{item.title}</div>
              <div style={{ fontSize: 11, color: C.t3, marginTop: 3 }}>{item.time}</div>
            </div>
          </a>
        ))}
      </div>
    ) : (
      <div style={{ fontSize: 13, color: C.t3, textAlign: 'center', padding: '16px 0' }}>関連記事はありません</div>
    )}
  </div>
);

/* ─── Sidebar ─── */
const Sidebar = () => {
  const SideHead = ({ children, color = C.main }) => (
    <div style={{ background: color, color: '#fff', padding: '10px 14px', fontSize: 13, fontWeight: 700 }}>{children}</div>
  );
  const latestArticles = (typeof WP_ARTICLES !== 'undefined' && Array.isArray(WP_ARTICLES)) ? WP_ARTICLES.slice(0, 5) : [];

  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
      <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', overflow: 'hidden' }}>
        <SideHead>最新ニュース</SideHead>
        <div style={{ padding: '8px 0' }}>
          {latestArticles.map((item, i) => (
            <a key={i} href={item.href || '#'} rel="noreferrer"
              style={{ display: 'flex', gap: 10, padding: '9px 14px', textDecoration: 'none', borderBottom: i < latestArticles.length - 1 ? `1px solid ${C.border}` : 'none', alignItems: 'flex-start' }}
              onMouseEnter={e => e.currentTarget.style.background = C.bg}
              onMouseLeave={e => e.currentTarget.style.background = 'transparent'}
            >
              {item.src
                ? <img src={item.src} alt="" onError={e => e.currentTarget.style.display='none'} style={{ width: 64, height: 46, objectFit: 'cover', borderRadius: 3, flexShrink: 0 }} />
                : <div style={{ width: 64, height: 46, background: C.mainLight, borderRadius: 3, flexShrink: 0 }} />
              }
              <div style={{ flex: 1, minWidth: 0 }}>
                <div style={{ display: 'flex', gap: 4, marginBottom: 3 }}>
                  <span style={{ fontSize: 9, fontWeight: 700, padding: '1px 5px', borderRadius: 2, background: CAT_COLORS[item.cat] || C.main, color: '#fff', flexShrink: 0 }}>{item.cat}</span>
                </div>
                <div style={{ fontSize: 12, fontWeight: 500, lineHeight: 1.5, color: C.t1, overflow: 'hidden', display: '-webkit-box', WebkitLineClamp: 2, WebkitBoxOrient: 'vertical' }}>{item.title}</div>
                <div style={{ fontSize: 10, color: C.t3, marginTop: 3 }}>{item.time}</div>
              </div>
            </a>
          ))}
        </div>
        <div style={{ padding: '8px 14px 12px' }}>
          <a href="<?php echo home_url('/'); ?>" style={{ display: 'block', textAlign: 'center', background: C.bg, border: `1px solid ${C.border}`, borderRadius: 4, padding: '7px 0', fontSize: 12, color: C.sub, fontWeight: 700 }}>記事一覧を見る →</a>
        </div>
      </div>
      <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', overflow: 'hidden' }}>
        <SideHead>私たちについて</SideHead>
        <img src={IMGS.corporate} alt="" onError={e => e.currentTarget.style.display='none'} style={{ width: '100%', height: 90, objectFit: 'cover', display: 'block' }} />
        <div style={{ padding: 14 }}>
          <div style={{ fontSize: 13, fontWeight: 700, color: C.main, marginBottom: 6 }}>鹿児島地域交通通信社</div>
          <div style={{ fontSize: 12, color: C.t2, lineHeight: 1.75, marginBottom: 12 }}>
            「公共交通と地域文化を世の中へ」を目指して、鹿児島県内の公共交通と地域情報を中心に取材・報道する個人運営のメディアです。2019年YouTubeチャンネル「ふみたび」から始まり、2026年に現在の名称へ。
          </div>
          <a href="<?php echo get_permalink(get_page_by_path('about')); ?>" style={{ display: 'block', textAlign: 'center', background: C.main, color: '#fff', borderRadius: 4, padding: '8px 0', fontSize: 12, fontWeight: 700 }}>概要案内を読む →</a>
        </div>
      </div>
      <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', overflow: 'hidden' }}>
        <SideHead>公式SNS・メディア</SideHead>
        <div style={{ padding: '12px 14px', display: 'flex', flexDirection: 'column', gap: 8 }}>
          {[
            { lbl: 'X（旧Twitter）', href: 'https://twitter.com/humitabphotnews', color: '#000' },
            { lbl: 'Instagram — 写真・動画', href: 'https://www.instagram.com/humitabiphoto/', color: '#C13584' },
            { lbl: 'TikTok — 動画コンテンツ', href: 'https://www.tiktok.com/@humitabitrafficnewsphoto', color: '#010101' },
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
};

function App() {
  const [menuOpen, setMenuOpen] = useState(false);
  const pageUrl = window.location.href;

  return (
    <div>
      <Header menuOpen={menuOpen} setMenuOpen={setMenuOpen} />
      <MobileMenu open={menuOpen} onClose={() => setMenuOpen(false)} />

      <div style={{ background: C.white, borderBottom: `1px solid ${C.border}` }}>
        <div style={{ maxWidth: 1160, margin: '0 auto', padding: '8px 16px', display: 'flex', gap: 6, alignItems: 'center', fontSize: 12, color: C.t3, flexWrap: 'wrap' }}>
          <a href="<?php echo home_url('/'); ?>" style={{ color: C.sub }}>トップ</a>
          <span>›</span>
          <a href="<?php echo get_post_type_archive_link('post'); ?>" style={{ color: C.sub }}>{ARTICLE.cat}</a>
          <span>›</span>
          <span style={{ color: C.t1, overflow: 'hidden', textOverflow: 'ellipsis', whiteSpace: 'nowrap', maxWidth: 320 }}>{ARTICLE.title}</span>
        </div>
      </div>

      <main style={{ maxWidth: 1160, margin: '0 auto', padding: '24px 16px 0' }}>
        <div className="layout-grid">

          <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', padding: '24px 24px 20px', marginBottom: 0, borderBottomLeftRadius: 0, borderBottomRightRadius: 0 }}>
            <div style={{ display: 'flex', gap: 6, marginBottom: 12, flexWrap: 'wrap' }}>
              <Badge color={CAT_COLORS[ARTICLE.cat] || C.main}>{ARTICLE.cat}</Badge>
              {ARTICLE.badge && (
                <Badge color={ARTICLE.badge === '速報' ? C.accent : ARTICLE.badge === '独自' ? '#6B3FA0' : C.sub}>{ARTICLE.badge}</Badge>
              )}
            </div>
            <h1 style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 'clamp(18px,3vw,26px)', fontWeight: 700, lineHeight: 1.5, color: C.t1, marginBottom: 16 }}>
              {ARTICLE.title}
            </h1>
            <div style={{ display: 'flex', gap: 16, alignItems: 'center', flexWrap: 'wrap', marginBottom: 16, paddingBottom: 16, borderBottom: `1px solid ${C.border}` }}>
              <div style={{ display: 'flex', gap: 12, fontSize: 11, color: C.t3 }}>
                <span>📅 {ARTICLE.published}</span>
                {ARTICLE.updated && <span>🔄 更新 {ARTICLE.updated}</span>}
              </div>
            </div>
            <ShareBar title={ARTICLE.title} href={pageUrl} />
          </div>

          <div style={{ background: C.white, borderRadius: 0, overflow: 'hidden', marginBottom: 0 }}>
            <figure style={{ margin: 0 }}>
              <img
                src={ARTICLE.src}
                alt={ARTICLE.title}
                onError={e => { e.currentTarget.src=''; e.currentTarget.style.display='none'; }}
                style={{ width: '100%', maxHeight: 420, objectFit: 'cover', display: 'block' }}
              />
              {ARTICLE.caption && (
                <figcaption style={{ fontSize: 12, color: C.t3, padding: '8px 24px', background: '#F8F9FC', borderBottom: `1px solid ${C.border}`, lineHeight: 1.6 }}>
                  {ARTICLE.caption}
                </figcaption>
              )}
            </figure>
          </div>

          <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', padding: '28px 28px 24px', marginBottom: 16, borderTopLeftRadius: 0, borderTopRightRadius: 0 }} className="article-body"
            dangerouslySetInnerHTML={{ __html: ARTICLE.content }}
          />

          <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', padding: '14px 20px', marginBottom: 16 }}>
            <div style={{ display: 'flex', gap: 8, flexWrap: 'wrap', alignItems: 'center' }}>
              <span style={{ fontSize: 12, fontWeight: 700, color: C.t3, marginRight: 4 }}>タグ：</span>
              {(ARTICLE.tags || []).map(tag => (
                <a key={tag} href={`/?tag=${encodeURIComponent(tag)}`}
                  style={{ fontSize: 12, color: C.sub, padding: '3px 10px', borderRadius: 20, border: `1px solid ${C.subLight}`, background: C.mainLight, textDecoration: 'none' }}
                  onMouseEnter={e => { e.currentTarget.style.background = C.sub; e.currentTarget.style.color = '#fff'; }}
                  onMouseLeave={e => { e.currentTarget.style.background = C.mainLight; e.currentTarget.style.color = C.sub; }}
                >#{tag}</a>
              ))}
            </div>
          </div>

          <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', padding: '16px 20px', marginBottom: 16 }}>
            <div style={{ fontSize: 12, fontWeight: 700, color: C.t2, marginBottom: 10 }}>この記事をシェアする</div>
            <ShareBar title={ARTICLE.title} href={pageUrl} />
          </div>

          <RelatedArticles />

          <aside className="sidebar-content" style={{ position: 'relative' }}>
            <div style={{ position: 'sticky', top: 96 }}>
              <Sidebar />
            </div>
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
