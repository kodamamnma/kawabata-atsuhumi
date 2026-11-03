<?php
/**
 * Template Name: お問い合わせ
 */
get_header();
?>

<script type="text/babel">
/* ─── フォームコンポーネント ─── */
// name/id/htmlFor はスクリーンリーダーの読み上げ・ブラウザの自動入力・送信処理のため
const Input = ({ name, label, type = "text", required, placeholder, multiline, autoComplete }) => (
  <div style={{ marginBottom: 24 }}>
    <label htmlFor={`contact-${name}`} style={{ fontSize: 13, fontWeight: 700, color: C.t2, marginBottom: 8, display: 'flex', alignItems: 'center', gap: 8 }}>
      {label}
      {required
        ? <span style={{ background: '#E05D5D', color: '#fff', fontSize: 10, padding: '2px 6px', borderRadius: 2 }}>必須</span>
        : <span style={{ background: C.t3, color: '#fff', fontSize: 10, padding: '2px 6px', borderRadius: 2 }}>任意</span>}
    </label>
    {multiline ? (
      <textarea
        id={`contact-${name}`}
        name={name}
        placeholder={placeholder}
        required={required}
        style={{ width: '100%', minHeight: 160, padding: 12, borderRadius: 4, border: `1px solid ${C.border}`, fontSize: 14, fontFamily: 'inherit', resize: 'vertical', background: '#F8FAFC' }}
        onFocus={e => e.target.style.borderColor = C.sub}
        onBlur={e => e.target.style.borderColor = C.border}
      />
    ) : (
      <input
        id={`contact-${name}`}
        name={name}
        autoComplete={autoComplete}
        type={type}
        placeholder={placeholder}
        required={required}
        style={{ width: '100%', padding: 12, borderRadius: 4, border: `1px solid ${C.border}`, fontSize: 14, fontFamily: 'inherit', background: '#F8FAFC' }}
        onFocus={e => e.target.style.borderColor = C.sub}
        onBlur={e => e.target.style.borderColor = C.border}
      />
    )}
  </div>
);

/* 受信処理はプラグイン「鹿児島地域交通通信社 お問い合わせフォーム」が担う */
const CONTACT_ENDPOINT = '<?php echo esc_js( esc_url_raw( rest_url( 'kawabata/v1/contact' ) ) ); ?>';

/* キーはプラグイン側 kcf_types() と一致させる */
const INQUIRY_TYPES = [
  ['tip',      '情報提供'],
  ['coverage', '取材・掲載のご依頼'],
  ['usage',    '写真・記事の利用'],
  ['ad',       '広告・タイアップのご相談'],
  ['feedback', '記事へのご意見・ご感想'],
  ['other',    'その他'],
];
const ORG_TYPES = ['coverage', 'usage', 'ad'];
const FALLBACK_ERROR = '送信できませんでした。時間をおいて再度お試しいただくか、info@kagoshima-news.jp までメールでお送りください。';

function App() {
  const [menuOpen, setMenuOpen] = useState(false);
  const [isSubmitted, setIsSubmitted] = useState(false);
  const [sending, setSending] = useState(false);
  const [error, setError] = useState('');
  // 記事末などのリンク（/contact/?type=tip）から来たとき用件を選んだ状態にする
  const [inquiryType, setInquiryType] = useState(() => {
    const t = new URLSearchParams(window.location.search).get('type');
    return INQUIRY_TYPES.some(([k]) => k === t) ? t : '';
  });
  const [startedAt, setStartedAt] = useState(() => Date.now());
  const latest = (typeof WP_ARTICLES !== 'undefined' && Array.isArray(WP_ARTICLES)) ? WP_ARTICLES.slice(0, 3) : [];

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (sending) return;
    const body = Object.fromEntries(new FormData(e.currentTarget).entries());
    body.started = startedAt;
    setSending(true);
    setError('');
    try {
      const res = await fetch(CONTACT_ENDPOINT, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(body),
      });
      const data = await res.json().catch(() => ({}));
      if (!res.ok || !data.ok) {
        // プラグイン停止時のWP標準エラー（英語）は見せず、案内文に差し替える
        throw new Error(data.code && String(data.code).startsWith('kcf_') ? data.message : FALLBACK_ERROR);
      }
      track('contact_submit', { inquiry_type: body.inquiry_type });
      setIsSubmitted(true);
      window.scrollTo(0, 0);
    } catch (err) {
      setError(err.message || FALLBACK_ERROR);
    } finally {
      setSending(false);
    }
  };

  return (
    <div>
      <Header menuOpen={menuOpen} setMenuOpen={setMenuOpen} />
      <MobileMenu open={menuOpen} onClose={() => setMenuOpen(false)} />

      <div style={{ background: C.white, borderBottom: `1px solid ${C.border}` }}>
        <div style={{ maxWidth: 1160, margin: '0 auto', padding: '8px 16px', display: 'flex', gap: 8, alignItems: 'center', fontSize: 12, color: C.t3 }}>
          <a href="<?php echo home_url('/'); ?>" style={{ color: C.sub }}>トップ</a>
          <span>›</span>
          <span style={{ color: C.t1 }}>お問い合わせ</span>
        </div>
      </div>

      <main style={{ maxWidth: 720, margin: '0 auto', padding: '40px 16px 80px' }}>

        <div style={{ marginBottom: 40, textAlign: 'center' }}>
          <h1 style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 24, fontWeight: 700, color: C.t1, marginBottom: 12 }}>お問い合わせ・情報提供・取材のご依頼</h1>
          <div style={{ fontSize: 13, color: C.t2, lineHeight: 1.6 }}>
            鹿児島の公共交通・地域の話題について、情報提供・取材のご依頼・写真や記事の利用・掲載のご相談を受け付けています。<br />
            通常3営業日以内に編集長の川畑から返信します。
          </div>
        </div>

        <div style={{ background: C.white, borderRadius: 8, boxShadow: '0 2px 12px rgba(27,58,107,0.06)', padding: '40px 32px' }}>
          {isSubmitted ? (
            <div style={{ textAlign: 'center', padding: '40px 0' }}>
              <div style={{ width: 64, height: 64, background: '#EEF3FA', color: C.sub, borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: 32, margin: '0 auto 20px' }}>✓</div>
              <h2 style={{ fontSize: 18, fontWeight: 700, color: C.t1, marginBottom: 12 }}>送信を受け付けました</h2>
              <p style={{ fontSize: 14, color: C.t2, lineHeight: 1.6 }}>
                お送りいただき、ありがとうございます。<br />
                3営業日以内に、編集長の川畑から返信します。
              </p>
              <a href="https://x.com/kagoshimanewsjp" target="_blank" rel="noreferrer" onClick={() => track('sns_click', { method: 'X' })}
                style={{ display: 'inline-block', marginTop: 24, background: C.t1, color: '#fff', borderRadius: 40, padding: '10px 28px', fontSize: 13, fontWeight: 700, textDecoration: 'none' }}>
                𝕏 最新の交通ニュースをXで受け取る
              </a>
              {latest.length > 0 && (
                <div style={{ marginTop: 32, textAlign: 'left' }}>
                  <div style={{ fontSize: 13, fontWeight: 700, color: C.t2, marginBottom: 8 }}>最新の記事</div>
                  {latest.map((item, i) => (
                    <a key={i} href={item.href || '#'} style={{ display: 'block', padding: '10px 0', borderTop: `1px solid ${C.border}`, fontSize: 13, fontWeight: 700, color: C.t1, lineHeight: 1.6, textDecoration: 'none' }}>
                      {item.title}
                      <span style={{ display: 'block', fontSize: 11, fontWeight: 400, color: C.t3, marginTop: 2 }}>{item.time}</span>
                    </a>
                  ))}
                </div>
              )}
              <button type="button" onClick={() => { setIsSubmitted(false); setStartedAt(Date.now()); }} style={{ marginTop: 24, background: 'none', border: 'none', color: C.sub, fontSize: 13, textDecoration: 'underline' }}>
                続けて送信する
              </button>
            </div>
          ) : (
            <form onSubmit={handleSubmit}>
              <fieldset style={{ border: 'none', padding: 0, margin: '0 0 24px' }}>
                <legend style={{ fontSize: 13, fontWeight: 700, color: C.t2, marginBottom: 8, display: 'flex', alignItems: 'center', gap: 8 }}>
                  ご用件
                  <span style={{ background: '#E05D5D', color: '#fff', fontSize: 10, padding: '2px 6px', borderRadius: 2 }}>必須</span>
                </legend>
                <div style={{ display: 'flex', flexWrap: 'wrap', gap: 8 }}>
                  {INQUIRY_TYPES.map(([key, label]) => (
                    <label key={key} style={{ display: 'flex', alignItems: 'center', gap: 6, padding: '8px 12px', borderRadius: 4, border: `1px solid ${inquiryType === key ? C.sub : C.border}`, background: inquiryType === key ? C.mainLight : '#F8FAFC', fontSize: 13, color: C.t1, cursor: 'pointer' }}>
                      <input type="radio" name="inquiry_type" value={key} required checked={inquiryType === key} onChange={() => setInquiryType(key)} />
                      {label}
                    </label>
                  ))}
                </div>
              </fieldset>
              <Input name="name" autoComplete="name" label="お名前" placeholder="例：山田 太郎" required />
              {ORG_TYPES.includes(inquiryType) && (
                <Input name="org" autoComplete="organization" label="会社・団体名" placeholder="例：〇〇観光協会" />
              )}
              <Input name="email" autoComplete="email" label="メールアドレス" type="email" placeholder="例：info@example.com" required />
              <Input name="message" label="ご用件の詳細" multiline placeholder="例：〇月〇日に〇〇駅でイベントを行います。取材をご検討いただけますか（日時・場所・URLがあればご記入ください）" required />
              <Input name="url" type="url" label="関連資料のURL" placeholder="例：https://example.com/press/" />

              {/* ボット対策。人には見えず、入力されていたら受信側で破棄する */}
              <div aria-hidden="true" style={{ position: 'absolute', left: -10000, width: 1, height: 1, overflow: 'hidden' }}>
                <label>ウェブサイト<input type="text" name="website" tabIndex={-1} autoComplete="off" /></label>
              </div>

              {error && (
                <div role="alert" style={{ marginTop: 16, padding: '12px 16px', borderRadius: 4, border: '1px solid #E05D5D', color: '#E05D5D', fontSize: 13, lineHeight: 1.7, whiteSpace: 'pre-line' }}>
                  {error}
                </div>
              )}

              <div style={{ marginTop: 40, textAlign: 'center' }}>
                <button type="submit" disabled={sending} style={{
                  background: '#12B8E6', color: '#fff', border: 'none', borderRadius: 40,
                  padding: '16px 32px', maxWidth: '100%', fontSize: 15, fontWeight: 700, cursor: sending ? 'wait' : 'pointer', opacity: sending ? 0.6 : 1,
                  boxShadow: '0 4px 12px rgba(18,184,230,0.25)', transition: 'all 0.2s',
                  letterSpacing: '0.05em'
                }}
                  onMouseEnter={e => { e.currentTarget.style.transform = 'translateY(-2px)'; e.currentTarget.style.boxShadow = '0 6px 16px rgba(18,184,230,0.35)'; }}
                  onMouseLeave={e => { e.currentTarget.style.transform = 'none'; e.currentTarget.style.boxShadow = '0 4px 12px rgba(18,184,230,0.25)'; }}
                >
                  {sending ? '送信中…' : '内容を送信する（3営業日以内に返信）'}
                </button>
                <p style={{ marginTop: 16, fontSize: 12, color: C.t3, lineHeight: 1.7, textAlign: 'left' }}>
                  送信内容は<a href="<?php echo home_url( '/privacy/' ); ?>" style={{ color: C.sub }}>プライバシーポリシー</a>に沿って、返信のためだけに使います。情報提供者のお名前は、ご本人の許可なく記事に掲載しません。
                </p>
              </div>
            </form>
          )}
        </div>

      </main>

      <Footer />
    </div>
  );
}

ReactDOM.createRoot(document.getElementById('root')).render(<App />);
</script>

<?php get_footer(); ?>
