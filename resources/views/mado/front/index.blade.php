@extends('mado.front.template')

@section('title', 'LIXIL簡易見積りシステム')

@section('description', 'LIXIL簡易見積りシステムは、窓とドアの専門店として、住まいの内と外をつなぐリフォームを通じて、豊かで心地よい空間創りをしてまいります。')

@section('head')
    @parent

    <script src="{{ asset('/common/js/top.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/object-fit-images/3.2.3/ofi.js"></script>
@endsection

@section('main')
<!-- mainArea -->
<main id="mainArea">
    <div class="mainimg">
        <p>
            <picture>
                <source media="(max-width:767px)" srcset="{{ asset('img/main_img01_sp.jpg') }}">
                <img src="{{ asset('img/main_img01_pc.jpg') }}" width="1280" alt="「LIXIL簡易見積りシステム」は、窓・ドアの専門店として、高い技術力と豊富な知識でみなさまの健康で快適な住まい環境づくりをサポートします">
            </picture>
        </p>
        <p>
            <picture>
                <source media="(max-width:767px)" srcset="{{ asset('img/main_img02_sp.jpg') }}">
                <img src="{{ asset('img/main_img02_pc.jpg') }}" width="1280" alt="窓・ドアに関するお悩みありませんか？私たちLIXIL簡易見積りシステムにご相談ください！">
            </picture>
        </p>
        <p>
            <picture>
                <source media="(max-width:767px)" srcset="{{ asset('img/main_img03_sp.jpg') }}">
                <img src="{{ asset('img/main_img03_pc.jpg') }}" width="1280" alt="健康・快適にするポイントは実は「窓」適切に温度をコントロールすることが、省エネはもちろん、快適で健やかな毎日にも繋がっていく。「LIXIL簡易見積りシステム」は、窓・ドアの技術力と知識力を活かして、健康で快適な住環境づくりをサポートします。">
            </picture>
        </p>
    </div>

    <div class="mainInr">
        <ul class="campBnr">
            <li><a href="{{ route('front.shop.search.keyword') }}"><img src="{{ asset('common/img/bnr_camp01.jpg') }}" width="270" alt="店舗紹介　お近くの店舗を探す"></a></li>
            <li><a href="/page/health/index"><img src="{{ asset('common/img/bnr_camp06.jpg') }}" width="270" alt="健康・快適はマドから"></a></li>
            <li>
                <script src="https://mado-reform.lixil.co.jp/api/js/lixil_url.js"></script>
                <script src="https://mado-reform.lixil.co.jp/api/js/lixil_banner.js"></script>
                <script>
                document.write(
                   getBanner(7)
                );
                </script>
            </li>
        </ul>

        @include ('mado.static.lixil_emergency_message')

        <div class="flexBlock">
            <section class="estimate">
                <h2>
                    <picture class="img100">
                        <source media="(max-width:767px)" srcset="{{ asset('common/img/estimate_ttl_sp.png') }}">
                        <img src="{{ asset('common/img/estimate_ttl_pc.png') }}" width="228" alt="まずはかんたん見積りしてみよう！">
                    </picture>
                </h2>
                <ul>
                    <li>
                        <a href="{{ route('front.shop.search.modal.estimate') }}" class="shopmodal">
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('common/img/estimate_btn01_sp.png') }}">
                            <img src="{{ asset('common/img/estimate_btn01_pc.png') }}" width="240" alt="窓まわりの見積りシミュレーション">
                        </picture>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('front.shop.search.modal.estimate') }}" class="shopmodal">
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('common/img/estimate_btn02_sp.png') }}">
                            <img src="{{ asset('common/img/estimate_btn02_pc.png') }}" width="240" alt="玄関ドアの見積りシミュレーション">
                        </picture>
                        </a>
                    </li>
                </ul>
            </section>

            <ul class="replace">
                <li class="replaceBox">
                    <dl>
                        <dt>
                            <picture>
                                <source media="(max-width:767px)" srcset="{{ asset('img/replace_ttl01_sp.png') }}">
                                <img src="{{ asset('img/replace_ttl01_pc.png') }}" width="265" alt="窓の結露や騒音が気になる　内窓を簡単取付け">
                            </picture>
                        </dt>
                        <dd>
                            <div class="flexBlock">
                                <img src="{{ asset('img/replace_img01.gif') }}" width="110" alt="">
                                <picture class="time">
                                    <source media="(max-width:767px)" srcset="{{ asset('img/replace_time01_sp.png') }}">
                                    <img src="{{ asset('img/replace_time01_pc.png') }}" width="105" alt="取付時間　最短1時間～">
                                </picture>
                            </div>
                            <ul class="linkList">
                                <li><a href="https://www.youtube.com/embed/?loop=1&playlist=v93xBmxeOZg" class="youtube"><i class="fas fa-caret-right"></i> よくわかる！紹介動画</a></li>
                                <li><a href="/page/recommend/inplus"><i class="fas fa-caret-right"></i> よくわかる！商品紹介</a></li>
                            </ul>
                        </dd>
                    </dl>
                </li>
                <li class="replaceBox">
                    <dl>
                        <dt>
                            <picture>
                                <source media="(max-width:767px)" srcset="{{ asset('img/replace_ttl02_sp.png') }}">
                                <img src="{{ asset('img/replace_ttl02_pc.png') }}" width="265" alt="窓の開閉がスムーズにいかない">
                            </picture>
                        </dt>
                        <dd>
                            <div class="flexBlock">
                                <img src="{{ asset('img/replace_img02.gif') }}" width="120" alt="">
                                <picture class="time">
                                    <source media="(max-width:767px)" srcset="{{ asset('img/replace_time02_sp.png') }}">
                                    <img src="{{ asset('img/replace_time02_pc.png') }}" width="105" alt="取付時間　最短1時間～">
                                </picture>
                            </div>
                            <ul class="linkList">
                                <li><a href="https://www.youtube.com/embed/CJCpceaNAdM?loop=1&playlist=CJCpceaNAdM" class="youtube"><i class="fas fa-caret-right"></i> よくわかる！紹介動画</a></li>
                                <li><a href="/page/recommend/replus"><i class="fas fa-caret-right"></i> よくわかる！商品紹介</a></li>
                            </ul>
                        </dd>
                    </dl>
                </li>
                <li class="replaceBox _door">
                    <dl>
                        <dt>
                            <picture>
                                <source media="(max-width:767px)" srcset="{{ asset('img/replace_ttl03_sp.png') }}">
                                <img src="{{ asset('img/replace_ttl03_pc.png') }}" width="265" alt="古いドアを新しくしたい　壁を壊さず簡単玄関リフォーム">
                            </picture>
                        </dt>
                        <dd>
                            <div class="flexBlock">
                                <img src="{{ asset('img/replace_img03.gif') }}" width="110" alt="">
                                <picture class="time">
                                    <source media="(max-width:767px)" srcset="{{ asset('img/replace_time03_sp.png') }}">
                                    <img src="{{ asset('img/replace_time03_pc.png') }}" width="105" alt="取替時間　最短1日～">
                                </picture>
                            </div>
                            <ul class="linkList">
                                <li><a href="https://www.youtube.com/embed/cqCXz08ZI7g?loop=1&playlist=cqCXz08ZI7g" class="youtube"><i class="fas fa-caret-right"></i> よくわかる！<br class="sponly">紹介動画</a></li>
                                <li><a href="/page/recommend/rechent_door"><i class="fas fa-caret-right"></i> よくわかる！<br class="sponly">商品紹介</a></li>
                            </ul>
                        </dd>
                    </dl>
                </li>
            </ul>
            <p class="timenote">※現場の状況により施工に必要な時間は異なりますので、目安とお考えください。</p>
        </div>

        <div class="flexBlock _reverse" id="shop_search">
            <div class="secWrap">
                {{-- 日本地図 --}}
                @include ('mado.front.parts.japan_map')

                <section class="newsSec">
                    <div class="ttlBlock">
                        <h2>お知らせ</h2>
                        <p class="listLink"><a href="{{ route('front.news') }}"><i class="fas fa-arrow-circle-right"></i>一覧へ</a></p>
                    </div>
                    @include ('mado.static.lixil_notice')
                </section>
            </div><!--/secWrap/-->

            <nav id="sideNav">
                <ul class="sidebnr">
                    <li><a href="/page/tpoint/"><img src="{{ asset('common/img/bnr_camp03.jpg') }}" width="270" alt="窓・玄関ドアのリフォームでTポイントが貯まる！"></a></li>
                    <li><a href="https://www.lixil.co.jp/reform/mukinnri2019.pdf" target="_blank"><img src="{{ asset('common/img/bnr_camp04.jpg') }}" width="270" alt="金利0％キャンペーン"></a></li>
                    <li><a href="/page/about/diagnosis"><img src="{{ asset('common/img/sidebnr_02.jpg') }}" width="270" alt="窓診断の流れ"></a></li>
                    <!-- <li><a href="{{ route('front.shop.photo.search', [config('const.form.common.SEARCH_KEYWORDS') => '', config('const.form.common.VOICE') => config('const.form.common.CHECKED')]) }}"><img src="{{ asset('common/img/sidebnr_03.jpg') }}" width="270" alt="お客様の声"></a></li>
                    <li><a href="{{ route('front.shop.photo.search', [config('const.form.common.SEARCH_KEYWORDS') => '']) }}"><img src="{{ asset('common/img/sidebnr_04.jpg') }}" width="270" alt="全国施工事例"></a></li> -->
                    <li><a href="/page/column/index"><img src="{{ asset('common/img/sidebnr_05') }}.jpg" width="270" alt="お役立ちコラム"></a></li>
                </ul>
                <dl class="beginnerBox">
                    <dt>
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('common/img/beginner_ttl_sp.png') }}">
                            <img src="{{ asset('common/img/beginner_ttl_pc.png') }}" width="270" alt="初めての方へ">
                        </picture>
                    </dt>
                    <dd>
                        <ul>
                            <li>
                                <a href="/page/beginner/index">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('common/img/beginner_btn01_sp.png') }}">
                                    <img src="{{ asset('common/img/beginner_btn01_pc.png') }}" width="130" alt="よくわかる窓リフォーム（戸建て編）">
                                </picture>
                                </a>
                            </li>
                            <li>
                                <a href="/page/beginner/mansion">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('common/img/beginner_btn02_sp.png') }}">
                                    <img src="{{ asset('common/img/beginner_btn02_pc.png') }}" width="130" alt="よくわかる窓リフォーム（マンション編）">
                                </picture>
                                </a>
                            </li>
                            <li>
                                <a href="/page/beginner/window">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('common/img/beginner_btn03_sp.png') }}">
                                    <img src="{{ asset('common/img/beginner_btn03_pc.png') }}" width="130" alt="窓選びのポイント">
                                </picture>
                                </a>
                            </li>
                            <li>
                                <a href="/page/beginner/door">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('common/img/beginner_btn04_sp.png') }}">
                                    <img src="{{ asset('common/img/beginner_btn04_pc.png') }}" width="130" alt="ドア選びのポイント">
                                </picture>
                                </a>
                            </li>
                            <li>
                                <a href="/page/beginner/trouble">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('common/img/beginner_btn05_sp.png') }}">
                                    <img src="{{ asset('common/img/beginner_btn05_pc.png') }}" width="130" alt="ご契約は慎重に">
                                </picture>
                                </a>
                            </li>
                            <li>
                                <a href="/page/knowledge/index">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('common/img/beginner_btn06_sp.png') }}">
                                    <img src="{{ asset('common/img/beginner_btn06_pc.png') }}" width="130" alt="知って得する窓・ドアの基本知識">
                                </picture>
                                </a>
                            </li>
                        </ul>
                    </dd>
                </dl>
            </nav>
        </div><!-- /_reverse/ -->

        <section class="mainSec">
            <h2>CASE<span>&amp;</span>STUDY</h2>
            <ul class="studyList">
                <li>
                    <a href="/page/case_study/case01">
                        <figure><img src="{{ asset('img/study_img01.jpg') }}" alt="case1 内窓（二重窓）の事例写真"></figure>
                        <h3>CASE1 <span>内窓 (二重窓)</span></h3>
                        <p>インプラスで、結露対策、防音効果、さらに断熱効果で節電に。</p>
                        <p class="continue">...続きを読む</p>
                    </a>
                </li>
                <li>
                    <a href="/page/case_study/case02">
                        <figure><img src="{{ asset('img/study_img02.jpg') }}" alt="case2 窓取替えの事例写真"></figure>
                        <h3>CASE2 <span>窓取替え</span></h3>
                        <p>窓をリフォームしてから、困っていた結露が驚くほどなくなりました。</p>
                        <p class="continue">...続きを読む</p>
                    </a>
                </li>
                <li>
                    <a href="/page/case_study/case03">
                        <figure><img src="{{ asset('img/study_img03.jpg') }}" alt="case3 玄関ドアの事例写真"></figure>
                        <h3>CASE3 <span>玄関ドア</span></h3>
                        <p>これからの人生を満喫するステージにふさわしい、快適なドアになりました。</p>
                        <p class="continue">...続きを読む</p>
                    </a>
                </li>
                <li>
                    <a href="/page/case_study/case04">
                        <figure><img src="{{ asset('img/study_img04.jpg') }}" alt="case4 玄関ドアの事例写真"></figure>
                        <h3>CASE4 <span>玄関ドア</span></h3>
                        <p>家族5人プラス、猫5匹、犬1匹。にぎやかに、ウエルカムマインドいっぱい。</p>
                        <p class="continue">...続きを読む</p>
                    </a>
                </li>
                <li>
                    <a href="/page/case_study/case05">
                        <figure><img src="{{ asset('img/study_img05.jpg') }}" alt="case5 日よけの事例写真"></figure>
                        <h3>CASE5 <span>日よけ</span></h3>
                        <p>夏場の日差しをカットしながら部屋がまる見えだった悩みも解消！</p>
                        <p class="continue">...続きを読む</p>
                    </a>
                </li>
                <li>
                    <a href="/page/case_study/case06">
                        <figure><img src="{{ asset('img/study_img06.jpg') }}" alt="case6 シャッターの事例写真"></figure>
                        <h3>CASE6 <span>シャッター</span></h3>
                        <p>シャッターの開閉はタイマー操作で、快適な毎日を実感しています。</p>
                        <p class="continue">...続きを読む</p>
                    </a>
                </li>
                <li>
                    <a href="/page/case_study/case07">
                        <figure><img src="{{ asset('img/study_img07.jpg') }}" alt="case7 玄関引戸の事例写真"></figure>
                        <h3>CASE7 <span>玄関引戸</span></h3>
                        <p>風情のある和の住まいの玄関引戸。開け閉めが軽くなって快適です。</p>
                        <p class="continue">...続きを読む</p>
                    </a>
                </li>
                <li>
                    <a href="/page/case_study/case08">
                        <figure><img src="{{ asset('img/study_img08.jpg') }}" alt="case8 玄関引戸の事例写真"></figure>
                        <h3>CASE8 <span>玄関引戸</span></h3>
                        <p>ゆっくりと流れる時に、ふさわしい佇まい。住まいに溶け込んだ、新しい玄関引戸。</p>
                        <p class="continue">...続きを読む</p>
                    </a>
                </li>
                <li>
                    <a href="/page/case_study/case09">
                        <figure><img src="{{ asset('img/study_img09.jpg') }}" alt="case9 勝手口の事例写真"></figure>
                        <h3>CASE9 <span>勝手口</span></h3>
                        <p>勝手口を一緒にリフォームして、風通しの良い、明るく爽やかなキッチンに。</p>
                        <p class="continue">...続きを読む</p>
                    </a>
                </li>
            </ul>
        </section>

        @if ($photosHavingVoice->isNotEmpty())
            <section class="mainSec">
                <div class="ttlBlock">
                    <h2>全国の施工事例</h2>
                    <p class="listLink"><a href="{{ route('front.shop.photo.search', [config('const.form.common.SEARCH_KEYWORDS') => '']) }}"><i class="fas fa-arrow-circle-right"></i>施工事例をもっと見る</a></p>
                </div>
                <div class="caseWrap">
                    <ul class="caseList _sub">
                        @foreach ($photosHavingVoice as $photo)
                            <li>
                                @if ($photo instanceof \App\Models\PremiumPhoto)
                                    <a href="{{ $photo->photoUrl() }}" target="_blank">
                                        <figure><img src="{{ $photo->featuredImageUrl() }}" alt="写真"></figure>
                                        <div class="date">
                                            <p>{{ $photo->getPostedDate() }}</p>
                                            <p>{{ $photo->shop->{config('const.db.shops.NAME')} }}</p>
                                        </div>
                                        <dl>
                                            <dt>{{ $photo->{config('const.db.premium_photos.TITLE')} }}</dt>
                                            <dd class="text">{{ $photo->{config('const.db.premium_photos.SUMMARY')} }}</dd>
                                            <dd class="continue">...続きを読む</dd>
                                        </dl>
                                    </a>
                                @elseif ($photo instanceof \App\Models\StandardPhoto)
                                    <a href="{{ $photo->photoUrl() }}">
                                        <figure><img src="{{ $photo->photoMainImageUrl() }}" alt="写真"></figure>
                                        <div class="date">
                                            <p>{{ $photo->getCreatedDate() }}</p>
                                            <p>{{ $photo->shop->{config('const.db.shops.NAME')} }}</p>
                                        </div>
                                        <dl>
                                            <dt>{{ $photo->{config('const.db.standard_photos.TITLE')} }}</dt>
                                            <dd class="text">{{ $photo->{config('const.db.standard_photos.SUMMARY')} }}</dd>
                                            <dd class="continue">...続きを読む</dd>
                                        </dl>
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
                <p class="listLink sponly"><a href="{{ route('front.shop.photo.search', [config('const.form.common.SEARCH_KEYWORDS') => '']) }}"><i class="fas fa-arrow-circle-right"></i>施工事例をもっと見る</a></p>
                <p class="blankTxt"><span>このマークの事例は加盟店サイトへ遷移します</span></p>
            </section>
        @endif

        @if ($photosNotHavingVoice->isNotEmpty())
            <section class="mainSec">
                <div class="ttlBlock">
                    <h2>お客様の声</h2>
                    <p class="listLink"><a href="{{ route('front.shop.photo.search', [config('const.form.common.SEARCH_KEYWORDS') => '', config('const.form.common.VOICE') => config('const.form.common.CHECKED')]) }}"><i class="fas fa-arrow-circle-right"></i>お客様の声をもっと見る</a></p>
                </div>
                <ul class="voiceList">
                    @foreach ($photosNotHavingVoice as $photo)
                        <li>

                            @if ($photo instanceof \App\Models\PremiumPhoto)
                                <a href="{{ $photo->photoUrl() }}" target="_blank">
                                    <figure><img src="{{ $photo->featuredImageUrl() }}" alt="写真"></figure>
                                    <div class="date">{{ $photo->getPostedDate() }}</p>
                                    <dl>
                                        <dt>{{ $photo->shop->{config('const.db.shops.NAME')} }}</dt>
                                        <dd class="text">{{ $photo->{config('const.db.premium_photos.SUMMARY')} }}</dd>
                                        <dd class="continue">...続きを読む</dd>
                                    </dl>
                                </a>
                            @elseif ($photo instanceof \App\Models\StandardPhoto)
                                <a href="{{ $photo->photoUrl() }}">
                                    <figure><img src="{{ $photo->photoMainImageUrl() }}" alt="写真"></figure>
                                    <div class="date">{{ $photo->getCreatedDate() }}</p>
                                    <dl>
                                        <dt>{{ $photo->{config('const.db.standard_photos.TITLE')} }}</dt>
                                        <dd class="text">{{ $photo->{config('const.db.standard_photos.SUMMARY')} }}</dd>
                                        <dd class="continue">...続きを読む</dd>
                                    </dl>
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <p class="listLink sponly"><a href="{{ route('front.shop.photo.search', [config('const.form.common.SEARCH_KEYWORDS') => '', config('const.form.common.VOICE') => config('const.form.common.CHECKED')]) }}"><i class="fas fa-arrow-circle-right"></i>お客様の声をもっと見る</a></p>
                <p class="blankTxt"><span>このマークのお客様の声は加盟店サイトへ遷移します</span></p>
            </section>
        @endif

        @if ($articleBlogs->isNotEmpty())
            <section class="mainSec _blog">
                <div class="ttlBlock">
                    <h2>現場ブログ</h2>
                    <p class="listLink"><a href="{{ route('front.shop.blog') }}"><i class="fas fa-arrow-circle-right"></i>現場ブログをもっと見る</a></p>
                </div>
                <ul class="voiceList">
                    @foreach ($articleBlogs as $articleBlog)
                        <li>
                            @if ($articleBlog instanceof \App\Models\PremiumArticle)
                                <a href="{{ $articleBlog->{config('const.db.premium_articles.WP_ARTICLE_URL')} }}" target="_blank">
                                    <figure><img src="{{ $articleBlog->featuredImageUrl() }}" alt="写真"></figure>
                                    <div class="date">
                                        <p>{{ $articleBlog->getPostedDate() }}</p>
                                        <p>{{ $articleBlog->shop->{config('const.db.shops.NAME')} }}</p>
                                    </div>
                                    <dl>
                                        <dt>{{ $articleBlog->{config('const.db.standard_articles.TITLE')} }}</dt>
                                        <dd class="text">{{ $articleBlog->{config('const.db.standard_articles.SUMMARY')} }}</dd>
                                        <dd class="continue">...続きを読む</dd>
                                    </dl>
                                </a>
                            @elseif ($articleBlog instanceof \App\Models\StandardArticle)
                                <a href="{{ route('front.shop.standard.blog.detail', [
                                    'pref_code' => $articleBlog->shop->pref->{config('const.db.prefs.CODE')},
                                    'shop_code' => $articleBlog->shop->{config('const.db.shops.SHOP_CODE')},
                                    'article_id' => $articleBlog->{config('const.db.standard_articles.ID')}
                                    ]) }}">
                                    <figure><img src="{{ $articleBlog->articleMainImageUrl('s') }}" alt="写真"></figure>
                                    <div class="date">
                                        <p>{{ $articleBlog->getPublishedDate() }}</p>
                                        <p>{{ $articleBlog->shop->{config('const.db.shops.NAME')} }}</p>
                                    </div>
                                    <dl>
                                        <dt>{{ $articleBlog->{config('const.db.standard_articles.TITLE')} }}</dt>
                                        <dd class="text">{{ $articleBlog->{config('const.db.standard_articles.SUMMARY')} }}</dd>
                                        <dd class="continue">...続きを読む</dd>
                                    </dl>
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <p class="listLink sponly"><a href="{{ route('front.shop.blog') }}"><i class="fas fa-arrow-circle-right"></i>現場ブログをもっと見る</a></p>
                <p class="blankTxt"><span>このマークの現場ブログは加盟店サイトへ遷移します</span></p>
            </section>
        @endif

        @if ($articleEvents->isNotEmpty())
            <section class="mainSec _event">
                <div class="ttlBlock">
                    <h2>イベント・キャンペーン</h2>
                    <p class="listLink"><a href="{{ route('front.shop.event') }}"><i class="fas fa-arrow-circle-right"></i>イベント・キャンペーンをもっと見る</a></p>
                </div>
                <ul class="voiceList">
                    @foreach ($articleEvents as $articleEvent)
                        <li>
                            @if ($articleEvent instanceof \App\Models\PremiumArticle)
                                <a href="{{ $articleEvent->{config('const.db.premium_articles.WP_ARTICLE_URL')} }}" target="_blank">
                                    <figure><img src="{{ $articleEvent->featuredImageUrl() }}" alt="写真"></figure>
                                    <div class="date">
                                        <p>{{ $articleEvent->getPostedDate() }}</p>
                                        <p>{{ $articleEvent->shop->{config('const.db.shops.NAME')} }}</p>
                                    </div>
                                    <dl>
                                        <dt>{{ $articleEvent->{config('const.db.standard_articles.TITLE')} }}</dt>
                                        <dd class="text">{{ $articleEvent->{config('const.db.standard_articles.SUMMARY')} }}</dd>
                                        <dd class="continue">...続きを読む</dd>
                                    </dl>
                                </a>
                            @elseif ($articleEvent instanceof \App\Models\StandardArticle)
                                <a href="{{ route('front.shop.standard.event.detail', [
                                    'pref_code' => $articleEvent->shop->pref->{config('const.db.prefs.CODE')},
                                    'shop_code' => $articleEvent->shop->{config('const.db.shops.SHOP_CODE')},
                                    'article_id' => $articleEvent->{config('const.db.standard_articles.ID')}
                                    ]) }}">
                                    <figure><img src="{{ $articleEvent->articleMainImageUrl('s') }}" alt="写真"></figure>
                                    <div class="date">
                                        <p>{{ $articleEvent->getPublishedDate() }}</p>
                                        <p>{{ $articleEvent->shop->{config('const.db.shops.NAME')} }}</p>
                                    </div>
                                    <dl>
                                        <dt>{{ $articleEvent->{config('const.db.standard_articles.TITLE')} }}</dt>
                                        <dd class="text">{{ $articleEvent->{config('const.db.standard_articles.SUMMARY')} }}</dd>
                                        <dd class="continue">...続きを読む</dd>
                                    </dl>
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <p class="listLink sponly"><a href="{{ route('front.shop.event') }}"><i class="fas fa-arrow-circle-right"></i>イベント・キャンペーンをもっと見る</a></p>
                <p class="blankTxt"><span>このマークのイベント・キャンペーンは加盟店サイトへ遷移します</span></p>
            </section>
        @endif
    </div>
    <!-- /mainInr/ -->

    <section class="consultSec">
        <h2>私たちLIXIL簡易見積りシステムに<br class="sponly">ご相談ください</h2>
        <ul class="consultList">
            <li>
                <a href="/page/problem/mado01">
                    <picture>
                        <source media="(max-width:767px)" srcset="{{ asset('img/consult_list01_sp.png') }}">
                        <img src="{{ asset('img/consult_list01_pc.png') }}" width="170" alt="窓　西日で部屋が暑く、まぶしい">
                    </picture>
                </a>
            </li>
            <li>
                <a href="/page/problem/mado02">
                    <picture>
                        <source media="(max-width:767px)" srcset="{{ asset('img/consult_list02_sp.png') }}">
                        <img src="{{ asset('img/consult_list02_pc.png') }}" width="170" alt="窓　結露がひどい">
                    </picture>
                </a>
            </li>
            <li>
                <a href="/page/problem/mado03">
                    <picture>
                        <source media="(max-width:767px)" srcset="{{ asset('img/consult_list03_sp.png') }}">
                        <img src="{{ asset('img/consult_list03_pc.png') }}" width="170" alt="窓　開閉しづらい">
                    </picture>
                </a>
            </li>
            <li>
                <a href="/page/problem/mado04">
                    <picture>
                        <source media="(max-width:767px)" srcset="{{ asset('img/consult_list04_sp.png') }}">
                        <img src="{{ asset('img/consult_list04_pc.png') }}" width="170" alt="窓　窓の隙間風">
                    </picture>
                </a>
            </li>
            <li>
                <a href="/page/problem/mado05">
                    <picture>
                        <source media="(max-width:767px)" srcset="{{ asset('img/consult_list05_sp.png') }}">
                        <img src="{{ asset('img/consult_list05_pc.png') }}" width="170" alt="窓　防犯が気になる">
                    </picture>
                </a>
            </li>
            <li>
                <a href="/page/problem/mado06">
                    <picture>
                        <source media="(max-width:767px)" srcset="{{ asset('img/consult_list06_sp.png') }}">
                        <img src="{{ asset('img/consult_list06_pc.png') }}" width="170" alt="窓　外の音がうるさい">
                    </picture>
                </a>
            </li>
            <li>
                <a href="/page/problem/mado07">
                    <picture>
                        <source media="(max-width:767px)" srcset="{{ asset('img/consult_list07_sp.png') }}">
                        <img src="{{ asset('img/consult_list07_pc.png') }}" width="170" alt="窓　風通しが悪い">
                    </picture>
                </a>
            </li>
            <li>
                <a href="/page/problem/mado08">
                    <picture>
                        <source media="(max-width:767px)" srcset="{{ asset('img/consult_list08_sp.png') }}">
                        <img src="{{ asset('img/consult_list08_pc.png') }}" width="170" alt="窓　部屋が暗い">
                    </picture>
                </a>
            </li>
            <li>
                <a href="/page/problem/door01">
                    <picture>
                        <source media="(max-width:767px)" srcset="{{ asset('img/consult_list09_sp.png') }}">
                        <img src="{{ asset('img/consult_list09_pc.png') }}" width="170" alt="ドア　開戸に交換したい">
                    </picture>
                </a>
            </li>
            <li>
                <a href="/page/problem/door02">
                    <picture>
                        <source media="(max-width:767px)" srcset="{{ asset('img/consult_list10_sp.png') }}">
                        <img src="{{ asset('img/consult_list10_pc.png') }}" width="170" alt="ドア　引戸に交換したい">
                    </picture>
                </a>
            </li>
            <li>
                <a href="/page/problem/door03">
                    <picture>
                        <source media="(max-width:767px)" srcset="{{ asset('img/consult_list11_sp.png') }}">
                        <img src="{{ asset('img/consult_list11_pc.png') }}" width="170" alt="ドア　防犯が気になる">
                    </picture>
                </a>
            </li>
            <li>
                <a href="/page/problem/door04">
                    <picture>
                        <source media="(max-width:767px)" srcset="{{ asset('img/consult_list12_sp.png') }}">
                        <img src="{{ asset('img/consult_list12_pc.png') }}" width="170" alt="ドア　風通しが悪い">
                    </picture>
                </a>
            </li>
        </ul>
    </section>

    <div class="mainInr">
        <section class="mainSec">
            <h2>おすすめ簡単リフォーム商品</h2>
            <ul class="recomList">
                <li>
                    <a href="/page/recommend/inplus">
                        <p class="label">内窓（二重窓）</p>
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_img01_sp.jpg') }}">
                            <img src="{{ asset('/page_image/common/recom_img01_pc.jpg') }}" width="235" alt="インプラス/インプラスウッドのイメージ画像">
                        </picture>
                        <dl>
                            <dt>インプラス/インプラスウッド</dt>
                            <dd class="text">今ある窓に“プラス”するだけで、<br class="pconly">パッと快適に</dd>
                            <dd class="icon">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_icon01_sp.png') }}">
                                    <img src="{{ asset('/page_image/common/recom_icon01_pc.png') }}" width="234" alt="寒さ対策　結露　暑さ対策　紫外線　防犯　快適　防音　デザイン">
                                </picture>
                            </dd>
                        </dl>
                    </a>
                </li>
                <li>
                    <a href="/page/recommend/replus">
                        <p class="label">窓取替え</p>
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_img02_sp.jpg') }}">
                            <img src="{{ asset('/page_image/common/recom_img02_pc.jpg') }}" width="235" alt="リプラスのイメージ画像">
                        </picture>
                        <dl>
                            <dt>リプラス</dt>
                            <dd class="text">古い窓がたった半日で<br class="pconly">開閉スムーズ・快適な窓に</dd>
                            <dd class="icon">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_icon02_sp.png') }}">
                                    <img src="{{ asset('/page_image/common/recom_icon02_pc.png') }}" width="234" alt="寒さ対策　結露　暑さ対策　紫外線　快適　デザイン">
                                </picture>
                            </dd>
                        </dl>
                    </a>
                </li>
                <li>
                    <a href="/page/recommend/replus_bath">
                        <p class="label">窓取替え</p>
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_img03_sp.jpg') }}">
                            <img src="{{ asset('/page_image/common/recom_img03_pc.jpg') }}" width="235" alt="リプラス カバーモール浴室用のイメージ画像">
                        </picture>
                        <dl>
                            <dt>リプラス カバーモール浴室用</dt>
                            <dd class="text">断熱効果でお風呂の寒さ＆<br>すきま風解消</dd>
                            <dd class="icon">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_icon03_sp.png') }}">
                                    <img src="{{ asset('/page_image/common/recom_icon03_pc.png') }}" width="234" alt="寒さ対策　採風　防犯　快適　デザイン">
                                </picture>
                            </dd>
                        </dl>
                    </a>
                </li>
                <li>
                    <a href="/page/recommend/rechent_door">
                        <p class="label">玄関</p>
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_img04_sp.jpg') }}">
                            <img src="{{ asset('/page_image/common/recom_img04_pc.jpg') }}" width="235" alt="リシェント玄関ドアのイメージ画像">
                        </picture>
                        <dl>
                            <dt>リシェント玄関ドア</dt>
                            <dd class="text">古い玄関も壁を壊さず<br>たった1日でリフォーム完了</dd>
                            <dd class="icon">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_icon04_sp.png') }}">
                                    <img src="{{ asset('/page_image/common/recom_icon04_pc.png') }}" width="234" alt="寒さ対策　暑さ対策　紫外線　採光　採風　防犯　快適　デザイン">
                                </picture>
                            </dd>
                        </dl>
                    </a>
                </li>
                <li>
                    <a href="/page/recommend/rechent_slide">
                        <p class="label">玄関</p>
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_img05_sp.jpg') }}">
                            <img src="{{ asset('/page_image/common/recom_img05_pc.jpg') }}" width="235" alt="リシェント玄関引戸のイメージ画像">
                        </picture>
                        <dl>
                            <dt>リシェント玄関引戸</dt>
                            <dd class="text">古い玄関も壁を壊さず<br>たった1日でリフォーム完了</dd>
                            <dd class="icon">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_icon05_sp.png') }}">
                                    <img src="{{ asset('/page_image/common/recom_icon05_pc.png') }}" width="234" alt="寒さ対策　暑さ対策　採光　防犯　快適　デザイン">
                                </picture>
                            </dd>
                        </dl>
                    </a>
                </li>
                <li>
                    <a href="/page/recommend/rechent_multi">
                        <p class="label">勝手口</p>
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_img06_sp.jpg') }}">
                            <img src="{{ asset('/page_image/common/recom_img06_pc.jpg') }}" width="235" alt="リシェント勝手口ドアのイメージ画像">
                        </picture>
                        <dl>
                            <dt>リシェント勝手口ドア</dt>
                            <dd class="text">暗くて寒い勝手口も<br>1日で明るくさわやかに</dd>
                            <dd class="icon">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_icon06_sp.png') }}">
                                    <img src="{{ asset('/page_image/common/recom_icon06_pc.png') }}" width="234" alt="寒さ対策　結露　暑さ対策　採光　採風　防犯　快適　デザイン">
                                </picture>
                            </dd>
                        </dl>
                    </a>
                </li>
                <li>
                    <a href="/page/recommend/styleshade">
                        <p class="label">日よけ</p>
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_img08_sp.jpg') }}">
                            <img src="{{ asset('/page_image/common/recom_img08_pc.jpg') }}" width="235" alt="スタイルシェードのイメージ画像">
                        </picture>
                        <dl>
                            <dt>スタイルシェード</dt>
                            <dd class="text">日差しや紫外線をカットし、<br>冷房効率アップ。</dd>
                            <dd class="icon">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_icon08_sp.png') }}">
                                    <img src="{{ asset('/page_image/common/recom_icon08_pc.png') }}" width="234" alt="暑さ対策　紫外線　採風　快適　デザイン">
                                </picture>
                            </dd>
                        </dl>
                    </a>
                </li>
                <li>
                    <a href="/page/recommend/awning">
                        <p class="label">日よけ</p>
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_img09_sp.jpg') }}">
                            <img src="{{ asset('/page_image/common/recom_img09_pc.jpg') }}" width="235" alt="オーニングのイメージ画像">
                        </picture>
                        <dl>
                            <dt>オーニング</dt>
                            <dd class="text">日差しや紫外線をカットし、<br>室内の温度上昇を抑えます。</dd>
                            <dd class="icon">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_icon09_sp.png') }}">
                                    <img src="{{ asset('/page_image/common/recom_icon09_pc.png') }}" width="234" alt="暑さ対策　紫外線　快適　デザイン">
                                </picture>
                            </dd>
                        </dl>
                    </a>
                </li>
                <li>
                    <a href="/page/recommend/shutter">
                        <p class="label">シャッター</p>
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_img07_sp.jpg') }}">
                            <img src="{{ asset('/page_image/common/recom_img07_pc.jpg') }}" width="235" alt="リフォームシャッターのイメージ画像">
                        </picture>
                        <dl>
                            <dt>リフォームシャッター</dt>
                            <dd class="text">今ある窓に後付けできる<br>安心・快適シャッター</dd>
                            <dd class="icon">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_icon07_sp.png') }}">
                                    <img src="{{ asset('/page_image/common/recom_icon07_pc.png') }}" width="234" alt="紫外線　採光　採風　防犯　快適　防音">
                                </picture>
                            </dd>
                        </dl>
                    </a>
                </li>
                <li>
                    <a href="/page/recommend/louver">
                        <p class="label">雨戸</p>
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_img10_sp.jpg') }}">
                            <img src="{{ asset('/page_image/common/recom_img10_pc.jpg') }}" width="235" alt="雨戸リフォームのイメージ画像">
                        </picture>
                        <dl>
                            <dt>雨戸リフォーム</dt>
                            <dd class="text">採風タイプなら雨戸を閉めたまま風も光も取込める</dd>
                            <dd class="icon">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_icon10_sp.png') }}">
                                    <img src="{{ asset('/page_image/common/recom_icon10_pc.png') }}" width="234" alt="暑さ対策　紫外線　採光　採風　防犯　快適　デザイン">
                                </picture>
                            </dd>
                        </dl>
                    </a>
                </li>
                <li>
                    <a href="/page/recommend/area_grid">
                        <p class="label">面格子</p>
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_img11_sp.jpg') }}">
                            <img src="{{ asset('/page_image/common/recom_img11_pc.jpg') }}" width="235" alt="面格子のイメージ画像">
                        </picture>
                        <dl>
                            <dt>面格子</dt>
                            <dd class="text">採光性を確保しながら外からの<br class="pconly">視線をしっかり目隠し</dd>
                            <dd class="icon">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_icon11_sp.png') }}">
                                    <img src="{{ asset('/page_image/common/recom_icon11_pc.png') }}" width="234" alt="暑さ対策　紫外線　採光　採風　防犯　快適　デザイン">
                                </picture>
                            </dd>
                        </dl>
                    </a>
                </li>
                <li>
                    <a href="/page/recommend/screen_door">
                        <p class="label">網戸</p>
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_img12_sp.jpg') }}">
                            <img src="{{ asset('/page_image/common/recom_img12_pc.jpg') }}" width="235" alt="網戸のイメージ画像">
                        </picture>
                        <dl>
                            <dt>網戸</dt>
                            <dd class="text">汚れた網戸も、機能的な網戸に<br class="pconly">簡単に取替え。</dd>
                            <!--dd class="icon">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_icon13_sp.png') }}">
                                    <img src="{{ asset('/page_image/common/recom_icon13_pc.png') }}" width="234" alt="アイコン">
                                </picture>
                            </dd-->
                        </dl>
                    </a>
                </li>
                <li>
                    <a href="/page/recommend/exterior01">
                        <p class="label">エクステリア</p>
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_img13_sp.jpg') }}">
                            <img src="{{ asset('/page_image/common/recom_img13_pc.jpg') }}" width="235" alt="宅配ボックスのイメージ画像">
                        </picture>
                        <dl>
                            <dt>宅配ボックス</dt>
                            <dd class="text">留守中でも宅配荷物を<br>受け取れる宅配ボックス</dd>
                            <!--dd class="icon">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_icon13_sp.png') }}">
                                    <img src="{{ asset('/page_image/common/recom_icon13_pc.png') }}" width="234" alt="アイコン">
                                </picture>
                            </dd-->
                        </dl>
                    </a>
                </li>
                <li>
                    <a href="/page/recommend/exterior02">
                        <p class="label">エクステリア</p>
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_img14_sp.jpg') }}">
                            <img src="{{ asset('/page_image/common/recom_img14_pc.jpg') }}" width="235" alt="ウッドデッキ（樹ら楽ステージ）のイメージ画像">
                        </picture>
                        <dl>
                            <dt>ウッドデッキ（樹ら楽ステージ）</dt>
                            <dd class="text">リビングとお庭を有効活用<br>憧れのガーデンライフを</dd>
                            <!--dd class="icon">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_icon13_sp.png') }}">
                                    <img src="{{ asset('/page_image/common/recom_icon13_pc.png') }}" width="234" alt="アイコン">
                                </picture>
                            </dd-->
                        </dl>
                    </a>
                </li>
                <li>
                    <a href="/page/recommend/exterior03">
                        <p class="label">エクステリア</p>
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_img15_sp.jpg') }}">
                            <img src="{{ asset('/page_image/common/recom_img15_pc.jpg') }}" width="235" alt="テラス屋根のイメージ画像">
                        </picture>
                        <dl>
                            <dt>テラス屋根</dt>
                            <dd class="text">後付けテラス屋根で<br>強い日差しや急な雨も安心</dd>
                            <dd class="icon">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_icon15_sp.png') }}">
                                    <img src="{{ asset('/page_image/common/recom_icon15_pc.png') }}" width="234" alt="暑さ対策　紫外線　採光　快適　デザイン">
                                </picture>
                            </dd>
                        </dl>
                    </a>
                </li>
                <li>
                    <a href="/page/recommend/interior01">
                        <p class="label">インテリア</p>
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_img17_sp.jpg') }}">
                            <img src="{{ asset('/page_image/common/recom_img17_pc.jpg') }}" width="235" alt="オーダーカーテンのイメージ画像">
                        </picture>
                        <dl>
                            <dt>オーダーカーテン</dt>
                            <dd class="text">デザイン性、機能性に優れた<br>高品質なオーダーカーテン</dd>
                            <dd class="icon">
                                <picture>
                                    <source media="(max-width:767px)" srcset="{{ asset('/page_image/common/recom_icon17_sp.png') }}">
                                    <img src="{{ asset('/page_image/common/recom_icon17_pc.png') }}" width="234" alt="暑さ対策　紫外線　採光　防犯　デザイン">
                                </picture>
                            </dd>
                        </dl>
                    </a>
                </li>
            </ul>
        </section>
    </div>
    <!-- /mainInr/ -->

    <script>objectFitImages();</script>
</main>
@endsection

@section('script')
    @parent

    <script src="{{asset('js/app.js')}}" ></script>
    <script>
        $(document).ready(function(){
                $(".mainimg").owlCarousel({
                autoplay: true,
                autoplayTimeout: 5000,
                autoplaySpeed: 1000,
                items: 1,
                loop: true,
                mouseDrag: false,
                nav:true,
                dots:true,
                navText:["",""]
            });
        });
    </script>
@endsection
