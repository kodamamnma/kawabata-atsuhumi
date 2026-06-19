<?php
/**
 * Template Name: 私たちについて
 */
get_header();
?>

<script type="text/babel">
const Sidebar = () => (
  <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
    <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', overflow: 'hidden' }}>
      <div style={{ background: C.main, color: '#fff', padding: '10px 14px', fontSize: 13, fontWeight: 700 }}>私たちについて</div>
      <Img h={100} src={IMGS.corporate} style={{ width: '100%' }} />
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

const TimelineItem = ({ year, events }) => (
  <div style={{ display: 'flex', gap: 20, marginBottom: 24 }}>
    <div style={{ flexShrink: 0, width: 64 }}>
      <div style={{ fontSize: 16, fontWeight: 700, color: C.main }}>{year}</div>
    </div>
    <div style={{ flex: 1, borderLeft: `2px solid ${C.border}`, paddingLeft: 20, paddingBottom: 8 }}>
      {events.map((ev, i) => (
        <div key={i} style={{ position: 'relative', marginBottom: i < events.length - 1 ? 10 : 0 }}>
          <div style={{ position: 'absolute', left: -26, top: 5, width: 10, height: 10, borderRadius: '50%', background: ev.accent ? C.accent : C.sub, border: `2px solid ${C.white}`, boxShadow: `0 0 0 2px ${ev.accent ? C.accent : C.sub}` }}></div>
          {ev.month && <span style={{ fontSize: 11, fontWeight: 700, color: C.t3, marginRight: 8 }}>{ev.month}</span>}
          <span style={{ fontSize: 13, color: C.t1, lineHeight: 1.6 }}>{ev.text}</span>
        </div>
      ))}
    </div>
  </div>
);

const InfoRow = ({ label, value, isLink }) => (
  <div style={{ display: 'flex', borderBottom: `1px solid ${C.border}`, padding: '12px 0' }}>
    <div style={{ width: 140, flexShrink: 0, fontSize: 13, fontWeight: 700, color: C.t2 }}>{label}</div>
    <div style={{ flex: 1, fontSize: 13, color: C.t1, lineHeight: 1.7 }}>
      {isLink ? <a href={value.href} target="_blank" rel="noreferrer" style={{ color: C.sub }}>{value.text}</a> : value}
    </div>
  </div>
);

function App() {
  const [menuOpen, setMenuOpen] = React.useState(false);

  const timeline = [
    { year: '2019', events: [{ month: '3月', text: 'YouTubeチャンネル「ふみたび」開設', accent: true }] },
    { year: '2020', events: [{ month: '3月', text: '新型コロナウイルスの影響により動画自粛' }] },
    { year: '2022', events: [{ month: '7月', text: '本格的な記事書き開始' }, { month: '9月', text: '西九州新幹線開業特集掲載', accent: true }] },
    { year: '2023', events: [{ month: '3月', text: '七隈線博多延伸特集掲載', accent: true }, { month: '4月', text: '本格的に記事を掲載開始' }, { month: '9月', text: 'YouTube・TikTok開始' }, { month: '10月', text: 'YouTubeチャンネル「ふみたび」を合併し、史旅編集・交通報道の管轄へ・ホームページ公開', accent: true }] },
    { year: '2024', events: [{ month: '3月', text: '一部記事有料化、noteへ本格的に記事をUP、ふみたびYouTubeチャンネルを改名し史旅編集・交通報道へ' }] },
    { year: '2025', events: [{ month: '7月', text: 'ドメインを取得し、公式コーポレートサイト・ニュースサイトを公開（7月16日）', accent: true }] },
    { year: '2026', events: [{ month: '3月', text: '名称を史旅編集・交通報道から「鹿児島地域交通通信社」へ変更', accent: true }, { month: '6月', text: 'ホームページ・ニュースサイトリニューアル', accent: true }] },
  ];

  return (
    <div>
      <Header menuOpen={menuOpen} setMenuOpen={setMenuOpen} />
      <MobileMenu open={menuOpen} onClose={() => setMenuOpen(false)} />

      <div style={{ background: C.white, borderBottom: `1px solid ${C.border}` }}>
        <div style={{ maxWidth: 1160, margin: '0 auto', padding: '8px 16px', display: 'flex', gap: 8, alignItems: 'center', fontSize: 12, color: C.t3 }}>
          <a href="<?php echo home_url('/'); ?>" style={{ color: C.sub }}>トップ</a>
          <span>›</span>
          <span style={{ color: C.t1 }}>私たちについて</span>
        </div>
      </div>

      <main style={{ maxWidth: 1160, margin: '0 auto', padding: '24px 16px 0' }}>
        <div className="layout-grid">

          <div style={{ marginBottom: 24 }}>
            <h1 style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 22, fontWeight: 700, color: C.t1, marginBottom: 4 }}>私たちについて</h1>
            <div style={{ fontSize: 12, color: C.t3 }}>About Us</div>
          </div>

          <div style={{ background: C.main, borderRadius: 4, overflow: 'hidden', marginBottom: 24, display: 'flex', gap: 0 }}>
            <Img h={200} src={IMGS.corporate} style={{ width: '45%' }} />
            <div style={{ flex: 1, padding: '28px 24px', display: 'flex', flexDirection: 'column', justifyContent: 'center' }}>
              <div style={{ fontSize: 11, color: 'rgba(255,255,255,0.6)', letterSpacing: '0.1em', marginBottom: 8 }}>MISSION</div>
              <div style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 18, fontWeight: 700, color: '#fff', lineHeight: 1.5, marginBottom: 12 }}>「公共交通と地域文化を世の中へ」</div>
              <div style={{ fontSize: 12, color: 'rgba(255,255,255,0.75)', lineHeight: 1.8 }}>鹿児島県内の公共交通と地域情報を中心に取材・報道するメディアです。交通の今を世の中へ届け続ける、交通報道専門の通信社を目指しています。</div>
            </div>
          </div>

          <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', padding: '20px', marginBottom: 20 }}>
            <SH>鹿児島地域交通通信社について</SH>
            <p style={{ fontSize: 13, color: C.t2, lineHeight: 1.9 }}>鹿児島地域交通通信社は、2019年にYouTubeチャンネル「ふみたび」から始まり、それ以降交通の記念行事や乗車記などを展開しておりました。2022年に「史旅編集・交通報道」を発足し、公共交通と鹿児島の地域情報を伝えるニュースメディアとして公共交通をメインに記事を書き続け、2026年3月に「鹿児島地域交通通信社」へ名称変更後も、インターネット・SNSを通して全世界へ発信し続けています。</p>
            <p style={{ fontSize: 13, color: C.t2, lineHeight: 1.9, marginTop: 12 }}>交通の今を世の中へ届け続ける、交通報道専門の新聞社・通信社を目指して、世の中を生きる人や世界中の方々へ交通の魅力や面白さを伝え続けることを目指し、編集長の生まれ故郷である鹿児島の魅力や面白さを伝えるとともに、小さい頃から好きだった公共交通の良さや面白さを伝え続けられるように、取材し記事を書いております。</p>
          </div>

          <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', padding: '20px', marginBottom: 20 }}>
            <SH color={C.accent}>編集長メッセージ</SH>
            <div style={{ display: 'flex', gap: 20, alignItems: 'flex-start', marginBottom: 16 }}>
              <Img h={120} src={IMGS.editor} style={{ width: 96, borderRadius: 4, flexShrink: 0 }} />
              <div>
                <div style={{ fontSize: 13, fontWeight: 700, color: C.main, marginBottom: 2 }}>川畑 篤史</div>
                <div style={{ fontSize: 11, color: C.t3, marginBottom: 8 }}>鹿児島地域交通通信社 編集長</div>
                <div style={{ fontSize: 12, color: C.t2, lineHeight: 1.8 }}>ご覧いただきありがとうございます。鹿児島地域交通通信社の川畑と申します。</div>
              </div>
            </div>
            {[
              '鹿児島地域交通通信社は、2022年に史旅編集・交通報道としてスタートし、公共交通を主とした報道をしていくべく、立ち上げたメディアになります。公共交通の報じるようになったのは、鹿児島県内で行われる様々な交通イベントを、もっと世の中へ、もっと全国へ広め、より興味を持ってもらう。そのきっかけになりたいという思いからでした。',
              '公共交通も地域も、時を過ぎることに代わり続け、様々な変化を遂げております。鹿児島も新たなビルも建ち始め、より都会に近づいています。そんな鹿児島の中でも昔懐かしさが残る場所や、どの時代になっても色褪せることのない場所も多く残ります。公共交通も地域文化も同じです。鹿児島地域交通通信社は、新しさも懐かしさも、その変化を逃さずに、なるべく多くの記事を届けられるよう、努力してまいります。',
              '「鹿児島の公共交通と地域文化を盛り上げる」私自身が大事にしている、この思いを胸に、今日も記事を書き続けて参ります。',
            ].map((p, i) => (
              <p key={i} style={{ fontSize: 13, color: C.t2, lineHeight: 1.9, marginBottom: i < 2 ? 12 : 0 }}>{p}</p>
            ))}
          </div>

          <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', padding: '20px', marginBottom: 20 }}>
            <SH>撮影・記事理念 / ビジョン</SH>
            <div style={{ background: C.mainLight, borderRadius: 4, padding: '16px 20px', marginBottom: 16, border: `1px solid ${C.subLight}` }}>
              <div style={{ fontSize: 11, fontWeight: 700, color: C.sub, letterSpacing: '0.08em', marginBottom: 6 }}>VISION</div>
              <div style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 16, fontWeight: 700, color: C.main, marginBottom: 8 }}>「公共交通と地域文化を世の中へ」</div>
              <p style={{ fontSize: 13, color: C.t2, lineHeight: 1.8 }}>2022年の史旅編集・交通報道発足時のビジョンをより簡潔にし、世の中の人々へ公共交通と地域文化の面白さを伝え続けます。</p>
            </div>
            <div style={{ background: '#FFF8F0', borderRadius: 4, padding: '16px 20px', marginBottom: 16, border: `1px solid ${C.accent}` }}>
              <div style={{ fontSize: 11, fontWeight: 700, color: C.accent, letterSpacing: '0.08em', marginBottom: 6 }}>VISION PLUS</div>
              <div style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 15, fontWeight: 700, color: C.t1, marginBottom: 8 }}>その土地の交通を知り尽くした記者達が、どこにも負けない記事力と知識で、交通の今と未来を作り出す。</div>
              <p style={{ fontSize: 13, color: C.t2, lineHeight: 1.8 }}>鹿児島にゆかりのある記者らが、記事を通して伝えたい思いや地域の想いを記事にし続け、鹿児島地域交通通信社だからこそできる形で、世の中を生きる全ての人へ伝え続けます。</p>
            </div>
            <div style={{ fontSize: 13, fontWeight: 700, color: C.t1, marginBottom: 10 }}>報道指針</div>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 10 }}>
              {[
                { label: '基本方針', text: 'どこにも偏らない情報と信頼性のある記事を届けるために、常に情報を受け取る人の目線に立ち、交通文化の発展に貢献できる記事作りを目指す。' },
                { label: '取材手段と情報源への確認および取り扱い', text: '公式的に発表されているもので、かつ裏取りができている情報以外を使用する。情報提供を受けた場合でも同様の対応を経て記事とする。公開情報に関しては、どのような理由でも第三者への開示要求には応じず、情報提供者のプライバシーを尊重する。' },
              ].map(({ label, text }) => (
                <div key={label} style={{ borderLeft: `3px solid ${C.border}`, paddingLeft: 14 }}>
                  <div style={{ fontSize: 12, fontWeight: 700, color: C.sub, marginBottom: 4 }}>/{label}/</div>
                  <p style={{ fontSize: 12, color: C.t2, lineHeight: 1.8 }}>{text}</p>
                </div>
              ))}
            </div>
          </div>

          <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', padding: '20px', marginBottom: 20 }}>
            <SH>概要</SH>
            <div style={{ borderTop: `1px solid ${C.border}` }}>
              <InfoRow label="名称" value={<>鹿児島地域交通通信社<br /><span style={{ fontSize: 11, color: C.t3 }}>（かごしまちいきこうつうつうしんしゃ）</span></>} />
              <InfoRow label="代表者" value="川畑 篤史" />
              <InfoRow label="運用形態" value="個人運営メディア" />
              <InfoRow label="拠点" value="〒892-0816 鹿児島県鹿児島市山下町17-4 第一照国ビル yokoito事務所内" />
              <InfoRow label="内容" value="鹿児島県内の公共交通・地域情報の取材・撮影・報道。公共交通・鹿児島県内に関する情報発信" />
              <InfoRow label="発足" value="2019年3月9日" />
              <InfoRow label="資本金" value="非公開" />
              <InfoRow label="人数" value="非公開" />
              <InfoRow label="FAX" value={<>（確認中・随時更新）<br /><span style={{ fontSize: 11, color: C.t3 }}>※お問い合わせは基本的にメールにて承ります</span></>} />
              <InfoRow label="メール" value={<><a href="mailto:humitabiphoto@gmail.com" style={{ color: C.sub }}>humitabiphoto@gmail.com</a><br /><span style={{ fontSize: 11, color: C.t3 }}>※お問い合わせはメールを優先してご利用ください</span></>} />
            </div>
          </div>

          <div style={{ background: C.white, borderRadius: 4, boxShadow: '0 1px 4px rgba(27,58,107,0.10)', padding: '20px', marginBottom: 24 }}>
            <SH color={C.sub}>年表</SH>
            <div style={{ paddingLeft: 4 }}>
              {timeline.map((item, i) => <TimelineItem key={i} {...item} />)}
            </div>
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
