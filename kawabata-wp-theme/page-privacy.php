<?php
/**
 * Template Name: プライバシーポリシー・利用規約
 */
get_header();
?>

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
          <span style={{ color: C.t1 }}>基本方針 / 報道指針 / 利用規約 / プライバシーポリシー</span>
        </div>
      </div>

      <main style={{ maxWidth: 780, margin: '0 auto', padding: '40px 16px 80px' }}>

        <div style={{ marginBottom: 40, textAlign: 'center' }}>
          <h1 style={{ fontFamily: "'Noto Serif JP',serif", fontSize: 'clamp(20px, 4vw, 24px)', fontWeight: 700, color: C.t1, marginBottom: 12, lineHeight: 1.4 }}>
            基本方針 / 報道指針 / 利用規約 / プライバシーポリシー
          </h1>
          <div style={{ fontSize: 13, color: C.t2, lineHeight: 1.6 }}>
            鹿児島地域交通通信社の基本姿勢、ご利用規約、および個人情報の取り扱い方針です。
          </div>
        </div>

        <div style={{ background: C.white, borderRadius: 8, boxShadow: '0 2px 12px rgba(27,58,107,0.06)', padding: '40px 32px' }}>
          
          {/* === 鹿児島地域交通通信社について === */}
          <div style={{ marginBottom: 32 }}>
            <h2 style={{ fontSize: 16, fontFamily: "'Noto Serif JP',serif", fontWeight: 700, color: C.main, borderLeft: `4px solid ${C.accent}`, paddingLeft: 12, marginBottom: 14 }}>
              鹿児島地域交通通信社について
            </h2>
            <p style={{ fontSize: 13, color: C.t2, lineHeight: 1.9, margin: 0 }}>
              鹿児島地域交通通信社は、鹿児島県内の公共交通と地域文化・イベントに関する動向を、迅速かつ客観的にお伝えするメディアです。
            </p>
          </div>

          {/* === 基本方針 / 報道指針 === */}
          <div style={{ marginBottom: 40 }}>
            <h2 style={{ fontSize: 16, fontFamily: "'Noto Serif JP',serif", fontWeight: 700, color: C.main, borderLeft: `4px solid ${C.accent}`, paddingLeft: 12, marginBottom: 16 }}>
              基本方針・報道指針
            </h2>
            
            <div style={{ borderLeft: `3px solid ${C.sub}`, paddingLeft: 16, marginBottom: 20 }}>
              <div style={{ fontSize: 14, fontWeight: 700, color: C.main, marginBottom: 6 }}>/基本方針/</div>
              <p style={{ fontSize: 13, color: C.t2, lineHeight: 1.8, margin: 0 }}>
                どこにも偏らない情報と信頼性のある記事を届けるために、常に情報を受け取る人の目線に立ち、交通文化の発展に貢献できる記事作りを目指す。
              </p>
            </div>

            <div style={{ borderLeft: `3px solid ${C.sub}`, paddingLeft: 16, marginBottom: 20 }}>
              <div style={{ fontSize: 14, fontWeight: 700, color: C.main, marginBottom: 6 }}>/取材手段と情報源への確認および取り扱い/</div>
              <p style={{ fontSize: 13, color: C.t2, lineHeight: 1.8, margin: 0 }}>
                公式的に発表されているもので、かつ裏取りができている情報のみを使用する。情報提供を受けた場合でも同様 of対応を経て記事とする。公開情報に関しては、どのような理由でも第三者への開示要求には応じず、情報提供者のプライバシーを尊重する。
              </p>
            </div>

            <div style={{ borderLeft: `3px solid ${C.sub}`, paddingLeft: 16, marginBottom: 20 }}>
              <div style={{ fontSize: 14, fontWeight: 700, color: C.main, marginBottom: 6 }}>独自のファクトチェック体制</div>
              <p style={{ fontSize: 13, color: C.t2, lineHeight: 1.8, marginBottom: 10 }}>
                記事の信頼性を担保し、ヒューマンエラーや情報の矛盾を未然に防ぐため、全記事において「2段階プロセス」による厳格なファクトチェックを実施します。
              </p>
              <ul style={{ paddingLeft: 20, margin: 0, fontSize: 13, color: C.t2, lineHeight: 1.85 }}>
                <li style={{ marginBottom: 4 }}>取材データから重要項目（日時・場所・人物・数字）を抽出し、矛盾点や違和感の洗い出しを事前に行う。</li>
                <li>上記の確認事項をクリアした事実のみを用いて、最終的な記事の執筆を行う。</li>
              </ul>
            </div>
          </div>

          {/* === 運営者情報 === */}
          <div style={{ marginBottom: 40, padding: '20px', background: '#F8FAFC', border: `1px solid ${C.border}`, borderRadius: 6 }}>
            <div style={{ fontSize: 14, fontWeight: 700, color: C.main, marginBottom: 12, borderBottom: `1px solid ${C.border}`, paddingBottom: 6 }}>
              ■ 運営者情報
            </div>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 8, fontSize: 13, color: C.t2, lineHeight: 1.7 }}>
              <div><span style={{ fontWeight: 700, color: C.t1, display: 'inline-block', width: 150 }}>媒体名:</span>鹿児島地域交通通信社</div>
              <div><span style={{ fontWeight: 700, color: C.t1, display: 'inline-block', width: 150 }}>代表者・編集責任者:</span>川畑 篤史</div>
              <div><span style={{ fontWeight: 700, color: C.t1, display: 'inline-block', width: 150 }}>所在地:</span>〒892-0816 鹿児島県鹿児島市山下町17-4 第一照国ビル ヨコチャレの事務所内</div>
              <div><span style={{ fontWeight: 700, color: C.t1, display: 'inline-block', width: 150 }}>お問い合わせ:</span><a href="mailto:kagoshimaregionaltransport@kagoshima-news.jp" style={{ color: C.sub }}>kagoshimaregionaltransport@kagoshima-news.jp</a></div>
            </div>
          </div>

          {/* === 利用規約 === */}
          <div style={{ marginBottom: 40 }}>
            <h2 style={{ fontSize: 16, fontFamily: "'Noto Serif JP',serif", fontWeight: 700, color: C.main, borderLeft: `4px solid ${C.sub}`, paddingLeft: 12, marginBottom: 16 }}>
              利用規約
            </h2>
            <p style={{ fontSize: 13, color: C.t2, lineHeight: 1.9, marginBottom: 24 }}>
              この利用規約（以下、「本規約」といいます。）は、鹿児島地域交通通信社（以下、「当メディア」といいます。）が提供するウェブサイトおよび関連サービス（以下、「本サービス」といいます。）の利用条件を定めるものです。本サービスをご利用になる読者の皆様（以下、「ユーザー」といいます。）は、本規約に同意したものとみなします。
            </p>

            {[
              {
                title: '第1条（サービスの目的と提供）',
                text: '当メディアは、鹿児島県内の公共交通や地域文化に関するニュース記事を原則として無料で広く公開します。本サービスの内容は、事前の通知なく変更または提供を中止することがあります。'
              },
              {
                title: '第2条（読者からの支援・サポートについて）',
                points: [
                  'ユーザーは、当メディアの報道活動に賛同する場合、Googleが提供するシステム（Reader Revenue Manager等）を通じて、任意の金額による金銭的支援（寄付・サポート）を行うことができます。',
                  '支援はユーザーの自由な意思に基づくものであり、特定の対価（有料限定記事の閲覧など）を提供するものではありません。',
                  '決済手続き完了後の支援金については、理由の如何を問わず返金・キャンセルには応じかねますので、あらかじめご了承ください。'
                ]
              },
              {
                title: '第3条（著作権および知的財産権）',
                text: '本サービスに掲載されている記事、写真、イラスト、ロゴ等のすべてのコンテンツに関する著作権および知的財産権は、当メディアまたは正当な権利を有する第三者に帰属します。無断での転載、複製、改変、頒布などの行為は固く禁じます。'
              },
              {
                title: '第4条（免責事項）',
                points: [
                  '当メディアは、独自のファクトチェック体制に基づき正確な情報提供に努めておりますが、掲載内容の完全性、正確性、有用性を完全に保証するものではありません。',
                  '本サービスの利用により生じたトラブルや損害について、当メディアは一切の責任を負いません。',
                  'ユーザーの通信環境やシステムの障害等により生じた損害についても、当メディアは責任を負わないものとします。'
                ]
              },
              {
                title: '第5条（規約の変更）',
                text: '当メディアは、必要と判断した場合には、ユーザーに事前に通知することなくいつでも本規約を変更することができるものとします。'
              },
              {
                title: '第6条（準拠法・裁判管轄）',
                text: '本規約の解釈にあたっては、日本法を準拠法とします。本サービスに関して紛争が生じた場合には、当メディアの所在地を管轄する裁判所を専属的合意管轄とします。'
              }
            ].map((clause, idx) => (
              <div key={idx} style={{ marginBottom: 20 }}>
                <div style={{ fontSize: 13, fontWeight: 700, color: C.t1, marginBottom: 6 }}>{clause.title}</div>
                {clause.text && <p style={{ fontSize: 13, color: C.t2, lineHeight: 1.8, margin: 0 }}>{clause.text}</p>}
                {clause.points && (
                  <ol style={{ paddingLeft: 20, margin: 0, fontSize: 13, color: C.t2, lineHeight: 1.8 }}>
                    {clause.points.map((pt, pidx) => <li key={pidx} style={{ marginBottom: 4 }}>{pt}</li>)}
                  </ol>
                )}
              </div>
            ))}

            <div style={{ fontSize: 12, color: C.t3, textAlign: 'right', marginTop: 16 }}>
              附則 本規約は、2026年3月24日より施行します。
            </div>
          </div>

          {/* === プライバシーポリシー === */}
          <div>
            <h2 style={{ fontSize: 16, fontFamily: "'Noto Serif JP',serif", fontWeight: 700, color: C.main, borderLeft: `4px solid ${C.sub}`, paddingLeft: 12, marginBottom: 16 }}>
              プライバシーポリシー
            </h2>
            <p style={{ fontSize: 13, color: C.t2, lineHeight: 1.9, marginBottom: 24 }}>
              鹿児島地域交通通信社（以下、「当メディア」といいます。）は、ユーザーの皆様の個人情報の取扱いについて、以下のとおりプライバシーポリシー（以下、「本ポリシー」といいます。）を定めます。
            </p>

            {[
              {
                title: '第1条（個人情報の収集方法）',
                text: '当メディアは、以下の目的でユーザーの個人情報（氏名、メールアドレス、Googleアカウント情報など）を収集する場合があります。',
                points: [
                  'お問い合わせフォームやメールでのご連絡時',
                  '読者からの支援（Google Reader Revenue Manager等の決済システム）をご利用される時'
                ]
              },
              {
                title: '第2条（個人情報の利用目的）',
                text: '当メディアが個人情報を利用する目的は、以下のとおりです。',
                points: [
                  'ユーザーからのお問い合わせに回答するため（本人確認を行うことを含む）',
                  '読者からの支援・サポートの受付、およびそれに関する必要不可欠な連絡のため',
                  'サービスの利用状況を分析し、より良い記事作りやシステム改善に役立てるため',
                  '上記の利用目的に付随する目的'
                ]
              },
              {
                title: '第3条（個人情報の第三者提供）',
                text: '当メディアは、情報提供者のプライバシーを最大限尊重し、いかなる理由においても第三者への開示要求には応じません。ただし、法令に基づく場合や、人の生命・財産の保護のために必要があり、本人の同意を得ることが困難な場合はこの限りではありません。'
              },
              {
                title: '第4条（アクセス解析ツールについて）',
                text: '本サービスでは、Googleによるアクセス解析ツール（Google Analytics、Google Search Console等）を利用しています。これらのツールはトラフィックデータの収集のためにCookieを使用しています。このデータは匿名で収集されており、個人を特定するものではありません。ユーザーはブラウザの設定によりCookieを無効にすることで収集を拒否することができます。'
              },
              {
                title: '第5条（プライバシーポリシーの変更）',
                text: '本ポリシーの内容は、法令その他本ポリシーに別段の定めのある事項を除いて、ユーザーに通知することなく変更することができるものとします。変更後のプライバシーポリシーは、本ウェブサイトに掲載したときから効力を生じるものとします。'
              },
              {
                title: '第6条（お問い合わせ窓口）',
                text: '本ポリシーに関するお問い合わせは、下記の窓口までお願いいたします。',
                address: true
              }
            ].map((clause, idx) => (
              <div key={idx} style={{ marginBottom: 20 }}>
                <div style={{ fontSize: 13, fontWeight: 700, color: C.t1, marginBottom: 6 }}>{clause.title}</div>
                {clause.text && <p style={{ fontSize: 13, color: C.t2, lineHeight: 1.8, marginBottom: clause.points ? 6 : 0 }}>{clause.text}</p>}
                {clause.points && (
                  <ul style={{ paddingLeft: 20, margin: 0, fontSize: 13, color: C.t2, lineHeight: 1.8 }}>
                    {clause.points.map((pt, pidx) => <li key={pidx} style={{ marginBottom: 4 }}>{pt}</li>)}
                  </ul>
                )}
                {clause.address && (
                  <div style={{ marginTop: 10, padding: '12px 16px', background: C.bg, borderRadius: 4, fontSize: 13, color: C.t2, lineHeight: 1.75 }}>
                    <div>媒体名：鹿児島地域交通通信社</div>
                    <div>代表者：川畑 篤史</div>
                    <div>所在地：〒892-0816 鹿児島県鹿児島市山下町17-4 第一照国ビル ヨコチャレの事務所内</div>
                    <div>Eメールアドレス：<a href="mailto:kagoshimaregionaltransport@kagoshima-news.jp" style={{ color: C.sub }}>kagoshimaregionaltransport@kagoshima-news.jp</a></div>
                  </div>
                )}
              </div>
            ))}
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
