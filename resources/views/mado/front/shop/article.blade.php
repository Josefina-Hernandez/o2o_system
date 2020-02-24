@extends('mado.front.template')

@if('front.shop.blog' === \Route::currentRouteName())
    @section('title', '全国の現場ブログ一覧｜LIXIL簡易見積りシステム')
@elseif('front.shop.event' === \Route::currentRouteName())
    @section('title', '全国のイベントキャンペーン一覧｜LIXIL簡易見積りシステム')
@endif

@section('description', '')

@section('frontcss')
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
@endsection

@section('head')
    @parent
@endsection

@section("main")
<main id="mainArea" class="blog">
    <article>
        @include ('mado.front.parts.breadcrumbs')

        <h1>
            @if ('front.shop.blog' === \Route::currentRouteName())
                全国の現場ブログ
            @elseif ('front.shop.event' === \Route::currentRouteName())
                全国のイベントキャンペーン
            @endif
        </h1>


        <div class="caseWrap">
            @if ($articles->isEmpty())
                <p class="img100"><img src="{{ asset('/img/notfound.png') }}" alt="検索結果0件　該当するページは見つかりませんでした"></p>

            @else
                <ul class="caseList _sub">
                    @foreach ($articles as $article)
                        <li>
                            @if ($article instanceof \App\Models\PremiumArticle)
                                <a href="{{ $article->{config('const.db.premium_articles.WP_ARTICLE_URL')} }}" target="_blank">
                            @elseif ($article instanceof \App\Models\StandardArticle)
                                @if ('front.shop.blog' === \Route::currentRouteName())
                                    <a href="{{ route('front.shop.standard.blog.detail', [
                                        'pref_code' => $article->shop->pref->{config('const.db.prefs.CODE')},
                                        'shop_code' => $article->shop->{config('const.db.shops.SHOP_CODE')},
                                        'article_id' => $article->{config('const.db.standard_articles.ID')}
                                    ]) }}">
                                @elseif ('front.shop.event' === \Route::currentRouteName())
                                    <a href="{{ route('front.shop.standard.event.detail', [
                                        'pref_code' => $article->shop->pref->{config('const.db.prefs.CODE')},
                                        'shop_code' => $article->shop->{config('const.db.shops.SHOP_CODE')},
                                        'article_id' => $article->{config('const.db.standard_articles.ID')}
                                    ]) }}">
                                @endif
                            @endif
                                <figure>
                                    @if ($article instanceof \App\Models\PremiumArticle)
                                        <img src="{{ $article->featuredImageUrl() }}">
                                    @elseif ($article instanceof \App\Models\StandardArticle)
                                        <img src="{{ $article->articleMainImageUrl('s') }}">
                                    @endif
                                </figure>
                                <div class="date">
                                    <p>
                                        @if ($article instanceof \App\Models\PremiumArticle)
                                            {{ $article->getPostedDate() }}
                                        @elseif ($article instanceof \App\Models\StandardArticle)
                                            {{ $article->getPublishedDate() }}
                                        @endif
                                    </p>
                                    <p>{{ $article->shop->{config('const.db.shops.NAME')} }}</p>
                                </div>
                                <dl>
                                    <dt>{{ $article->{config('const.db.standard_articles.TITLE')} }}</dt>
                                    <dd class="text">{{ $article->{config('const.db.standard_articles.SUMMARY')} }}</dd>
                                    <dd class="continue">...続きを読む</dd>
                                </dl>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif

            {{ $articles->links() }}
        </div>

    </article>
</main>
@endsection
