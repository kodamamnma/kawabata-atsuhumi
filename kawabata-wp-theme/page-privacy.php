<?php get_header(); ?>

<script type="text/babel">
function App() {
  const [menuOpen, setMenuOpen] = useState(false);

  return (
    <div>
      <Header menuOpen={menuOpen} setMenuOpen={setMenuOpen} />
      <MobileMenu open={menuOpen} onClose={() => setMenuOpen(false)} />

      <div style={{ background: C.white, borderBottom: `1px solid ${C.border}` }}>
        <div style={{ maxWidth: 1160, margin: '0 auto', padding: '8px 16px', display: 'flex', gap: 8, alignItems: 'center', fontSize: 12, color: C.t3 }}>
          <a href="<?php echo home_url('/'); ?>" style={{ color: C.sub }}>トップ</a>
          <span>›</span>
          <span style={{ color: C.t1 }}>プライバシーポリシー</span>
        </div>
      </div>

      <main style={{ maxWidth: 720, margin: '0 auto', padding: '40px 16px 80px' }}>

        <div style={{ marginBottom: 40, textAlign: 'center' }}>
          <h1 style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 24, fontWeight: 700, color: C.t1, marginBottom: 12 }}>プライバシーポリシー</h1>
          <div style={{ fontSize: 13, color: C.t2, lineHeight: 1.6 }}>
            鹿児島地域交通通信社（以下「当社」）における個人情報の取り扱い方針です。
          </div>
        </div>

        <div style={{ background: C.white, borderRadius: 8, boxShadow: '0 2px 12px rgba(27,58,107,0.06)', padding: '40px 32px' }}>
          <p style={{ fontSize: 13, color: C.t2, lineHeight: 1.9, marginBottom: 24 }}>
            鹿児島地域交通通信社（以下「当社」）は、ご利用者の個人情報の保護を重要な責務と認識し、以下のポリシーに従って適切に取り扱います。
          </p>
          {[
            { title: '個人情報の収集・利用', text: '当社は、お問い合わせへの対応・サービス改善・記事品質向上のために必要な範囲で個人情報を収集することがあります。収集した情報は、目的以外の用途には使用しません。' },
            { title: '第三者への提供', text: '当社は、法令に基づく場合を除き、ご本人の同意なく個人情報を第三者に提供・開示することはありません。' },
            { title: 'アクセス解析', text: '当サイトでは、サービス改善のためにアクセス解析ツールを使用する場合があります。収集データは個人を特定するものではありません。' },
            { title: '免責事項', text: '当社が提供する情報は可能な限り正確な情報を掲載するよう努めておりますが、情報の正確性・安全性等を保証するものではありません。掲載情報による損害について、当社は一切の責任を負いません。' },
            { title: '著作権', text: '当サイトに掲載されている文章・写真・動画等の著作権は、鹿児島地域交通通信社および各権利者に帰属します。無断転載・複製は禁じます。' },
            { title: 'お問い合わせ', text: 'プライバシーポリシーに関するお問い合わせは、下記メールアドレスまでご連絡ください。' },
          ].map(({ title, text }) => (
            <div key={title} style={{ borderLeft: `3px solid ${C.sub}`, paddingLeft: 16, marginBottom: 20 }}>
              <div style={{ fontSize: 14, fontWeight: 700, color: C.main, marginBottom: 8 }}>{title}</div>
              <p style={{ fontSize: 13, color: C.t2, lineHeight: 1.8, margin: 0 }}>{text}</p>
            </div>
          ))}

          <div style={{ marginTop: 24, padding: '16px 20px', background: '#F8FAFC', border: `1px solid ${C.border}`, borderRadius: 4, fontSize: 13, color: C.t2, lineHeight: 1.8 }}>
            <div style={{ fontSize: 14, fontWeight: 700, color: C.main, marginBottom: 8, borderBottom: `1px solid ${C.border}`, paddingBottom: 6 }}>運営者情報</div>
            <div><span style={{ fontWeight: 700, color: C.t1, display: 'inline-block', width: 70 }}>運営者：</span>鹿児島地域交通通信社　代表 川畑篤史</div>
            <div><span style={{ fontWeight: 700, color: C.t1, display: 'inline-block', width: 70 }}>所在地：</span>〒892-0816 鹿児島県鹿児島市山下町17-4 第一照国ビル yokoito事務所内</div>
            <div><span style={{ fontWeight: 700, color: C.t1, display: 'inline-block', width: 70 }}>電話番号：</span>080-4205-3515</div>
            <div><span style={{ fontWeight: 700, color: C.t1, display: 'inline-block', width: 70 }}>E-MAIL：</span><a href="mailto:humitabiphoto@gmail.com" style={{ color: C.sub }}>humitabiphoto@gmail.com</a></div>
          </div>
        </div>

      </main>

      <Footer />
    </div>
  );
}

ReactDOM.createRoot(document.getElementById('root')).render(<App />);
</script>

<?php get_footer(); ?>
