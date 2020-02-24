@extends('mado.front.shop.standard.template')

@if('front.shop.standard.photo' === \Route::currentRouteName())
    @section('title', "施工事例一覧｜{$shop->{config('const.db.shops.NAME')}}｜LIXIL簡易見積りシステム")
    @section('description', "LIXIL簡易見積りシステムサービス加盟店「{$shop->{config('const.db.shops.NAME')}}」の施工事例一覧ページです。")
@elseif('front.shop.standard.photo.search' === \Route::currentRouteName())
    @section('title', "施工事例検索結果｜{$shop->{config('const.db.shops.NAME')}}｜LIXIL簡易見積りシステム")
    @section('description', "LIXIL簡易見積りシステムサービス加盟店「{$shop->{config('const.db.shops.NAME')}}」の施工事例検索結果ページです。")
@endif

@section('head')
    @parent
<script src="//cdnjs.cloudflare.com/ajax/libs/object-fit-images/3.2.3/ofi.js"></script>
@endsection

@section("main")
<main id="mainArea" class="photo">
    @include('mado.front.shop.standard.parts.header')

    <article>
        @include ('mado.front.parts.breadcrumbs')
        <h1>
            @if('front.shop.standard.photo' === \Route::currentRouteName())
                施工事例一覧
            @elseif('front.shop.standard.photo.search' === \Route::currentRouteName())
                施工事例検索
            @endif
        </h1>
        {!! Form::open([
            'route' => ['front.shop.standard.photo.search', 'pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')],
            'method' => 'get',
        ]) !!}
        <dl class="searchBox">
            <dt><i class="fas fa-search"></i>この店舗の施工事例を検索</dt>
            <dd>
                    {!! Form::text(config('const.form.common.SEARCH_KEYWORDS'), '', [
                        'placeholder' => 'キーワード',
                    ]) !!}
                    <button type="submit"><i class="fas fa-search"></i></button>
            </dd>
        </dl>
        {!! Form::close() !!}

        <div class="caseWrap">
            @if ($standardPhotos->isEmpty())
                @if('front.shop.standard.photo' === \Route::currentRouteName())
                    <p class="img100"><img src="{{ ('/img/notregist.png') }}" alt="登録されておりません"></p>
                @elseif('front.shop.standard.photo.search' === \Route::currentRouteName())
                    <p class="img100"><img src="{{ ('/img/notfound.png') }}" alt="検索結果0件　該当するページは見つかりませんでした"></p>
                @endif
            @else
                <ul class="caseList _sub">
                    @foreach ($standardPhotos as $photo)
                        <li>
                            <a href="{{ route('front.shop.standard.photo.detail', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code'), 'photo_id' => $photo->{config('const.db.standard_photos.ID')}]) }}">
                                <figure><img src="{{ app()->make('image_get')->standardPhotoMainUrl($photo->{config('const.db.standard_photos.ID')}, 's') }}" alt="施工事例の写真"></figure>
                                <div class="date">
                                    <p>{{ $photo->getCreatedDate() }}</p>
                                </div>
                                <dl>
                                    <dt>{{ $photo->{config('const.db.standard_photos.TITLE')} }}</dt>
                                    <dd class="text">{{ $photo->{config('const.db.standard_photos.SUMMARY')} }}</dd>
                                    <dd class="continue">...続きを読む</dd>
                                </dl>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif

            {{ $standardPhotos->links() }}
        </div>

        @include ('mado.front.shop.standard.parts.shop_contact')

        @include ('mado.front.shop.standard.parts.shop_guide')

        <script>objectFitImages();</script>
    </article>
</main>
@endsection
