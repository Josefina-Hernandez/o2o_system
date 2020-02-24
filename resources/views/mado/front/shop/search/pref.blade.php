@extends('mado.front.template')

@section('title',  $pref->name . 'のLIXIL簡易見積りシステム一覧｜LIXIL簡易見積りシステム')

@section('description', $pref->name . 'でLIXIL簡易見積りシステムのサービスを取り扱う加盟店舗の検索結果一覧です。全国に展開する窓・玄関ドアの専門店がお客様のお悩みを解決します。')

@section('frontcss')
<link rel="stylesheet" href="{{ asset('/css/search.css') }}">
@endsection

@section('head')
    @parent

    <script src="{{ asset('/common/js/search.js') }}"></script>
@endsection

@section('main')
<main id="mainArea" class="search">
    <article>
        @include ('mado.front.parts.breadcrumbs')

        <div class="ttlBlock">
            <h1>{{ $pref->{config('const.db.prefs.NAME')} }}のLIXIL簡易見積りシステム一覧</h1>
            <p class="button">
                @if (request()->query(config('const.form.common.SIMULATE')) === config('const.form.common.CHECKED'))
                    <a href="{{ route('front.shop.search.modal.estimate') }}" class="shopmodal">
                @else
                    <a href="{{ route('front.shop.search.modal') }}" class="shopmodal">
                @endif
                都道府県を変更</a>
            </p>
        </div>

        <div
            id="gmapArea"
            v-init:shop-data="'{{ $mapData }}'"
            v-init:key="'{{ config('const.common.api_key.GOOGLE_MAP') }}'"
            v-init:pref-center-position="'{{ json_encode(config('const.pref_positions.' . $pref->{config('const.db.prefs.CODE')})) }}'"></div>

        <section class="refineSec">
            <h2>市区町村で絞り込み</h2>
            <div class="cityListWrap">
                <ul class="cityList">
                    @foreach ($cities as $city)
                        <li>
                            <a href="{{ route('front.shop.search.city', array_merge(['pref_code' => $pref->{config('const.db.prefs.CODE')}, 'city_code' => $city->{config('const.db.cities.CODE')}], $queryParams)) }}">{{ $city->{config('const.db.cities.NAME')} }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        <div class="searchWrap">
            @if ($shops->isEmpty())
                <p class="img100"><img src="{{ ('/img/notfound.png') }}" alt="検索結果0件　該当するページは見つかりませんでした"></p>
            @else
                <!-- <p class="numberTxt">{{ $shops->total() }}ショップが該当しました</p> -->

                <ul class="searchList">
                    @foreach ($cities as $city)
                        {{-- 市区町村名 (件数) --}}
                        <!-- {{ $city->name }}({{ array_get($countShopsInCity, $city->id) }}件) -->
                        {{-- 市区町村に属するショップ一覧 --}}
                        @foreach (array_get($shopsByCity, $city->code) as $shop)
                            @include ('mado.front.parts.shop_list')
                        @endforeach
                    @endforeach
                </ul>

                {{ $shops->appends($queryParams)->links() }}
            @endif
        </div>
    </article>
</main>
@endsection

@section('script')
    {{-- google maps javascript APIの利用 --}}
    <script src="{{asset('js/app.js')}}" ></script>
    @parent
@endsection
