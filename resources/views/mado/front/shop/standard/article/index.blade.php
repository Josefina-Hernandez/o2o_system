@extends('mado.front.shop.standard.template')

@if('front.shop.standard.blog' === \Route::currentRouteName())
    @section('title', "現場ブログ一覧｜{$shop->{config('const.db.shops.NAME')}}｜LIXIL簡易見積りシステム")
    @section('description', "LIXIL簡易見積りシステムサービス加盟店「{$shop->{config('const.db.shops.NAME')}}」の現場ブログ一覧ページです。")
@elseif('front.shop.standard.event' === \Route::currentRouteName())
    @section('title', "イベントキャンペーン一覧｜{$shop->{config('const.db.shops.NAME')}}｜LIXIL簡易見積りシステム")
    @section('description', "LIXIL簡易見積りシステムサービス加盟店「{$shop->{config('const.db.shops.NAME')}}」のイベントキャンペーン一覧ページです。")
@endif

@section('head')
    @parent
@endsection

@section('main')
<main id="mainArea" class="blog">
    @include('mado.front.shop.standard.parts.header')

    <article>
        @include ('mado.front.parts.breadcrumbs')
        <h1>
            @if('front.shop.standard.blog' === \Route::currentRouteName())
                現場ブログ一覧
            @elseif('front.shop.standard.event' === \Route::currentRouteName())
                イベントキャンペーン一覧
            @endif
        </h1>

        <div class="caseWrap">
            @if ($standardArticles->isEmpty())
                <p class="img100"><img src="{{ ('/img/notregist.png') }}" alt="登録されておりません"></p>

            @else
                <ul class="caseList _sub">
                    @foreach ($standardArticles as $standardArticle)
                        <li>
                            @if ('front.shop.standard.blog' === \Route::currentRouteName())
                                <a href="{{ route('front.shop.standard.blog.detail', [
                                    'pref_code' => $standardArticle->shop->pref->{config('const.db.prefs.CODE')},
                                    'shop_code' => $standardArticle->shop->{config('const.db.shops.SHOP_CODE')},
                                    'article_id' => $standardArticle->{config('const.db.standard_articles.ID')}
                                ]) }}">
                            @elseif ('front.shop.standard.event' === \Route::currentRouteName())
                                <a href="{{ route('front.shop.standard.event.detail', [
                                    'pref_code' => $standardArticle->shop->pref->{config('const.db.prefs.CODE')},
                                    'shop_code' => $standardArticle->shop->{config('const.db.shops.SHOP_CODE')},
                                    'article_id' => $standardArticle->{config('const.db.standard_articles.ID')}
                                ]) }}">
                            @endif
                                <figure>
                                    <img src="{{ $standardArticle->articleMainImageUrl('s') }}">
                                </figure>
                                <div class="date">
                                    <p>{{ $standardArticle->getPublishedDate() }}</p>
                                    <p>{{ $standardArticle->shop->{config('const.db.shops.NAME')} }}</p>
                                </div>
                                <dl>
                                    <dt>{{ $standardArticle->{config('const.db.standard_articles.TITLE')} }}</dt>
                                    <dd class="text">{{ $standardArticle->{config('const.db.standard_articles.SUMMARY')} }}</dd>
                                    <dd class="continue">...続きを読む</dd>
                                </dl>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif

            {{ $standardArticles->links() }}
        </div>

        @include ('mado.front.shop.standard.parts.shop_contact')

        @include ('mado.front.shop.standard.parts.shop_guide')
    </article>
</main>
@endsection

@section('script')
    @parent

    <script src="//cdnjs.cloudflare.com/ajax/libs/object-fit-images/3.2.3/ofi.js"></script>
    <script type="text/javascript">
        objectFitImages();
    </script>
@endsection
