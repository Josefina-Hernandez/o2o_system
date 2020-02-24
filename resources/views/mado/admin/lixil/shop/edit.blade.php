@extends('mado.admin.lixil.template')

@if('admin.lixil.shop.new' === \Route::currentRouteName())
    @section('title', '会員登録｜LIXIL簡易見積りシステム')
@elseif('admin.lixil.shop.edit' === \Route::currentRouteName())
    @section('title', '会員編集｜LIXIL簡易見積りシステム')
@endif

@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    @parent
@endsection

@section('main')
<main class="common">
    <h1 class="mainTtl">
        @if ('admin.lixil.shop.new' === \Route::currentRouteName())
            会員新規登録
        @elseif ('admin.lixil.shop.edit' === \Route::currentRouteName())
            会員編集
        @endif
    </h1>
    <p class="note"><span class="require">※</span>は必須項目となります</p>

    @if ('admin.lixil.shop.new' === \Route::currentRouteName())
        {!! Form::model($shop, [
            'route' => ('admin.lixil.shop.confirm'),
            'enctype' => 'multipart/form-data',
        ]) !!}

    @elseif ('admin.lixil.shop.edit' === \Route::currentRouteName())
        {!! Form::model($shop, [
            'route' => ['admin.lixil.shop.edit.confirm', 'shop_id' => $shop->{config('const.db.shops.ID')}],
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif

    <div id='pref-city'>
    <table class="formTbl">
        <tr>
            <th>プラン <span class="require">※</span></th>
            <td>
                @if ('admin.lixil.shop.new' === \Route::currentRouteName())
                    <ul class="radioList">
                        @foreach (config('const.form.admin.lixil.shop.PLAN') as $value => $label)
                            <li>
                            {!! Form::radio(
                                config('const.db.shops.SHOP_CLASS_ID'),
                                (string)$value,
                                null,
                                [
                                    'id' => config('const.db.shops.SHOP_CLASS_ID') . '_' . $value,
                                ]
                            ) !!}
                            {!! Form::label(
                                config('const.db.shops.SHOP_CLASS_ID') . '_' . $value,
                                $label,
                                [
                                    'id' => null,
                                    'class' => null,
                                ]
                            ) !!}
                            </li>
                        @endforeach
                        <p class="errMsg">{{ $errors->first(config('const.db.shops.SHOP_CLASS_ID')) }}</p>
                    </ul>

                @elseif ('admin.lixil.shop.edit' === \Route::currentRouteName())
                    <p>
                        {{ config('const.form.admin.lixil.shop.PLAN')[$shop->{config('const.db.shops.SHOP_CLASS_ID')}] }}
                    </p>
                    @endif
            </td>
        </tr>
        <tr>
            <th>法人名 <span class="require">※</span></th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.COMPANY_NAME'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                        ]
                    ) !!}
                    <p class="errMsg">{{ $errors->first(config('const.db.shops.COMPANY_NAME')) }}</p>
                </p>
            </td>
        </tr>
        <tr>
            <th>法人名（カナ） <span class="require">※</span></th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.COMPANY_NAME_KANA'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                        ]
                    ) !!}
                    <p class="errMsg">{{ $errors->first(config('const.db.shops.COMPANY_NAME_KANA')) }}</p>
                </p>
            </td>
        </tr>
        <tr>
            <th>店名 <span class="require">※</span></th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.NAME'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                        ]
                    ) !!}
                    <p class="errMsg">{{ $errors->first(config('const.db.shops.NAME')) }}</p>
                </p>
            </td>
        </tr>
        <tr>
            <th>店名（カナ） <span class="require">※</span></th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.KANA'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                        ]
                    ) !!}
                    <p class="errMsg">{{ $errors->first(config('const.db.shops.KANA')) }}</p>
                </p>
            </td>
        </tr>
        {{--Add Start MMEN-23 Thanhtv 20200113--}}
        <tr>
            <th>タイプ {{--<span class="require">※</span>--}}</th>
            <td>
                <p>
                    {{--{!! Form::checkbox(
                        config('const.db.shops.SHOP_TYPE')
                        , config('settings.shop_type.cainz')
                        , ($shop->{config('const.db.shops.SHOP_TYPE')} == 'CANIZ')? true: false
                        , [
                            'id' => 'shop_type'
                        ]
                    ) !!}
                    {{Form::label('shop_type', 'カインズ')}}--}}
                    {!! Form::select(
                           config('const.db.shops.SHOP_TYPE'),
                           config('settings.combobox_shop_type'),
                           $shop->{config('const.db.shops.SHOP_TYPE')},
                           [
                               'id' => null,
                               'class' => 'select',
                           ]
                    ) !!}
                </p>
            </td>
        </tr>
        {{--Add End MMEN-23 Thanhtv 20200113--}}
        <tr>
            <th>店舗写真</span></th>
            <td>
                <file-upload
                name="{{ config('const.form.admin.lixil.shop.MAIN_PICTURE') }}"
                image="{{ $mainPicture !== null ? "{$mainPicture}" : null }}"
                image-cls="shopPhoto"></file-upload>
                <p class="errMsg">{{ $errors->first(config('const.form.admin.lixil.shop.MAIN_PICTURE')) }}</p>
                <p class="note">店舗写真は、店舗前でスタッフが笑顔の写真を掲載しましょう！</p>
            </td>
        </tr>
        <tr>
            <th>店舗からのメッセージ</th>
            <td>
                <p>
                    {!! Form::textarea(
                        config('const.db.shops.MESSAGE'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                            'rows' => 5,
                            'placeholder' => '店舗からのメッセージはお客さまが店舗を選択する際の重要なポイントとなります。自社の紹介と強みをPRしましょう！',
                        ]
                    ) !!}</p>
                <p class="note">TOPページに掲載されるメッセージです。</p>
            </td>
        </tr>
        <tr>
            <th>施工事例</th>
            <td>
                <p>
                    {!! Form::textarea(
                        config('const.db.shops.PHOTO_SUMMARY'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                            'rows' => 2,
                            'placeholder' => '自社施工した代表的な施工現場の名称をご記入ください。   例）〇〇市役所・〇〇分譲地等',
                        ]
                    ) !!}
                </p>
            </td>
        </tr>
        <tr>
            <th>代表者名</span></th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.PRESIDENT_NAME'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                        ]
                    ) !!}
                </p>
            </td>
        </tr>
        <tr>
            <th>担当者名</th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.PERSONNEL_NAME'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                        ]
                    ) !!}
                </p>
            </td>
        </tr>
        <tr>
            <th>郵便番号 <span class="require">※</span></th>
            <td>
                {!! Form::text(
                    config('const.db.shops.ZIP1'),
                    null,
                    [
                        'id' => null,
                        'class' => 'w100',
                    ]
                ) !!} -
                {!! Form::text(
                    config('const.db.shops.ZIP2'),
                    null,
                    [
                        'id' => null,
                        'class' => 'w100',
                    ]
                ) !!}
                <p class="errMsg">{{ $errors->first(config('const.db.shops.ZIP1')) }}</p>
                <p class="errMsg">{{ $errors->first(config('const.db.shops.ZIP2')) }}</p>
            </td>
        </tr>
        <tr>
            <th>都道府県 <span class="require">※</span></th>
            <td>
                <div class="selectWrap">
                    {!! Form::select(
                        config('const.db.shops.PREF_ID'),
                        $prefs,
                        null,
                        [
                            'id' => null,
                            'v-on:change' => 'onPrefChange',
                            'v-init:city-list' => $cities,
                            'class' => 'select',
                        ]
                    ) !!}
                </div>
                <p class="errMsg">{{ $errors->first(config('const.db.shops.PREF_ID')) }}</p>
            </td>
        </tr>
        <tr>
            <th>市区町村 <span class="require">※</span></th>
            <td>
                <div class="selectWrap">
                    <select
                    name="{{ config('const.db.shops.CITY_ID') }}"
                    class="select"
                    v-model="selectedCity"
                    v-init:selected-city="{{ old(config('const.db.shops.CITY_ID')) ? old(config('const.db.shops.CITY_ID')) : ($shop->{config('const.db.shops.CITY_ID')} ? $shop->{config('const.db.shops.CITY_ID')} : null) }}">
                        <option v-for="city in cityList" v-bind:value="city.id">
                            @{{ city.name }}
                        </option>
                    </select>
                </div>
                <p class="errMsg">{{ $errors->first(config('const.db.shops.CITY_ID')) }}</p>
            </td>
        </tr>
        <tr>
            <th>町名・番地 <span class="require">※</span></th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.STREET'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                        ]
                    ) !!}
                    <p class="errMsg">{{ $errors->first(config('const.db.shops.STREET')) }}</p>
                </p>
            </td>
        </tr>
        <tr>
            <th>ビル名</th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.BUILDING'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                        ]
                    ) !!}
                </p>
            </td>
        </tr>
        <tr>
            <th>緯度 <span class="require">※</span></th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.LATITUDE'),
                        null,
                        [
                            'id' => null,
                            'class' => 'w400',
                        ]
                    ) !!}
                    <span class="unitTxt">
                        @if ('admin.lixil.shop.new' === Route::currentRouteName())
                            <a style="width:300px; height: 40px; line-height: 40px;" href="javascript:void(0);" onclick="window.open('/admin/lixil/shop/geocode?address=', 'geocode', 'width=500, height=400, menubar=no, toolbar=no, scrollbars=yes');">住所から緯度経度変換</a>　<a href="https://maps.google.co.jp/?q=0,0" target="_blank">緯度経度よりGoogleMapで確認</a>
                        @elseif ('admin.lixil.shop.edit' === \Route::currentRouteName())
                            <a style="width:300px; height: 40px; line-height: 40px;" href="javascript:void(0);" onclick="window.open('/admin/lixil/shop/geocode?address={{$shop->address()}}', 'geocode', 'width=500, height=400, menubar=no, toolbar=no, scrollbars=yes');">住所から緯度経度変換</a>　<a href="https://maps.google.co.jp/?q=0,0" target="_blank">緯度経度よりGoogleMapで確認</a>
                        @endif
                    </span>
                    <p class="errMsg">{{ $errors->first(config('const.db.shops.LATITUDE')) }}</p>
                </p>
            </td>
        </tr>
        <tr>
            <th>経度 <span class="require">※</span></th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.LONGITUDE'),
                        null,
                        [
                            'id' => null,
                            'class' => 'w400',
                        ]
                    ) !!}
                    <span class="unitTxt"></span>
                    <p class="errMsg">{{ $errors->first(config('const.db.shops.LONGITUDE')) }}</p>
                </p>
            </td>
        </tr>
        <tr>
            <th>対応エリア</th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.SUPPORT_AREA'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                            'rows' => 2,
                        ]
                    ) !!}
                </p>
                <p class="note">工事可能な市区町村を入力してください。<br>複数ある場合は、スペースで区切って入力してください。<br>（例：東京の場合）中央区 新宿区 台東区 港区</p>
            </td>
        </tr>
        <tr>
            <th>電話番号 <span class="require">※</span></th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.TEL'),
                        null,
                        [
                            'id' => null,
                            'class' => 'w200',
                        ]
                    ) !!}
                    <p class="errMsg">{{ $errors->first(config('const.db.shops.TEL')) }}</p>
                    <span class="unitTxt">ハイフンでつないで入力してください。（例）03-1111-2222</span>
                </p>
            </td>
        </tr>
        <tr>
            <th>FAX番号 <span class="require">※</span></th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.FAX'),
                        null,
                        [
                            'id' => null,
                            'class' => 'w200',
                        ]
                    ) !!}
                    <p class="errMsg">{{ $errors->first(config('const.db.shops.FAX')) }}</p>
                    <span class="unitTxt">ハイフンでつないで入力してください。（例）03-1111-2222</span>
                </p>
            </td>
        </tr>
        <tr>
            <th>メールアドレス <span class="require">※</span></th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.EMAIL'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                        ]
                    ) !!}
                    <p class="errMsg">{{ $errors->first(config('const.db.shops.EMAIL')) }}</p>
                </p>
            </td>
        </tr>
        <tr>
            <th>営業時間 <span class="require">※</span></th>
            <td>
                {!! Form::text(
                    config('const.db.shops.OPEN_TIME'),
                    null,
                    [
                        'id' => 'timepicker',
                        'class' => 'w100',
                    ]
                ) !!}
                ～
                {!! Form::text(
                    config('const.db.shops.CLOSE_TIME'),
                    null,
                    [
                        'id' => 'timepicker',
                        'class' => 'w100',
                    ]
                ) !!}
                <p class="errMsg">{{ $errors->first(config('const.db.shops.OPEN_TIME')) }}</p>
                <p class="errMsg">{{ $errors->first(config('const.db.shops.CLOSE_TIME')) }}</p>
            </td>
        </tr>
        <tr>
            <th>営業時間補足</th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.OTHER_TIME'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                        ]
                    ) !!}
                </p>
                <p class="note">曜日により営業時間が変わる場合などは、補足説明を記入してください。</p>
            </td>
        </tr>
        <tr>
            <th>定休日 <span class="require">※</span></th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.NORMALLY_CLOSE_DAY'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                        ]
                    ) !!}
                </p>
                <p class="errMsg">{{ $errors->first(config('const.db.shops.NORMALLY_CLOSE_DAY')) }}</p>
                <p class="note">複数ある場合は、スペースで区切って入力してください。<br>（例）年末年始 火曜日 水曜日</p>
            </td>
        </tr>
        <tr>
            <th>取扱施工内容 <span class="require">※</span></th>
            <td>
                <ul class="radioList">
                    @foreach (config('const.form.admin.shop.SUPPORT_DETAIL_LIST') as $value => $label)
                    <li>
                    {!! Form::checkbox(
                        config('const.db.shops.SUPPORT_DETAIL_LIST') . '[]',
                        (string)$value,
                        null,
                        [
                            'id' => config('const.db.shops.SUPPORT_DETAIL_LIST') . '_' . $value,
                        ]
                    ) !!}
                    {!! Form::label(
                        config('const.db.shops.SUPPORT_DETAIL_LIST') . '_' . $value,
                        $label,
                        [
                            'id' => null,
                            'class' => null,
                        ]
                    ) !!}
                    </li>
                    @endforeach
                </ul>
                <p class="errMsg">{{ $errors->first(config('const.db.shops.SUPPORT_DETAIL_LIST')) }}</p>
            </td>
        </tr>
        <tr>
            <th>資格</th>
            <td>
                <p>
                    {!! Form::textarea(
                        config('const.db.shops.CERTIFICATE'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                            'rows' => 2,
                        ]
                    ) !!}
                    <p class="errMsg">{{ $errors->first(config('const.db.shops.CERTIFICATE')) }}</p>
                </p>
            </td>
        </tr>
        <tr>
            <th>ホームページURL</th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.SITE_URL'),
                        null,
                        [
                            'id' => null,
                            'class' => 'w400',
                        ]
                    ) !!}
                    <span class="unitTxt">（例）https://www.lixil-sashdoor.jp/mitsumori-system</span>
                </p>
            </td>
        </tr>
        <tr>
            <th>資本金</th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.CAPITAL'),
                        null,
                        [
                            'id' => null,
                            'class' => 'w100',
                        ]
                    ) !!}<span class="unitTxt">万円</span>
                </p>
                <p class="errMsg">{{ $errors->first(config('const.db.shops.CAPITAL')) }}</p>
            </td>
        </tr>
        <tr>
            <th>創業</th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.COMPANY_START'),
                        null,
                        [
                            'id' => null,
                            'class' => 'w100',
                        ]
                    ) !!}<span class="unitTxt">年</span>
                </p>
            </td>
        </tr>
        <tr>
            <th>沿革</th>
            <td>
                <p>
                    {!! Form::textarea(
                        config('const.db.shops.COMPANY_HISTORY'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                            'rows' => 2,
                        ]
                    ) !!}
                </p>
            </td>
        </tr>
        <tr>
            <th>許可登録番号</th>
            <td>
                <p>
                    {!! Form::textarea(
                        config('const.db.shops.LICENSE'),
                        null,
                        [
                            'id' => null,
                            'class' => null,
                            'rows' => 2,
                        ]
                    ) !!}
                </p>
            </td>
        </tr>
        <tr>
            <th>従業員数</th>
            <td>
                <p>
                    {!! Form::text(
                        config('const.db.shops.EMPLOYEE_NUMBER'),
                        null,
                        [
                            'id' => null,
                            'class' => 'w100',
                        ]
                    ) !!}<span class="unitTxt">人</span>
                </p>
            </td>
        </tr>
        <tr>
            <th>対応サービス</th>
            <td>
                <ul class="radioList">
                    <li>
                        {!! Form::hidden(config('const.db.shops.HAS_T_POINT'), (string)config('const.common.DISABLE')) !!}
                        {!! Form::checkbox(
                            config('const.db.shops.HAS_T_POINT'),
                            (string)config('const.common.ENABLE'),
                            null,
                            [
                                'id' => config('const.db.shops.HAS_T_POINT')
                            ]
                        ) !!}
                        {!! Form::label(config('const.db.shops.HAS_T_POINT'), 'Tポイント提携', [
                            'id' => null,
                            'class' => null,
                        ]) !!}
                    </li>
                    <li>
                        {!! Form::hidden(config('const.db.shops.IS_NO_RATE'), (string)config('const.common.DISABLE')) !!}
                        {!! Form::checkbox(
                            config('const.db.shops.IS_NO_RATE'),
                            (string)config('const.common.ENABLE'),
                            null,
                            [
                                'id' => config('const.db.shops.IS_NO_RATE')
                            ]
                        ) !!}
                        {!! Form::label(config('const.db.shops.IS_NO_RATE'), '無金利', [
                            'id' => null,
                            'class' => null,
                        ]) !!}
                    </li>
                    <li>
                        {!! Form::hidden(config('const.db.shops.CAN_PAY_BY_CREDIT_CARD'), (string)config('const.common.DISABLE')) !!}
                        {!! Form::checkbox(
                            config('const.db.shops.CAN_PAY_BY_CREDIT_CARD'),
                            (string)config('const.common.ENABLE'),
                            null,
                            [
                                'id' => config('const.db.shops.CAN_PAY_BY_CREDIT_CARD')
                            ]
                        ) !!}
                        {!! Form::label(config('const.db.shops.CAN_PAY_BY_CREDIT_CARD'), 'クレジットカード決済', [
                            'id' => null,
                            'class' => null,
                        ]) !!}
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <th>窓マイスター</th>
            <td>
                <ul class="radioList">
                    <li>
                        {!! Form::hidden(config('const.db.shops.IS_MADO_MEISTER'), '0') !!}
                        {!! Form::checkbox(config('const.db.shops.IS_MADO_MEISTER'), '1', null, [
                            'id' => config('const.db.shops.IS_MADO_MEISTER')
                        ]) !!}
                        {!! Form::label(config('const.db.shops.IS_MADO_MEISTER'), '窓マイスターアイコン表示', [
                            'id' => null,
                            'class' => null,
                        ]) !!}
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <th>Twitter</th>
            <td>
                <p>
                    @ {!! Form::text(
                        config('const.db.shops.TWITTER'),
                        null,
                        [
                            'id' => null,
                            'class' => 'w200',
                        ]
                    ) !!}<span class="unitTxt">Twitterアカウントを入力してください</span>
                </p>
            </td>
        </tr>
        <tr>
            <th>Facebook</th>
            <td>
                <p>
                    https://www.facebook.com/
                    {!! Form::text(
                        config('const.db.shops.FACEBOOK'),
                        null,
                        [
                            'id' => null,
                            'class' => 'w200',
                        ]
                    ) !!}<span class="unitTxt">FacebookのURLを記入してください</span>
                </p>
            </td>
        </tr>
        <tr>
            <th>店舗URL <span class="require">※</span></th>
            <td>
                @if ('admin.lixil.shop.new' === \Route::currentRouteName())
                    <p>https://www.lixil-sashdoor.jp/mitsumori-system/shop/【都道府県】/{!! Form::text(
                        config('const.db.shops.SHOP_CODE'),
                        null,
                        [
                            'id' => null,
                            'class' => 'w200',
                        ]
                    ) !!}</p>
                    <p class="errMsg">{{ $errors->first(config('const.db.shops.SHOP_CODE')) }}</p>
                    <p class="note">スタンダード店のURLとなります。店名にちなんだ文字を半角英数で入力してください。<br>変更は出来ませんのでご注意ください。
                    </p>

                @elseif ('admin.lixil.shop.edit' === \Route::currentRouteName())
                    <p>
                        @if($shop->pref !== null)
                            https://www.lixil-sashdoor.jp/mitsumori-system/shop/{{ $shop->pref->{config('const.db.prefs.CODE')} }}/{{ $shop->{config('const.db.shops.SHOP_CODE')} }}
                        @else
                            https://www.lixil-sashdoor.jp/mitsumori-system/shop/{{ $shop->prefCode }}/{{ $shop->{config('const.db.shops.SHOP_CODE')} }}
                        @endif
                    </p>
                @endif
            </td>
        </tr>
        <tr>
            <th>見積りシミュレーション</th>
            <td>
                <ul class="radioList">
                    <li>
                        {!! Form::hidden(config('const.db.shops.CAN_SIMULATE'), '0') !!}
                        {!! Form::checkbox(config('const.db.shops.CAN_SIMULATE'), '1', null, [
                            'id' => config('const.db.shops.CAN_SIMULATE')
                        ]) !!}
                        {!! Form::label(config('const.db.shops.CAN_SIMULATE'), '利用する', [
                            'id' => null,
                            'class' => null,
                        ]) !!}
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <th>スタンダード店<br>公開ステータス</th>
            <td>
                <ul class="radioList">
                    @foreach (config('const.form.admin.lixil.shop.STANDARD_PUBLISH_STATUS') as $value => $label)
                        <li>
                        {!! Form::radio(
                            config('const.db.shops.STANDARD_SHOP_PUBLISH_STATUS'),
                            (string)$value,
                            null,
                            [
                                'id' => config('const.db.shops.STANDARD_SHOP_PUBLISH_STATUS') . '_' . $value,
                            ]
                        ) !!}
                        {!! Form::label(
                            config('const.db.shops.STANDARD_SHOP_PUBLISH_STATUS') . '_' . $value,
                            $label,
                            [
                                'id' => null,
                                'class' => null,
                            ]
                        ) !!}
                        </li>
                    @endforeach
                </ul>
            </td>
        </tr>
        <tr>
            <th>ログインID</th>
            <td>
                <p>
                    @if ('admin.lixil.shop.new' === \Route::currentRouteName())
                        登録完了時に自動生成されます
                    @elseif ('admin.lixil.shop.edit' === \Route::currentRouteName())
                        {{ $shop->user->{config('const.db.users.LOGIN_ID')} }}
                    @endif
                </p>
            </td>
        </tr>
        <tr>
            <th>パスワード</th>
            <td>
                <p>
                    @if ('admin.lixil.shop.new' === \Route::currentRouteName())
                        登録完了時に自動生成されます
                    @elseif ('admin.lixil.shop.edit' === \Route::currentRouteName())
                        {{ $shop->user->getDecryptedPassword() }}
                    @endif
                </p>
            </td>
        </tr>
    </table>
    <hr>

    <h1 class="mainTtl">プレミアム店舗 追加情報</h1>
    <p class="note">プレミアム店舗を登録する場合は、以下の項目に記入が必要となります</p>
    <table class="formTbl">
        <tr>
            <th>プレミアムサイトURL</th>
            <td>
                <p>https://
                    {!! Form::text(
                        config('const.db.shops.PREMIUM_SHOP_DOMAIN'),
                        null,
                        [
                            'id' => null,
                            'class' => 'w400',
                        ]
                    ) !!}
                </p>
                <p class="errMsg">{{ $errors->first(config('const.db.shops.PREMIUM_SHOP_DOMAIN')) }}</p>
                <p class="note">（例）https://www.sampleurl.jp<br>プレミアムサイトURLは、（株）シスコムで取得、入力します。</p>
            </td>
        </tr>
        <tr>
            <th>プレミアム店サイト<br>公開ステータス</th>
            <td>
                <ul class="radioList">
                    @foreach (config('const.form.admin.lixil.shop.PREMIUM_PUBLISH_FLG') as $value => $label)
                        <li>
                        {!! Form::radio(
                            config('const.db.shops.IS_PUBLISHED_PREMIUM'),
                            (string)$value,
                            null,
                            [
                                'id' => config('const.db.shops.IS_PUBLISHED_PREMIUM') . '_' . $value,
                            ]
                        ) !!}
                        {!! Form::label(
                            config('const.db.shops.IS_PUBLISHED_PREMIUM') . '_' . $value,
                            $label,
                            [
                                'id' => null,
                                'class' => null,
                            ]
                        ) !!}
                        </li>
                    @endforeach
                    <p class="errMsg">{{ $errors->first(config('const.db.shops.IS_PUBLISHED_PREMIUM')) }}</p>
                </ul>
            </td>
        </tr>
    </table>
    </div>
    <div class="btnBlock">
        <p><a href="{{ route('admin.lixil.shop') }}" class="button _back">戻る</a></p>
        <p><button type="submit" class="button _submit">入力内容の確認</button></p>
    </div>
    {!! Form::close() !!}
</main>
@endsection

@section('script')
    @parent

    {{-- timepicker --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script type="text/javascript">
        flatpickr('#timepicker', {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            defaultHour: 0,
            defaultMinute: 0,
        });
    </script>
@endsection
