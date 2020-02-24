@extends('mado.admin.shop.template')

@section('title', '会社情報管理確認｜LIXIL簡易見積りシステム')

@section('main')
<main class="common">
    <h1 class="mainTtl">会社情報管理確認</h1>
    <p class="note"><span class="require">※</span>は必須項目となります</p>

    <div id="confirm-complete">
    {!! Form::model($shop, [
        'route' => ['admin.shop.edit', 'shop_id' => $shop->{config('const.db.shops.ID')}],
        'enctype' => 'multipart/form-data',
        'v-on:submit.prevent' => 'onSubmit',
    ]) !!}

    <table class="formTbl">
        <tr>
            <th>法人名 <span class="require">※</span></th>
            <td>
                <p>{{ $shop->{config('const.db.shops.COMPANY_NAME')} }}</p>
            </td>
        </tr>
        <tr>
            <th>法人名（カナ） <span class="require">※</span></th>
            <td>
                <p>{{ $shop->{config('const.db.shops.COMPANY_NAME_KANA')} }}</p>
            </td>
        </tr>
        <tr>
            <th>店名 <span class="require">※</span></th>
            <td>
                <p>{{ $shop->{config('const.db.shops.NAME')} }}</p>
            </td>
        </tr>
        <tr>
            <th>店名（カナ） <span class="require">※</span></th>
            <td>
                <p>{{ $shop->{config('const.db.shops.KANA')} }}</p>
            </td>
        </tr>
        <tr>
            <th>タイプ {{--<span class="require">※</span>--}}</th>
            <td>
                <p>
                    {{ ($shop->{config('const.db.shops.SHOP_TYPE')} == config('settings.shop_type.cainz'))? 'カインズ': null}}
                </p>
            </td>
        </tr>
        {{--
        <tr>
            <th>店舗写真</th>
            <td>
                <p>
                    @isset ($mainPicture)
                        <img src="{{ $mainPicture }}" class="shopPhoto">
                    @endisset
                </p>
            </td>
        </tr>
        <tr>
            <th>店舗からのメッセージ</th>
            <td>
                <p>{!! nl2br($shop->{config('const.db.shops.MESSAGE')}, false) !!}</p>
            </td>
        </tr>
        <tr>
            <th>施工事例</th>
            <td>
                <p>{!! nl2br($shop->{config('const.db.shops.PHOTO_SUMMARY')}, false) !!}</p>
            </td>
        </tr>
        <tr>
            <th>代表者名</th>
            <td>
                <p>{{ $shop->{config('const.db.shops.PRESIDENT_NAME')} }}</p>
            </td>
        </tr>
        <tr>
            <th>担当者名</th>
            <td>
                <p>{{ $shop->{config('const.db.shops.PERSONNEL_NAME')} }}</p>
            </td>
        </tr>
        --}}
        <tr>
            <th>郵便番号 <span class="require">※</span></th>
            <td>
                <p>{{ $shop->{config('const.db.shops.ZIP1')} }}-{{ $shop->{config('const.db.shops.ZIP2')} }}</p>
            </td>
        </tr>
        <tr>
            <th>都道府県 <span class="require">※</span></th>
            <td>
                <p>{{ $shop->pref->{config('const.db.prefs.NAME')} }}</p>
            </td>
        </tr>
        <tr>
            <th>市区町村 <span class="require">※</span></th>
            <td>
                <p>{{ $shop->city->{config('const.db.cities.NAME')} }}</p>
            </td>
        </tr>
        <tr>
            <th>町名・番地 <span class="require">※</span></th>
            <td>
                <p>{{ $shop->{config('const.db.shops.STREET')} }}</p>
            </td>
        </tr>
        {{--
        <tr>
            <th>ビル名</th>
            <td>
                <p>{{ $shop->{config('const.db.shops.BUILDING')} }}</p>
            </td>
        </tr>
        <tr>
            <th>対応エリア</th>
            <td>
                <p>{{ $shop->{config('const.db.shops.SUPPORT_AREA')} }}</p>
            </td>
        </tr>
        --}}
        <tr>
            <th>電話番号 <span class="require">※</span></th>
            <td>
                <p>{{ $shop->{config('const.db.shops.TEL')} }}</p>
            </td>
        </tr>
        <tr>
            <th>FAX番号 <span class="require">※</span></th>
            <td>
                <p>{{ $shop->{config('const.db.shops.FAX')} }}</p>
            </td>
        </tr>
        <tr>
            <th>メールアドレス <span class="require">※</span></th>
            <td>
                <p>{{ $shop->{config('const.db.shops.EMAIL')} }}</p>
            </td>
        </tr>
        {{--
        <tr>
            <th>営業時間 <span class="require">※</span></th>
            <td>
                <p>{{ $shop->{config('const.db.shops.OPEN_TIME')} }}～{{ $shop->{config('const.db.shops.CLOSE_TIME')} }}</p>
            </td>
        </tr>
        <tr>
            <th>営業時間補足</th>
            <td>
                <p>{{ $shop->{config('const.db.shops.OTHER_TIME')} }}</p>
            </td>
        </tr>
        <tr>
            <th>定休日 <span class="require">※</span></th>
            <td>
                <p>{{ $shop->{config('const.db.shops.NORMALLY_CLOSE_DAY')} }}</p>
            </td>
        </tr>
        <tr>
            <th>取扱施工内容 <span class="require">※</span></th>
            <td>
                <p>{{ $shop->concatSupportDetails() }}</p>
            </td>
        </tr>
        <tr>
            <th>資格</th>
            <td>
                <p>{!! nl2br($shop->{config('const.db.shops.CERTIFICATE')}, false) !!}</p>
            </td>
        </tr>
        <tr>
            <th>ホームページURL</th>
            <td>
                <p>{{ $shop->{config('const.db.shops.SITE_URL')} }}</p>
            </td>
        </tr>
        <tr>
            <th>資本金</th>
            <td>
                <p>{{ $shop->{config('const.db.shops.CAPITAL')} }}万円</p>
            </td>
        </tr>
        <tr>
            <th>創業</th>
            <td>
                <p>{{ $shop->{config('const.db.shops.COMPANY_START')} }}年</p>
            </td>
        </tr>
        <tr>
            <th>沿革</th>
            <td>
                <p>{!! nl2br($shop->{config('const.db.shops.COMPANY_HISTORY')}, false) !!}</p>
            </td>
        </tr>
        <tr>
            <th>許可登録番号</th>
            <td>
                <p>{!! nl2br($shop->{config('const.db.shops.LICENSE')}, false) !!}</p>
            </td>
        </tr>
        <tr>
            <th>従業員数</th>
            <td>
                <p>{{ $shop->{config('const.db.shops.EMPLOYEE_NUMBER')} }}人</p>
            </td>
        </tr>
        <tr>
            <th>Twitter</th>
            <td>
                <p>
                    @isset ($shop->{config('const.db.shops.TWITTER')})
                        <a href="https://twitter.com/{{ $shop->{config('const.db.shops.TWITTER')} }}" target="_blank">https://twitter.com/{{ $shop->{config('const.db.shops.TWITTER')} }}</a>
                    @endisset
                </p>
            </td>
        </tr>
        <tr>
            <th>Facebook</th>
            <td>
                <p>
                    @isset ($shop->{config('const.db.shops.TWITTER')})
                        <a href="https://www.facebook.com/{{ $shop->{config('const.db.shops.FACEBOOK')} }}" target="_blank">https://www.facebook.com/{{ $shop->{config('const.db.shops.FACEBOOK')} }}</a>
                    @endisset
                </p>
            </td>
        </tr>
        --}}

        {{--Add Start Estimate Thanh 20191125--}}
        @if (HelpersCart::is_general_site()) {{--only display site generate--}}
        <tr>
            <th>現在のパスワード </th>
            <td>
                <p>
                    {{$data_user['password']}}
                </p>
            </td>
        </tr>
        <tr>
            <th>新しいパスワード </th>
            <td>
                <p>
                    {{$data_user['password_new']}}
                </p>
            </td>
        </tr>
        <tr>
            <th>パスワード確認 </th>
            <td>
                <p>
                    {{$data_user['password_confirm']}}
                </p>
            </td>
        </tr>
        @endif
        {{--Add End Estimate Thanh 20191125--}}
    </table>

    {!! Form::hidden(config('const.db.shops.ID')) !!}
    {!! Form::hidden(config('const.db.shops.COMPANY_NAME')) !!}
    {!! Form::hidden(config('const.db.shops.COMPANY_NAME_KANA')) !!}
    {!! Form::hidden(config('const.db.shops.NAME')) !!}
    {!! Form::hidden(config('const.db.shops.KANA')) !!}
    {{-- {!! Form::hidden(config('const.db.shops.PRESIDENT_NAME')) !!} --}}
    {{-- {!! Form::hidden(config('const.db.shops.PERSONNEL_NAME')) !!} --}}
    {!! Form::hidden(config('const.db.shops.ZIP1')) !!}
    {!! Form::hidden(config('const.db.shops.ZIP2')) !!}
    {!! Form::hidden(config('const.db.shops.PREF_ID')) !!}
    {!! Form::hidden(config('const.db.shops.CITY_ID')) !!}
    {!! Form::hidden(config('const.db.shops.STREET')) !!}
    {{-- {!! Form::hidden(config('const.db.shops.BUILDING')) !!} --}}
    {{-- {!! Form::hidden(config('const.db.shops.SUPPORT_AREA')) !!} --}}
    {!! Form::hidden(config('const.db.shops.TEL')) !!}
    {!! Form::hidden(config('const.db.shops.FAX')) !!}
    {!! Form::hidden(config('const.db.shops.EMAIL')) !!}
    {{-- {!! Form::hidden(config('const.db.shops.OPEN_TIME')) !!} --}}
    {{-- {!! Form::hidden(config('const.db.shops.CLOSE_TIME')) !!} --}}
    {{-- {!! Form::hidden(config('const.db.shops.OTHER_TIME')) !!} --}}
    {{-- {!! Form::hidden(config('const.db.shops.NORMALLY_CLOSE_DAY')) !!} --}}
    {{-- {!! Form::hidden(config('const.db.shops.SUPPORT_DETAIL')) !!} --}}
    {{-- {!! Form::hidden(config('const.db.shops.CERTIFICATE')) !!} --}}
    {{-- {!! Form::hidden(config('const.db.shops.SITE_URL')) !!} --}}
    {{-- {!! Form::hidden(config('const.db.shops.CAPITAL')) !!} --}}
    {{-- {!! Form::hidden(config('const.db.shops.COMPANY_START')) !!} --}}
    {{-- {!! Form::hidden(config('const.db.shops.COMPANY_HISTORY')) !!} --}}
    {{-- {!! Form::hidden(config('const.db.shops.LICENSE')) !!} --}}
    {{-- {!! Form::hidden(config('const.db.shops.EMPLOYEE_NUMBER')) !!} --}}
    {{-- {!! Form::hidden(config('const.db.shops.MESSAGE')) !!} --}}
    {{-- {!! Form::hidden(config('const.db.shops.PHOTO_SUMMARY')) !!} --}}
    {{-- {!! Form::hidden(config('const.db.shops.TWITTER')) !!} --}}
    {{-- {!! Form::hidden(config('const.db.shops.FACEBOOK')) !!} --}}
    {{-- @foreach ($shop->{config('const.db.shops.SUPPORT_DETAIL_LIST')} as $supportDetail)
        <input type="hidden" name="{!! config('const.db.shops.SUPPORT_DETAIL_LIST') . '[]' !!}" value="{!! $supportDetail !!}">
    @endforeach --}}
        @if (HelpersCart::is_general_site()) {{--only display site generate--}}
        {!! Form::hidden('password') !!}
        {!! Form::hidden('password_new') !!}
        {!! Form::hidden('password_confirm') !!}
        @endif
        {!! Form::hidden('shop_type') !!}
    <div class="btnBlock">
        {!! Form::submit('修正', [
            'class' => 'button _back',
            'v-on:click' => 'onClick("' . route('admin.shop.edit', ['shop_id' => $shop->{config('const.db.shops.ID')}]) . '")',
        ]) !!}
        {!! Form::submit(($first_time_edit == true)?'登録とURL発':'更新', [
            'class' => 'button _submit',
            'v-on:click' => 'onClick("' . route('admin.shop.complete', ['shop_id' => $shop->{config('const.db.shops.ID')}]) . '")',
        ]) !!}
    </div>

    {!! Form::close() !!}
</main>
@endsection
