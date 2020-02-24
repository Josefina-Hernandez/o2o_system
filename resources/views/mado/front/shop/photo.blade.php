@extends('mado.front.template')

@if('front.shop.photo' === \Route::currentRouteName())
    @section('title', '全国の施工事例一覧｜LIXIL簡易見積りシステム')
@elseif('front.shop.photo.search' === \Route::currentRouteName())
    @section('title', '施工事例検索｜LIXIL簡易見積りシステム')
@endif

@section('description', '日本全国のLIXIL簡易見積りシステム加盟店でリフォームを行った施工事例を紹介しています。最新の施工事例を掲載しておりますのでぜひご参考くださいませ。')

@section('frontcss')
    <link rel="stylesheet" href="{{ asset('css/photo.css') }}">
@endsection

@section('head')
    @parent
<script src="//cdnjs.cloudflare.com/ajax/libs/object-fit-images/3.2.3/ofi.js"></script>
@endsection

@section("main")
<main id="mainArea" class="photo">
    <article>
        @include ('mado.front.parts.breadcrumbs')

        <h1>
                @if('front.shop.photo' === \Route::currentRouteName())
                    <p>全国の施工事例一覧</p>
                @elseif('front.shop.photo.search' === \Route::currentRouteName())
                    <p>施工事例検索</p>
                @endif
        </h1>

        {!! Form::open([
            'route' => ['front.shop.photo.search'],
            'method' => 'get',
        ]) !!}
        <dl class="searchBox">
            <dt><i class="fas fa-search"></i>この店舗の施工事例を検索</dt>
            <dd>
                {!! Form::text(config('const.form.common.SEARCH_KEYWORDS'), '', [
                    'placeholder' => 'キーワード',
                ]) !!}
                <button type="submit" class="searchBtn">検索</button>
                <p class="checkBox">
                    {!! Form::checkbox(config('const.form.common.VOICE'), config('const.form.common.CHECKED'), false, [
                        'id' => config('const.form.common.VOICE'),
                    ]) !!}
                    {!! Form::label(config('const.form.common.VOICE'), 'お客様の声紹介事例のみ表示', []) !!}
                </p>
            </dd>
        </dl>
        {!! Form::close() !!}

        <div class="caseWrap">
            @if ($photos->isEmpty())
                @if('front.shop.photo' === \Route::currentRouteName())
                    <p class="img100"><img src="{{ ('/img/notregist.png') }}" alt="登録されておりません"></p>
                @elseif('front.shop.photo.search' === \Route::currentRouteName())
                    <p class="img100"><img src="{{ ('/img/notfound.png') }}" alt="検索結果0件　該当するページは見つかりませんでした"></p>
                @endif
            @else
                <ul class="caseList _sub">
                    @foreach ($photos as $photo)
                        <li>
                            @if ($photo instanceof \App\Models\PremiumPhoto)
                                <a href="{{ $photo->photoUrl() }}" target="_blank">
                                    <figure><img src="{{ $photo->featuredImageUrl() }}" alt="施工事例の写真"></figure>
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
                                    <figure><img src="{{ $photo->photoMainImageUrl() }}" alt="施工事例の写真"></figure>
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
            @endif

            @if ('front.shop.photo' === \Route::currentRouteName())
                {{ $photos->links() }}
            @elseif ('front.shop.photo.search' === \Route::currentRouteName())
                {{ $photos->appends($queryParams)->links() }}
            @endif
        </div>

        <script>objectFitImages();</script>
    </article>
</main>
@endsection
