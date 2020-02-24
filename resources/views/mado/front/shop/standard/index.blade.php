@extends('mado.front.shop.standard.template')

@section('title', "{$shop->{config('const.db.shops.NAME')}}｜LIXIL簡易見積りシステム")

@section('description', "LIXIL簡易見積りシステムサービス加盟店「{$shop->{config('const.db.shops.NAME')}}」の詳細情報です。")

@section('frontcss')
    @parent
    <link rel="stylesheet" href="{{ asset('/common/css/owl.carousel.css') }}">
@endsection

@section('head')
    @parent
<script src="//cdnjs.cloudflare.com/ajax/libs/object-fit-images/3.2.3/ofi.js"></script>
@endsection

@section('main')
<main id="mainArea" class="top">
    @include('mado.front.shop.standard.parts.header')

    <article>
        @include ('mado.front.parts.breadcrumbs')
        @include ('mado.static.lixil_emergency_message')
        @isset ($emergencyMessageText)
            <aside class="msgBox">
                <p>{{ $emergencyMessageText }}</p>
            </aside>
        @endisset

        <div class="shopInfo">
            <section class="shopMsgSec">
                @isset ($shop->{config('const.db.shops.MESSAGE')})
                    <h2><i class="fas fa-comment-dots"></i>店舗からのメッセージ</h2>
                    <p>{!! nl2br($shop->{config('const.db.shops.MESSAGE')}, false) !!}</p>
                @endisset
                @isset ($shop->{config('const.db.shops.PHOTO_SUMMARY')})
                    <h3>施工事例</h3>
                    <p>{!! nl2br($shop->{config('const.db.shops.PHOTO_SUMMARY')}, false) !!}</p>
                @endisset
                <dl class="consultBox">
                    <dt>私たちLIXIL簡易見積りシステムにご相談ください</dt>
                    <dd>
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('img/shop_consult_img_sp.jpg') }}" alt="私たちLIXIL簡易見積りシステムにご相談ください">
                            <img src="{{ asset('img/shop_consult_img_pc.jpg') }}" width="492" alt="私たちLIXIL簡易見積りシステムにご相談ください">
                        </picture>
                        <p>お問い合わせ・ご相談・お見積り等、無料で承ります。</p>
                    </dd>
                </dl>
            </section>
            <div class="shopImgSec">
                <figure class="shopImg"><img src="{{ app()->make('image_get')->shopMainUrl($shop->{config('const.db.shops.ID')}, 's') }}" alt="{{ $shop->{config('const.db.shops.NAME')} }}の写真"></figure>

                @if ($shop->{config('const.db.shops.CAN_SIMULATE')} == config('const.common.ENABLE'))
                    <dl class="estimate">
                        <dt>
                            <picture>
                                <source media="(max-width:767px)" srcset="{{ asset('img/shop_estimate_txt_sp.png') }}">
                                <img src="{{ asset('img/shop_estimate_txt_pc.png') }}" width="410" alt="まずはかんたん見積りしてみよう！">
                            </picture>
                        </dt>
                        <dd>
                            <p>
                                <a href="/shop/{{ app()->request->route('pref_code') }}/{{ app()->request->route('shop_code') }}/window/step1" target="__blank">
                                    <picture>
                                        <source media="(max-width:767px)" srcset="{{ asset('img/shop_window_btn_sp.png') }}">
                                        <img src="{{ asset('img/shop_window_btn_pc.png') }}" width="260" alt="窓まわりの見積りシミュレーション">
                                    </picture>
                                </a>
                            </p>
                            <p>
                                <a href="/shop/{{ app()->request->route('pref_code') }}/{{ app()->request->route('shop_code') }}/door/step1" target="__blank">
                                    <picture>
                                        <source media="(max-width:767px)" srcset="{{ asset('img/shop_door_btn_sp.png') }}">
                                        <img src="{{ asset('img/shop_door_btn_pc.png') }}" width="260" alt="玄関ドアの見積りシミュレーション">
                                    </picture>
                                </a>
                            </p>
                        </dd>
                    </dl>
                @endif
            </div>
        </div>

        @include ('mado.front.shop.standard.parts.shop_guide')

        @if ($standardPhotos->isNotEmpty())
            <section class="caseSec">
                <div class="ttlBlock">
                    <h2>施工事例</h2>
                    <p class="listLink"><a href="{{ route('front.shop.standard.photo', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}"><i class="fas fa-arrow-circle-right"></i>施工事例をもっと見る</a></p>
                </div>
                <div class="caseWrap">
                    <ul class="caseList">
                        @foreach ($standardPhotos as $standardPhoto)
                            <li>
                                <a href="{{ route('front.shop.standard.photo.detail', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code'), 'photo_id' => $standardPhoto->{config('const.db.standard_photos.ID')}]) }}">
                                    <figure><img src="{{ app()->make('image_get')->standardPhotoMainUrl($standardPhoto->{config('const.db.standard_photos.ID')}, 's') }}" alt="施工事例の写真"></figure>
                                    <p class="date">{{ $standardPhoto->getCreatedDate() }}</p>
                                    <dl>
                                        <dt>{{ $standardPhoto->{config('const.db.standard_photos.TITLE')} }}</dt>
                                        <dd class="text">{{ $standardPhoto->{config('const.db.standard_photos.SUMMARY')} }}</dd>
                                        <dd class="continue">...続きを読む</dd>
                                    </dl>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <p class="listLink sponly"><a href="{{ route('front.shop.standard.photo', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}"><i class="fas fa-arrow-circle-right"></i>施工事例をもっと見る</a></p>
            </section>
        @endif

        @if ($standardArticleBlogs->isNotEmpty())
            <section class="caseSec _blog">
                <div class="ttlBlock">
                    <h2>現場ブログ</h2>
                    <p class="listLink"><a href="{{ route('front.shop.standard.blog', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}"><i class="fas fa-arrow-circle-right"></i>現場ブログをもっと見る</a></p>
                </div>
                <div class="caseWrap">
                    <ul class="caseList">
                        @foreach ($standardArticleBlogs as $standardArticleBlog)
                            <li>
                                <a href="{{ route('front.shop.standard.blog.detail', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code'), 'article_id' => $standardArticleBlog->{config('const.db.standard_articles.ID')}]) }}">
                                    <figure><img src="{{ $standardArticleBlog->articleMainImageUrl('s') }}" alt="写真"></figure>
                                    <p class="date">{{ $standardArticleBlog->getPublishedDate() }}</p>
                                    <dl>
                                        <dt>{{ $standardArticleBlog->{config('const.db.standard_articles.TITLE')} }}</dt>
                                        <dd class="text">{{ $standardArticleBlog->{config('const.db.standard_articles.SUMMARY')} }}</dd>
                                        <dd class="continue">...続きを読む</dd>
                                    </dl>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <p class="listLink sponly"><a href="{{ route('front.shop.standard.blog', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}"><i class="fas fa-arrow-circle-right"></i>現場ブログをもっと見る</a></p>
            </section>
        @endif

        @if ($standardArticleEvents->isNotEmpty())
            <section class="caseSec _event">
                <div class="ttlBlock">
                    <h2>イベント・キャンペーン</h2>
                    <p class="listLink"><a href="{{ route('front.shop.standard.event', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}"><i class="fas fa-arrow-circle-right"></i>イベント・キャンペーンをもっと見る</a></p>
                </div>
                <div class="caseWrap">
                    <ul class="caseList">
                        @foreach ($standardArticleEvents as $standardArticleEvent)
                            <li>
                                <a href="{{ route('front.shop.standard.event.detail', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code'), 'article_id' => $standardArticleEvent->{config('const.db.standard_articles.ID')}]) }}">
                                    <figure><img src="{{ $standardArticleEvent->articleMainImageUrl('s') }}" alt="写真"></figure>
                                    <p class="date">{{ $standardArticleEvent->getPublishedDate() }}</p>
                                    <dl>
                                        <dt>{{ $standardArticleEvent->{config('const.db.standard_articles.TITLE')} }}</dt>
                                        <dd class="text">{{ $standardArticleEvent->{config('const.db.standard_articles.SUMMARY')} }}</dd>
                                        <dd class="continue">...続きを読む</dd>
                                    </dl>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <p class="listLink sponly"><a href="{{ route('front.shop.standard.event', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}"><i class="fas fa-arrow-circle-right"></i>イベント・キャンペーンをもっと見る</a></p>
            </section>
        @endif

        <section class="newsSec">
            <div class="ttlBlock">
                <h2>お知らせ</h2>
            <p class="listLink"><a href="{{ route('front.shop.standard.news', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}"><i class="fas fa-arrow-circle-right"></i>一覧へ</a></p>
            </div>
            <div class="newsBox">
                <ul>
                    @foreach ($standardNotices as $standardNotice)
                        <li>
                            <dl>
                                <dt>{{ $standardNotice->getPublishedDate() }}</dt>
                                <dd>{{ $standardNotice->{config('const.db.standard_notices.TEXT')} }}</dd>
                            </dl>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        <ul class="campBnr">
            <li><a href="/page/health/index"><img src="{{ asset('/common/img/bnr_camp06.jpg') }}" width="270" alt="健康・快適はマドから"></a></li>
            <li>
                <script src="https://mado-reform.lixil.co.jp/api/js/lixil_url.js"></script>
                <script src="https://mado-reform.lixil.co.jp/api/js/lixil_banner.js"></script>
                <script>
                document.write(
                   getBanner(7)
                );
                </script>
            </li>
            @foreach ($banners as $banner)
                <li>
                    <a href="{{ $banner->{config('const.db.banners.URL')} }}" target="_blank"><img src="{{ $banner->imageUrl() }}" width="270" alt=""></a>
                </li>
            @endforeach
        </ul>

        <script>objectFitImages();</script>
    </article>
</main>
@endsection

@section ('script')
@parent

<script>
    $(document).ready(function(){
            $(".caseList").owlCarousel({
            autoplay: false,
            loop: false,
            mouseDrag: true,
            nav: true,
            navText:["",""],
            responsive:{
                0 : {
                    items: 2
                },
                769 : {
                    items: 4
                }
            }
        });
    });
    </script>
@endsection
