@extends('mado.front.shop.standard.template')

@section('title', "{$standardPhoto->{config('const.db.standard_photos.TITLE')}}｜事例紹介｜{$shop->{config('const.db.shops.NAME')}}｜LIXIL簡易見積りシステム")
@section('description', "LIXIL簡易見積りシステムサービス加盟店「{$shop->{config('const.db.shops.NAME')}}」の事例紹介ページです。")

@section('frontcss')
    <link rel="stylesheet" href="{{ asset('/common/css/owl.carousel.css') }}">
    @parent
@endsection

@section('main')
<main id="mainArea" class="photo _detail">
    @include('mado.front.shop.standard.parts.header')

    <article>
        @include ('mado.front.parts.breadcrumbs')
        <div class="ttlBlock">
            <h1>{{ $standardPhoto->{config('const.db.standard_photos.TITLE')} }}</h1>
            <p class="date">{{ $standardPhoto->getCreatedDate() }}</p>
        </div>

        <div class="flexBlock">
            <figure class="mainPhoto"><img src="{{ $standardPhoto->photoMainImageUrl('s') }}" alt="施工事例の写真"></figure>
            <div class="desc">
                <ul class="descList">
                    <li>
                        <dl>
                            <dt>建物</dt>
                            <dd>{{ config('const.form.admin.shop.standard_photo.CATEGORY')[$standardPhoto->{config('const.db.standard_photos.CATEGORY')}] }}</dd>
                        </dl>
                    </li>
                    @if (isset($standardPhoto->{config('const.db.standard_photos.BUILT_YEAR')})
                        && $standardPhoto->{config('const.db.standard_photos.BUILT_YEAR')} != 0)
                    <li>
                        <dl>
                            <dt>住宅の築年数</dt>
                            <dd>{{ config('const.form.admin.shop.standard_photo.BUILT_YEAR')[$standardPhoto->{config('const.db.standard_photos.BUILT_YEAR')}] }}</dd>
                        </dl>
                    </li>
                    @endif
                    <li>
                        <dl>
                            <dt>リフォーム箇所</dt>
                            <dd>{{ $standardPhoto->concatParts() }}</dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt>商品</dt>
                            <dd>{{ $standardPhoto->{config('const.db.standard_photos.PRODUCT')} }}</dd>
                        </dl>
                    </li>
                    @isset ($standardPhoto->{config('const.db.standard_photos.BUDGET')})
                        <li>
                            <dl>
                                <dt>予算</dt>
                                <dd>{{ $standardPhoto->{config('const.db.standard_photos.BUDGET')} }}万円</dd>
                            </dl>
                        </li>
                    @endisset
                    <li>
                        <dl>
                            <dt>工期</dt>
                            <dd>{{ $standardPhoto->{config('const.db.standard_photos.PERIOD')} }}</dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt>地域</dt>
                            <dd>{{ $standardPhoto->{config('const.db.standard_photos.LOCALE')} }}</dd>
                        </dl>
                    </li>
                    @if (
                            (isset($standardPhoto->{config('const.db.standard_photos.CLIENT_AGE')}) && $standardPhoto->{config('const.db.standard_photos.CLIENT_AGE')} != 99)
                            || (isset($standardPhoto->{config('const.db.standard_photos.HOUSEHOLD')}) && $standardPhoto->{config('const.db.standard_photos.HOUSEHOLD')} != 99)
                            || (isset($standardPhoto->{config('const.db.standard_photos.CHILD')}) && $standardPhoto->{config('const.db.standard_photos.CHILD')} != 99)
                        )
                        <li>
                            <dl>
                                <dt>ご家族構成</dt>
                                <dd>{{ $standardPhoto->concatFamily() }}</dd>
                            </dl>
                        </li>
                    @endif
                    @if (! empty($standardPhoto->{config('const.db.standard_photos.PET')}))
                        <li>
                            <dl>
                                <dt>ペット</dt>
                                <dd>{{ $standardPhoto->concatPet() }}</dd>
                            </dl>
                        </li>
                    @endif
                </ul>
                <ul class="reasonList">
                    @isset ($standardPhoto->{config('const.db.standard_photos.REASON')})
                        @foreach ($standardPhoto->{config('const.db.standard_photos.REASON')} as $reason)
                            <li>{{ config('const.form.admin.shop.standard_photo.REASON')[$reason] }}</li>
                        @endforeach
                    @endisset
                </ul>
            </div>
        </div>
        <p class="mainTxt">{!! nl2br($standardPhoto->{config('const.db.standard_photos.MAIN_TEXT')}, false) !!}</p>

        <section class="befafSec _before">
            <div class="befafTtl">
                <p>Before</p>
                <h2>施工前</h2>
            </div>
            <div class="befafBlock">
                <div class="befafImg @if (count($beforePictures) >= 2)_list @endif">
                    @foreach ($beforePictures as $beforePicture)
                        <figure><img src="{{ $beforePicture }}" alt="写真"></figure>
                    @endforeach
                </div>
                <p class="befafTxt">{!! nl2br($standardPhoto->{config('const.db.standard_photos.BEFORE_TEXT')}, false) !!}</p>
            </div>
        </section>
        <section class="befafSec _after">
            <div class="befafTtl">
                <p>After</p>
                <h2>施工後</h2>
            </div>
            <div class="befafBlock">
                <div class="befafImg @if (count($afterPictures) >= 2)_list @endif">
                    @foreach ($afterPictures as $afterPicture)
                        <figure><img src="{{ $afterPicture }}" alt="写真"></figure>
                    @endforeach
                </div>
                <p class="befafTxt">{!! nl2br($standardPhoto->{config('const.db.standard_photos.AFTER_TEXT')}, false) !!}</p>
            </div>
        </section>

        @if ($standardPhoto->{config('const.db.standard_photos.IS_CUSTOMER_PUBLISH')} == config('const.common.ENABLE'))
            <section class="voiceSec">
                <h2><i class="fas fa-comment-dots"></i>お客さまの声</h2>
                <div class="voiceBlock">
                    <figure class="voiceImg">
                        @if ($standardPhoto->photoCustomerImageUrl() !== null)
                            <img src="{{ $standardPhoto->photoCustomerImageUrl() }}" alt="お客様の声　イメージ画像">
                        @endif
                    </figure>
                    <p class="voiceTxt">{!! nl2br($standardPhoto->{config('const.db.standard_photos.CUSTOMER_TEXT')}, false) !!}</p>
                </div>
                <div class="voiceBlock">
                    <figure class="voiceImg">
                        @if ($standardPhoto->photoCustomer2ImageUrl() !== null)
                            <img src="{{ $standardPhoto->photoCustomer2ImageUrl() }}" alt="お客様の声　アンケート画像">
                        @endif
                    </figure>
                    <p class="voiceTxt">{!! nl2br($standardPhoto->{config('const.db.standard_photos.CUSTOMER_TEXT_2')}, false) !!}</p>
                </div>
            </section>
        @endif

        <ul class="prevnextNav">
            <li>
                @isset ($previousStandardPhoto)
                    <a href="{{ route('front.shop.standard.photo.detail', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code'), 'photo_id' => $previousStandardPhoto->{config('const.db.standard_photos.ID')}]) }}">
                        <p>前の事例へ</p>
                        <figure>
                            <img src="{{ $previousStandardPhoto->photoMainImageUrl('s') }}" alt="前の事例">
                            <figcaption>{{ $previousStandardPhoto->{config('const.db.standard_photos.TITLE')} }}</figcaption>
                        </figure>
                    </a>
                @endisset
            </li>
            <li>
                @isset ($nextStandardPhoto)
                    <a href="{{ route('front.shop.standard.photo.detail', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code'), 'photo_id' => $nextStandardPhoto->{config('const.db.standard_photos.ID')}]) }}">
                        <p>次の事例へ</p>
                        <figure>
                            <img src="{{ $nextStandardPhoto->photoMainImageUrl('s') }}" alt="次の事例">
                            <figcaption>{{ $nextStandardPhoto->{config('const.db.standard_photos.TITLE')} }}</figcaption>
                        </figure>
                    </a>
                @endisset
            </li>
        </ul>

        @include ('mado.front.shop.standard.parts.shop_contact')

        @include ('mado.front.shop.standard.parts.shop_guide')
    </article>
</main>
@endsection

@section('script')
    @parent

    <script src="{{ asset('/common/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('/common/js/owl.carousel2.thumbs.min.js') }}"></script>
    <script>
        var owl = $('.befafImg._list');
        owl.owlCarousel({
            items: 1,
            nav: true,
            navText: ["",""],
            loop: true,
            thumbs: true,
            thumbImage: true,
            thumbContainerClass: 'owl-thumbs',
            thumbItemClass: 'owl-thumb-item'
        });
    </script>
@endsection
