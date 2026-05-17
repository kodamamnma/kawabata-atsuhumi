<?php
/**
 * Template Name: お問い合わせ
 */
get_header();
?>

<script type="text/babel">
/* ─── フォームコンポーネント ─── */
const Input = ({ label, type = "text", required, placeholder, multiline }) => (
  <div style={{ marginBottom: 24 }}>
    <div style={{ fontSize: 13, fontWeight: 700, color: C.t2, marginBottom: 8, display: 'flex', alignItems: 'center', gap: 8 }}>
      {label}
      {required && <span style={{ background: '#E05D5D', color: '#fff', fontSize: 10, padding: '2px 6px', borderRadius: 2 }}>必須</span>}
    </div>
    {multiline ? (
      <textarea
        placeholder={placeholder}
        required={required}
        style={{ width: '100%', minHeight: 160, padding: 12, borderRadius: 4, border: `1px solid ${C.border}`, fontSize: 14, fontFamily: 'inherit', resize: 'vertical', background: '#F8FAFC' }}
        onFocus={e => e.target.style.borderColor = C.sub}
        onBlur={e => e.target.style.borderColor = C.border}
      />
    ) : (
      <input
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

function App() {
  const [menuOpen, setMenuOpen] = useState(false);
  const [isSubmitted, setIsSubmitted] = useState(false);

  const handleSubmit = (e) => {
    e.preventDefault();
    setIsSubmitted(true);
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
          <h1 style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 24, fontWeight: 700, color: C.t1, marginBottom: 12 }}>記事についてのご意見・ご感想</h1>
          <div style={{ fontSize: 13, color: C.t2, lineHeight: 1.6 }}>
            当サイトをご利用いただきありがとうございます。<br />
            記事に関するご意見やご感想など、以下のフォームよりお気軽にお寄せください。
          </div>
        </div>

        <div style={{ background: C.white, borderRadius: 8, boxShadow: '0 2px 12px rgba(27,58,107,0.06)', padding: '40px 32px' }}>
          {isSubmitted ? (
            <div style={{ textAlign: 'center', padding: '40px 0' }}>
              <div style={{ width: 64, height: 64, background: '#EEF3FA', color: C.sub, borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: 32, margin: '0 auto 20px' }}>✓</div>
              <h2 style={{ fontSize: 18, fontWeight: 700, color: C.t1, marginBottom: 12 }}>送信が完了しました</h2>
              <p style={{ fontSize: 14, color: C.t2, lineHeight: 1.6 }}>
                貴重なご意見・ご感想をお寄せいただき、誠にありがとうございます。<br />
                今後の記事作成の参考にさせていただきます。
              </p>
              <button onClick={() => setIsSubmitted(false)} style={{ marginTop: 24, background: 'none', border: 'none', color: C.sub, fontSize: 13, textDecoration: 'underline' }}>
                続けて投稿する
              </button>
            </div>
          ) : (
            <form onSubmit={handleSubmit}>
              <Input label="名前" placeholder="例：山田 太郎" required />
              <Input label="メールアドレス" type="email" placeholder="例：info@example.com" required />
              <Input label="記事のご意見・ご感想など" multiline placeholder="ご自由にお書きください" required />

              <div style={{ marginTop: 40, textAlign: 'center' }}>
                <button type="submit" style={{
                  background: '#12B8E6', color: '#fff', border: 'none', borderRadius: 40,
                  padding: '16px 64px', fontSize: 15, fontWeight: 700, cursor: 'pointer',
                  boxShadow: '0 4px 12px rgba(18,184,230,0.25)', transition: 'all 0.2s',
                  letterSpacing: '0.05em'
                }}
                  onMouseEnter={e => { e.currentTarget.style.transform = 'translateY(-2px)'; e.currentTarget.style.boxShadow = '0 6px 16px rgba(18,184,230,0.35)'; }}
                  onMouseLeave={e => { e.currentTarget.style.transform = 'none'; e.currentTarget.style.boxShadow = '0 4px 12px rgba(18,184,230,0.25)'; }}
                >
                  送信する
                </button>
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
