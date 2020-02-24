@extends('mado.admin.shop.template')

@if('admin.shop.photo.confirm' === \Route::currentRouteName())
    @section('title', '事例登録確認')
@elseif('admin.shop.photo.edit.confirm' === \Route::currentRouteName())
    @section('title', '事例編集確認')
@endif

@section('adminshopcss')
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/common/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/shop.css') }}">
@endsection

@section('main')
<main id="mainArea" class="photo _detail">
    <h1 class="mainTtl">施工事例プレビュー</h1>
    @include ('mado.admin.parts.notice_message')


    <div id="confirm-complete">
    @if ('admin.shop.photo.confirm' === \Route::currentRouteName())
    {!! Form::model($standardPhoto, [
        'route' => ['admin.shop.photo', 'shop_id' => $standardPhoto->{config('const.db.standard_photos.SHOP_ID')}],
        'enctype' => 'multipart/form-data',
        'v-on:submit.prevent' => 'onSubmit'
    ]) !!}

    @elseif ('admin.shop.photo.edit.confirm' === \Route::currentRouteName())
    {!! Form::model($standardPhoto, [
        'route' => ['admin.shop.photo.edit', 'shop_id' => $standardPhoto->{config('const.db.standard_photos.SHOP_ID')}, 'photo_id' => $standardPhoto->{config('const.db.standard_photos.ID')}],
        'enctype' => 'multipart/form-data',
        'v-on:submit.prevent' => 'onSubmit'
    ]) !!}
    @endif

    <article>
        <div class="ttlBlock">
            <h1>{{ $standardPhoto->{config('const.db.standard_photos.TITLE')} }}</h1>
            <p class="date">
                @if ('admin.shop.photo.confirm' === \Route::currentRouteName())
                    {{ now()->format('Y年n月j日') }}
                @elseif ('admin.shop.photo.edit.confirm' === \Route::currentRouteName())
                    {{ $standardPhoto->getCreatedDate() }}
                @endif
            </p>
        </div>
        
        <div class="flexBlock">
            <figure class="mainPhoto">
                @isset ($mainPicture)
                    <img src="{{ $mainPicture }}" alt="写真">
                @endisset
            </figure>
            <div class="desc">
                <ul class="descList">
                    <li>
                        <dl>
                            <dt>建物</dt>
                            <dd>{{ config('const.form.admin.shop.standard_photo.CATEGORY')[$standardPhoto->{config('const.db.standard_photos.CATEGORY')}] }}</dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt>住宅の築年数</dt>
                            <dd>{{ config('const.form.admin.shop.standard_photo.BUILT_YEAR')[$standardPhoto->{config('const.db.standard_photos.BUILT_YEAR')}] }}</dd>
                        </dl>
                    </li>
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
                    @foreach ($standardPhoto->{config('const.db.standard_photos.REASON')} as $reason)
                        <li>{{ config('const.form.admin.shop.standard_photo.REASON')[$reason] }}</li>
                    @endforeach
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
                            @isset ($customerPicture)
                                <img src="{{ $customerPicture }}" alt="お客様の声　イメージ画像">
                            @endisset
                    </figure>
                    <p class="voiceTxt">{!! nl2br($standardPhoto->{config('const.db.standard_photos.CUSTOMER_TEXT')}, false) !!}</p>
                </div>
                <div class="voiceBlock">
                    <figure class="voiceImg">
                            @isset ($customerPicture2)
                                <img src="{{ $customerPicture2 }}" alt="お客様の声　アンケート画像">
                            @endisset
                    </figure>
                    <p class="voiceTxt">{!! nl2br($standardPhoto->{config('const.db.standard_photos.CUSTOMER_TEXT_2')}, false) !!}</p>
                </div>
            </section>
        @endif

        {!! Form::hidden(config('const.db.standard_photos.SHOP_ID')) !!}
        {!! Form::hidden(config('const.db.standard_photos.TITLE')) !!}
        {!! Form::hidden(config('const.db.standard_photos.SUMMARY')) !!}
        {!! Form::hidden(config('const.db.standard_photos.MAIN_TEXT')) !!}
        {!! Form::hidden(config('const.db.standard_photos.BEFORE_TEXT')) !!}
        {!! Form::hidden(config('const.db.standard_photos.AFTER_TEXT')) !!}
        {!! Form::hidden(config('const.db.standard_photos.IS_CUSTOMER_PUBLISH')) !!}
        {!! Form::hidden(config('const.db.standard_photos.CUSTOMER_TEXT')) !!}
        {!! Form::hidden(config('const.db.standard_photos.CUSTOMER_TEXT_2')) !!}
        {!! Form::hidden(config('const.db.standard_photos.CATEGORY')) !!}
        {!! Form::hidden(config('const.db.standard_photos.BUILT_YEAR')) !!}
        @foreach ($standardPhoto->{config('const.db.standard_photos.PARTS')} as $parts)
            <input type="hidden" name="{!! config('const.db.standard_photos.PARTS') . '[]' !!}" value="{!! $parts !!}">
        @endforeach
        @foreach ($standardPhoto->{config('const.db.standard_photos.REASON')} as $reason)
            <input type="hidden" name="{!! config('const.db.standard_photos.REASON') . '[]' !!}" value="{!! $reason !!}">
        @endforeach
        @foreach ($standardPhoto->{config('const.db.standard_photos.CATEGORY_FOR_SEARCH')} as $category)
            <input type="hidden" name="{!! config('const.db.standard_photos.CATEGORY_FOR_SEARCH') . '[]' !!}" value="{!! $category !!}">
        @endforeach
        {!! Form::hidden(config('const.db.standard_photos.LOCALE')) !!}
        {!! Form::hidden(config('const.db.standard_photos.BUDGET')) !!}
        {!! Form::hidden(config('const.db.standard_photos.PERIOD')) !!}
        {!! Form::hidden(config('const.db.standard_photos.PRODUCT')) !!}
        {!! Form::hidden(config('const.db.standard_photos.CLIENT_AGE')) !!}
        {!! Form::hidden(config('const.db.standard_photos.HOUSEHOLD')) !!}
        {!! Form::hidden(config('const.db.standard_photos.CHILD')) !!}
        @isset ($standardPhoto->{config('const.db.standard_photos.PET')})
            @foreach ($standardPhoto->{config('const.db.standard_photos.PET')} as $pet)
                <input type="hidden" name="{!! config('const.db.standard_photos.PET') . '[]' !!}" value="{!! $pet !!}">
            @endforeach
        @else
            {!! Form::hidden(config('const.db.standard_photos.PET'), '') !!}
        @endisset

        <div class="btnBlock">
            @if ('admin.shop.photo.confirm' === \Route::currentRouteName())
                {!! Form::submit('修正', [
                    'class' => 'button _back',
                    'v-on:click' => 'onClick("' . route('admin.shop.photo.new', ['shop_id' => $standardPhoto->{config('const.db.standard_photos.SHOP_ID')}]) . '")',
                    ]) !!}
                {!! Form::submit('登録', [
                    'class' => 'button _submit',
                    'v-on:click' => 'onClick("' . route('admin.shop.photo.complete', ['shop_id' => $standardPhoto->{config('const.db.standard_photos.SHOP_ID')}]) . '")',
                    ]) !!}

                @elseif ('admin.shop.photo.edit.confirm' === \Route::currentRouteName())
                {!! Form::submit('修正', [
                    'class' => 'button _back',
                    'v-on:click' => 'onClick("' . route('admin.shop.photo.edit', ['shop_id' => $standardPhoto->{config('const.db.standard_photos.SHOP_ID')}, 'photo_id' => $standardPhoto->{config('const.db.standard_photos.ID')}]) . '")',
                    ]) !!}
                {!! Form::submit('登録', [
                    'class' => 'button _submit',
                    'v-on:click' => 'onClick("' . route('admin.shop.photo.edit.complete', ['shop_id' => $standardPhoto->{config('const.db.standard_photos.SHOP_ID')}, 'photo_id' => $standardPhoto->{config('const.db.standard_photos.ID')}]) . '")',
                    ]) !!}
                @endif
        </div>
    </article>

    {!! Form::close() !!}
    </div>
</main>
@endsection

@section('script')
    @parent
    <script src="{{ asset('/common/js/jquery.js') }}"></script>
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
