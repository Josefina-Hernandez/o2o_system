@extends('mado.front.template')

@section('title', $city->pref->{config('const.db.prefs.NAME')} . $city->name . 'のLIXIL簡易見積りシステム一覧｜LIXIL簡易見積りシステム')

@section('description', $city->pref->{config('const.db.prefs.NAME')} . $city->name . 'のLIXIL簡易見積りシステムのサービスを取り扱う加盟店舗の検索結果一覧です。')

@section('frontcss')
<link rel="stylesheet" href="{{ asset('/css/search.css') }}">
@endsection

@section('main')
<main id="mainArea" class="search">
    <article>
        @include ('mado.front.parts.breadcrumbs')

        <div class="ttlBlock">
            <h1>{{ $city->pref->{config('const.db.prefs.NAME')} }}{{ $city->{config('const.db.cities.NAME')} }}のLIXIL簡易見積りシステム一覧</h1>
            <p class="button"><a href="{{ route('front.shop.search.pref', array_merge(['pref_code' => $city->pref->{config('const.db.prefs.CODE')}], $queryParams)) }}">市区町村を変更</a></p>
        </div>

        <div class="searchWrap">
            @if ($shops->isEmpty())
                <p class="img100"><img src="{{ ('/img/notfound.png') }}" alt="検索結果0件　該当するページは見つかりませんでした"></p>
            @else
                <!-- <p class="numberTxt">{{ $shops->total() }}ショップが該当しました</p> -->

                <ul class="searchList">
                    @foreach ($shops as $shop)
                        @include ('mado.front.parts.shop_list')
                    @endforeach
                </ul>

                {{ $shops->appends($queryParams)->links() }}
            @endif
        </div>
    </article>
</main>
@endsection
