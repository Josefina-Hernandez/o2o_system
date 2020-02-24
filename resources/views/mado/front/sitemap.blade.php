@extends('mado.front.shop.standard.template')

@section('title', 'サイトマップ｜LIXIL簡易見積りシステム')

@section('description', 'LIXIL簡易見積りシステムサイトのサイトマップです。LIXIL簡易見積りシステムは、窓とドアの専門店として、住まいの内と外をつなぐリフォームを通じて、豊かで心地よい空間創りをしてまいります。')

@section('frontcss')
    <link rel="stylesheet" href="{{ asset('css/sitemap.css') }}">
@endsection

@section('main')
<main id="mainArea" class="sitemap">
    <article>
        @include ('mado.front.parts.breadcrumbs')

        <h1>サイトマップ</h1>
        <div class="wrap">
            <section>
                <h2><span><a href="/page/about/index">「LIXIL簡易見積りシステム」とは <i class="fas fa-angle-right"></i></a></span></h2>
                <ul>
                    <li><a href="/page/about/service">ここがちがうLIXIL簡易見積りシステムのサービスの流れ</a></li>
                    <li><a href="/page/about/zero">不安0宣言</a></li>
                    <li><a href="/page/about/meister">マイスター制度</a></li>
                    <!--li><a href="/page/about/calender">住まいのメンテナンスカレンダー</a></li-->
                    <li><a href="/page/about/diagnosis">窓診断の流れ</a></li>
                </ul>
            </section>
            <section>
                <h2><span>初めての方へ</span></h2>
                <ul>
                    <li><a href="/page/beginner/index">よくわかる窓リフォーム（戸建て編）</a></li>
                    <li><a href="/page/beginner/mansion">よくわかる窓リフォーム（マンション編）</a></li>
                    <li><a href="/page/beginner/window">窓選びのポイント</a></li>
                    <li><a href="/page/beginner/door">ドア選びのポイント</a></li>
                    <li><a href="/page/beginner/trouble">ご契約は慎重に</a></li>
                </ul>
            </section>
            <section>
                <h2><span><a href="/page/problem/index">お悩み改善提案 <i class="fas fa-angle-right"></i></a></span></h2>
                <ul>
                    <li><a href="/page/problem/mado01">西日で部屋が暑く、まぶしい</a></li>
                    <li><a href="/page/problem/mado02">結露がひどい</a></li>
                    <li><a href="/page/problem/mado03">開閉しづらい</a></li>
                    <li><a href="/page/problem/mado04">窓の隙間風</a></li>
                    <li><a href="/page/problem/mado05">防犯が気になる</a></li>
                    <li><a href="/page/problem/mado06">外の音がうるさい</a></li>
                    <li><a href="/page/problem/mado07">風通しが悪い</a></li>
                    <li><a href="/page/problem/mado08">部屋が暗い</a></li>
                    <li><a href="/page/problem/door01">開戸に交換したい</a></li>
                    <li><a href="/page/problem/door02">引戸に交換したい</a></li>
                    <li><a href="/page/problem/door03">防犯が気になる</a></li>
                    <li><a href="/page/problem/door04">風通しが悪い</a></li>
                </ul>
            </section>
            <section>
                <h2><span><a href="/page/column/index">お役立ちコラム <i class="fas fa-angle-right"></i></a></span></h2>
                <ul>
                    <li><a href="/page/column/hot01">エアコンが効きづらい部屋は光熱費を無駄にしています</a></li>
                    <li><a href="/page/column/hot02">すだれやカーテンで部屋が暗い</a></li>
                    <li><a href="/page/column/hot03">玄関や部屋がムシムシ＆じめじめ 熱がこもる原因は？</a></li>
                    <li><a href="/page/column/hot04">室内でも起こる熱中症の危険性</a></li>
                    <li><a href="/page/column/cold03">冬の寒さによる健康への悪影響、ちゃんと認識していますか？</a></li>
                    <li><a href="/page/column/security01">泥棒に狙われやすい住宅への侵入経路第1位は「窓」</a></li>
                    <li><a href="/page/column/noise02">電車や車、ペットの鳴き声 日常にあふれる騒音はいつの間にかストレスに</a></li>
                    <li><a href="/page/column/storm01">最近の台風や大雨の住まいへの影響が心配</a></li>
                    <li><a href="/page/column/light01">暗くなりがちな玄関や勝手口を明るくするには</a></li>
                    <li><a href="/page/column/comfort01">開閉がしづらい窓や玄関ドア シャッターの動きをスムーズにするには</a></li>
                </ul>
            </section>
            <section>
                <h2><span>知って得する窓・ドアの基本知識</span></h2>
                <ul>
                    <li><a href="/page/knowledge/index">窓工事（窓交換）</a></li>
                    <li><a href="/page/knowledge/innerwindow">窓工事（内窓取付）</a></li>
                    <li><a href="/page/knowledge/shutter">窓工事（シャッター・シェード）</a></li>
                    <li><a href="/page/knowledge/door">ドア工事（玄関ドア）</a></li>
                </ul>
            </section>
            <section>
                <h2><span><a href="/page/recommend/index">おすすめ簡単リフォーム商品 <i class="fas fa-angle-right"></i></a></span></h2>
                <ul>
                    <li><a href="/page/recommend/inplus">インプラス・インプラスウッド</a></li>
                    <li><a href="/page/recommend/replus">リプラス</a></li>
                    <li><a href="/page/recommend/replus_bath">リプラス カバーモール浴室用</a></li>
                    <li><a href="/page/recommend/rechent_door">リシェント玄関ドア</a></li>
                    <li><a href="/page/recommend/rechent_slide">リシェント玄関引戸</a></li>
                    <li><a href="/page/recommend/rechent_multi">リシェント勝手口ドア</a></li>
                    <li><a href="/page/recommend/shutter">リフォームシャッター</a></li>
                    <li><a href="/page/recommend/styleshade">スタイルシェード</a></li>
                    <li><a href="/page/recommend/awning">オーニング</a></li>
                    <li><a href="/page/recommend/louver">可動ルーバー雨戸</a></li>
                    <li><a href="/page/recommend/area_grid">面格子</a></li>
                    <li><a href="/page/recommend/screen_door">網戸</a></li>
                    <li><a href="/page/recommend/exterior01">宅配ボックス</a></li>
                    <li><a href="/page/recommend/exterior02">ウッドデッキ（樹ら楽ステージ）</a></li>
                    <li><a href="/page/recommend/exterior03">テラス屋根</a></li>
                </ul>
            </section>
            <section>
                <h2><span><a href="/page/health/index">健康・快適は窓から <i class="fas fa-angle-right"></i></a></span></h2>
                <ul>
                    <li><a href="/page/health/why">どうして窓が大事なの？</a></li>
                    <li><a href="/page/health/risk1">データで見る健康リスク1　血圧</a></li>
                    <li><a href="/page/health/risk2">データで見る健康リスク2　夜間頻尿</a></li>
                    <li><a href="/page/health/risk3">データで見る健康リスク3　コレステロール</a></li>
                    <li><a href="/page/health/risk4">データで見る健康リスク4　室内活動</a></li>
                    <li><a href="/page/health/demonstrate">どれくらい変わるの？実証：Kさま邸</a></li>
                </ul>
            </section>
            <section>
                <h2><span><a href="/page/case_study/index">CASE&STUDY <i class="fas fa-angle-right"></i></a></span></h2>
                <ul>
                    <li><a href="/page/case_study/case01">case1 インプラス</a></li>
                    <li><a href="/page/case_study/case02">case2 リプラス</a></li>
                    <li><a href="/page/case_study/case03">case3 リシェント玄関ドア</a></li>
                </ul>
            </section>
            <section>
                <h2><span><a href="/page/housingpoint">次世代住宅ポイント制度 <i class="fas fa-angle-right"></i></a></span></h2>
            </section>
            <section>
                <h2><span><a href="/page/tpoint">お得なTポイントが貯まります <i class="fas fa-angle-right"></i></a></span></h2>
            </section>
            <section>
                <h2><span><a href="{{ route('front.shop.photo') }}">全国の施工事例 <i class="fas fa-angle-right"></i></a></span></h2>
            </section>
            <section>
                <h2><span><a href="{{ route('front.news') }}">LIXILからのお知らせ <i class="fas fa-angle-right"></i></a></span></h2>
            </section>
            <section>
                {{-- //@TODO: 20190424: 一時的に非表示にする --}}
                {{-- <h2><span><a href="{{ route('front.contact') }}">お問い合わせ <i class="fas fa-angle-right"></i></a></span></h2> --}}
            </section>
        </div>
    </article>
</main>
@endsection
