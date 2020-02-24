<section class="shopSec">
    <p class="closebtn"><a href="javascript:void(0)" onclick="parent.$.colorbox.close();"><img src="/common/img/modal_close.png" alt="閉じる" width="100"></a></p>
    <div class="shopBox">
        {{-- フロントTOP, 日本地図モーダルからの参照の場合 --}}
        @if (in_array(\Route::currentRouteName(), ['front', 'front.shop.search.modal'], true))
            <h2>お近くの店舗を探す</h2>
            <p class="pconly">お近くの地域を選択して下さい。</p>

            @if ('front' === \Route::currentRouteName())
                <div class="searchBox">
                    {!! Form::open([
                        'route' => ('front.shop.search.keyword'),
                        'method' => 'get',
                    ]) !!}
                        {!! Form::text(config('const.form.common.SEARCH_KEYWORDS'), '', [
                            'placeholder' => '地名・キーワードから探す',
                        ]) !!}
                        <button type="submit"><i class="fas fa-search"></i></button>
                    {!! Form::close() !!}
                </div>
            @endif

        {{-- 日本地図モーダル（見積りシミュレーション絞り込み）からの参照の場合 --}}
        @elseif ('front.shop.search.modal.estimate' === \Route::currentRouteName())
            <h2>見積りシミュレーションに<br>対応している店舗を<br>検索できます!!</h2>
        @endif

        <label for="pref" class="select-group sponly" id="pref-change">
            {!! Form::select(
                config('const.db.shops.PREF_ID'),
                $prefs,
                null,
                [
                    'id' => null,
                    'class' => null,
                    'v-on:change' => 'onChange',
                ]
            ) !!}
        </label>
    </div>
    <svg id="svgMap">
        @foreach (config('const.japan_map') as $regionName => $prefs)
            <g id="{{ $regionName }}">
                @foreach ($prefs as $prefName => $pref)
                    <a
                        {{-- フロントTOP, 日本地図モーダルからの参照の場合 --}}
                        @if (in_array(\Route::currentRouteName(), ['front', 'front.shop.search.modal'], true))
                            xlink:href="{{ route('front.shop.search.pref', ['pref_code' => $prefName]) }}"

                        {{-- 日本地図モーダル（見積りシミュレーション絞り込み）からの参照の場合 --}}
                        @elseif ('front.shop.search.modal.estimate' === \Route::currentRouteName())
                            xlink:href="{{ route('front.shop.search.pref', ['pref_code' => $prefName, config('const.form.common.SIMULATE') => config('const.form.common.CHECKED')]) }}" 
                        @endif

                        @if (! $shopsByPref->has($prefName))
                            class="disabled"
                        @endif
                        v-on:click="onClick"
                    >
                        <rect
                        id="{{ $prefName }}"
                        class="{{ $regionName }}"
                        @if (array_get($pref, 'rect.X') !== null)
                            x="{{ array_get($pref, 'rect.X') }}"
                        @endif
                        @if (array_get($pref, 'rect.Y') !== null)
                            y="{{ array_get($pref, 'rect.Y') }}"
                        @endif
                        width="{{ array_get($pref, 'rect.WIDTH') }}"
                        height="{{ array_get($pref, 'rect.HEIGHT') }}"/>

                        <text
                        id="{{ $prefName }}"
                        class="maptxt"
                        x="{{ array_get($pref, 'text.X') }}"
                        y="{{ array_get($pref, 'text.Y') }}">{{ array_get($pref, 'NAME') }}</text>
                    </a>
                @endforeach
            </g>
        @endforeach
    </svg>
</section>
