@extends('mado.admin.shop.template')

@if('admin.shop.photo.new' === \Route::currentRouteName())
    @section('title', '施工事例新規登録｜LIXIL簡易見積りシステム')
@elseif('admin.shop.photo.edit' === \Route::currentRouteName())
    @section('title', '施工事例編集｜LIXIL簡易見積りシステム')
@endif

@section('main')
<main class="common">
    <h1 class="mainTtl">
        @if('admin.shop.photo.new' === \Route::currentRouteName())
            施工事例新規登録
        @elseif('admin.shop.photo.edit' === \Route::currentRouteName())
            施工事例編集
        @endif
    </h1>
    <p class="mb30">施工事例登録は、開口部リフォーム専門店として、窓・ドア・エクステリアの写真を中心に掲載しましょう！</p>
    <p class="note"><span class="require">※</span>は必須項目となります</p>

    @if ('admin.shop.photo.new' === \Route::currentRouteName())
        {!! Form::model($standardPhoto, [
            'route' => ['admin.shop.photo.confirm', 'shop_id' => $standardPhoto->{config('const.db.standard_photos.SHOP_ID')}],
            'enctype' => 'multipart/form-data',
        ]) !!}

    @elseif ('admin.shop.photo.edit' === \Route::currentRouteName())
        {!! Form::model($standardPhoto, [
            'route' => ['admin.shop.photo.edit.confirm', 'shop_id' => $standardPhoto->{config('const.db.standard_photos.SHOP_ID')}, 'photo_id' => $standardPhoto->{config('const.db.standard_photos.ID')}],
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif
        <div id="message-length">

        <table class="formTbl">
            <tr>
                <th>タイトル <span class="require">※</span></th>
                <td>
                    <p>
                        {!! Form::text(
                            config('const.db.standard_photos.TITLE'),
                            null,
                            [
                                'id' => null,
                                'class' => null,
                                'v-model' => 'message',
                                'v-init:message' => old(config('const.db.standard_photos.TITLE'))
                                    ? "'" . old(config('const.db.standard_photos.TITLE')) . "'"
                                    : "'" . $standardPhoto->{config('const.db.standard_photos.TITLE')} . "'",
                            ]
                        ) !!}
                    </p>
                    <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.TITLE')) }}</p>
                    <p class="note">{{ config('const.form.admin.shop.standard_photo.TITLE_MAX_LENGTH') }}文字以内：現@{{ messageLength }}文字</p>
                </td>
            </tr>
            <tr>
                <th>概要 <span class="require">※</span></th>
                <td>
                    <p>
                        {!! Form::textarea(
                            config('const.db.standard_photos.SUMMARY'),
                            null,
                            [
                                'id' => null,
                                'class' => null,
                                'rows' => 2,
                                'v-model' => 'message2',
                                'v-init:message2' => old(config('const.db.standard_photos.SUMMARY'))
                                    ? "'" . old(config('const.db.standard_photos.SUMMARY')) . "'"
                                    : "'" . $standardPhoto->{config('const.db.standard_photos.SUMMARY')} . "'",
                            ]
                        ) !!}
                    </p>
                    <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.SUMMARY')) }}</p>
                    <p class="note">{{ config('const.form.admin.shop.standard_photo.SUMMARY_MAX_LENGTH') }}文字以内：現@{{ message2Length }}文字</p>
                </td>
            </tr>
            <tr>
                <th>メイン写真 <span class="require">※</span></th>
                <td>
                    <p>
                        <file-upload name="{{ config('const.form.admin.shop.standard_photo.MAIN_PICTURE') }}" image="{{ $mainPicture !== null ? "{$mainPicture}" : null }}" image-cls="shopPhoto"></file-upload>
                    </p>
                    <p class="errMsg">{{ $errors->first(config('const.form.admin.shop.standard_photo.MAIN_PICTURE')) }}</p>
                </td>
            </tr>
            <tr>
                <th>本文 <span class="require">※</span></th>
                <td>
                    <p>
                        {!! Form::textarea(
                            config('const.db.standard_photos.MAIN_TEXT'),
                            null,
                            [
                                'id' => null,
                                'class' => null,
                                'rows' => 10,
                            ]
                        ) !!}
                    </p>
                    <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.MAIN_TEXT')) }}</p>
                </td>
            </tr>
            <tr>
                <th>建物種別 <span class="require">※</span></th>
                <td>
                    <ul class="radioList">
                        @foreach (config('const.form.admin.shop.standard_photo.CATEGORY') as $value => $label)
                        <li>
                        {!! Form::radio(
                            config('const.db.standard_photos.CATEGORY'),
                            (string)$value,
                            null,
                            [
                                'id' => config('const.db.standard_photos.CATEGORY') . '_' . $value,
                            ]
                        ) !!}
                        {!! Form::label(
                            config('const.db.standard_photos.CATEGORY') . '_' . $value,
                            $label,
                            [
                                'id' => null,
                                'class' => null,
                            ]
                        ) !!}
                        </li>
                        @endforeach
                    </ul>
                    <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.CATEGORY')) }}</p>
                </td>
            </tr>
            <tr>
                <th>住宅の築年数 <span class="require">※</span></th>
                <td>
                    <ul class="radioList">
                        @foreach (config('const.form.admin.shop.standard_photo.BUILT_YEAR') as $value => $label)
                        <li>
                        {!! Form::radio(
                            config('const.db.standard_photos.BUILT_YEAR'),
                            (string)$value,
                            null,
                            [
                                'id' => config('const.db.standard_photos.BUILT_YEAR') . '_' . $value,
                            ]
                        ) !!}
                        {!! Form::label(
                            config('const.db.standard_photos.BUILT_YEAR') . '_' . $value,
                            $label,
                            [
                                'id' => null,
                                'class' => null,
                            ]
                        ) !!}
                        </li>
                        @endforeach
                    </ul>
                    <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.BUILT_YEAR')) }}</p>
                </td>
            </tr>
            <tr>
                <th>リフォーム箇所 <span class="require">※</span></th>
                <td>
                    <ul class="radioList">
                        @foreach (config('const.form.admin.shop.standard_photo.PARTS') as $value => $label)
                        <li>
                        {!! Form::checkbox(
                            config('const.db.standard_photos.PARTS') . '[]',
                            (string)$value,
                            null,
                            // in_array(json_decode($standardPhoto->parts), (string)$value),
                            [
                                'id' => config('const.db.standard_photos.PARTS') . '_' . $value,
                            ]
                        ) !!}
                        {!! Form::label(
                            config('const.db.standard_photos.PARTS') . '_' . $value,
                            $label,
                            [
                                'id' => null,
                                'class' => null,
                            ]
                        ) !!}
                        </li>
                        @endforeach
                    </ul>
                    <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.PARTS')) }}</p>
                </td>
            </tr>
            <tr>
                <th>採用商品 <span class="require">※</span></th>
                <td>
                    <p>
                        {!! Form::text(
                            config('const.db.standard_photos.PRODUCT'),
                            null,
                            [
                                'id' => null,
                                'class' => null,
                                'placeholder' => 'ご採用商品名をご記入ください。複数の場合は「、」でつないでください。',
                            ]
                        ) !!}
                    </p>
                    <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.PRODUCT')) }}</p>
                </td>
            </tr>
            <tr>
                <th>予算</th>
                <td>
                    <p>
                        {!! Form::text(
                            config('const.db.standard_photos.BUDGET'),
                            null,
                            [
                                'id' => null,
                                'class' => 'w300',
                                'placeholder' => 'ご予算をご記入ください。（単位：万円）',
                            ]
                        ) !!}
                        <span class="unitTxt">万円</span>
                    </p>
                    <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.BUDGET')) }}</p>
                </td>
            </tr>
            <tr>
                <th>工期 <span class="require">※</span></th>
                <td>
                    <p>
                        {!! Form::text(
                            config('const.db.standard_photos.PERIOD'),
                            null,
                            [
                                'id' => null,
                                'class' => 'w400',
                                'placeholder' => '施工期間をご記入ください。最大20文字',
                            ]
                        ) !!}
                    </p>
                    <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.PERIOD')) }}</p>
                </td>
            </tr>
            <tr>
                <th>地域 <span class="require">※</span></th>
                <td>
                    <p>
                        {!! Form::text(
                            config('const.db.standard_photos.LOCALE'),
                            null,
                            [
                                'id' => null,
                                'class' => 'w400',
                                'placeholder' => '○○県 ○○市 最大20文字',
                            ]
                        ) !!}
                    </p>
                    <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.LOCALE')) }}</p>
                </td>
            </tr>
            <tr>
                <th>リフォーム理由 <span class="require">※</span></th>
                <td>
                    <ul class="radioList">
                        @foreach (config('const.form.admin.shop.standard_photo.REASON') as $value => $label)
                        <li>
                        {!! Form::checkbox(
                            config('const.db.standard_photos.REASON') . '[]',
                            (string)$value,
                            null,
                            [
                                'id' => config('const.db.standard_photos.REASON') . '_' . $value,
                            ]
                        ) !!}
                        {!! Form::label(
                            config('const.db.standard_photos.REASON') . '_' . $value,
                            $label,
                            [
                                'id' => null,
                                'class' => null,
                            ]
                        ) !!}
                        </li>
                        @endforeach
                    </ul>
                    <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.REASON')) }}</p>
                </td>
            </tr>
            <tr>
                <th>カテゴリー <span class="require">※</span></th>
                <td>
                    <ul class="radioList">
                        @foreach (config('const.form.admin.shop.standard_photo.CATEGORY_FOR_SEARCH') as $value => $label)
                        <li>
                        {!! Form::checkbox(
                            config('const.db.standard_photos.CATEGORY_FOR_SEARCH') . '[]',
                            (string)$value,
                            null,
                            [
                                'id' => config('const.db.standard_photos.CATEGORY_FOR_SEARCH') . '_' . $value,
                            ]
                        ) !!}
                        {!! Form::label(
                            config('const.db.standard_photos.CATEGORY_FOR_SEARCH') . '_' . $value,
                            $label,
                            [
                                'id' => null,
                                'class' => null,
                            ]
                        ) !!}
                        </li>
                        @endforeach
                    </ul>
                    <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.CATEGORY_FOR_SEARCH')) }}</p>
                </td>
            </tr>
        </table>


        <section class="registSec _family">
            <h2>ご家族構成</h2>
            <div class="registSecInr">
                <table class="formTbl">
                    <tr>
                        <th>お施主のご年齢</th>
                        <td>
                            <ul class="radioList">
                                @foreach (config('const.form.admin.shop.standard_photo.CLIENT_AGE') as $value => $label)
                                <li>
                                {!! Form::radio(
                                    config('const.db.standard_photos.CLIENT_AGE'),
                                    (string)$value,
                                    null,
                                    [
                                        'id' => config('const.db.standard_photos.CLIENT_AGE') . '_' . $value,
                                    ]
                                ) !!}
                                {!! Form::label(
                                    config('const.db.standard_photos.CLIENT_AGE') . '_' . $value,
                                    $label,
                                    [
                                        'id' => null,
                                        'class' => null,
                                    ]
                                ) !!}
                                </li>
                                @endforeach
                            </ul>
                            <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.CLIENT_AGE')) }}</p>
                            <p class="note">※「なし」を選択した場合は、表示されません。</p>
                        </td>
                    </tr>
                    <tr>
                        <th>世帯</th>
                        <td>
                            <ul class="radioList">
                                @foreach (config('const.form.admin.shop.standard_photo.HOUSEHOLD') as $value => $label)
                                <li>
                                {!! Form::radio(
                                    config('const.db.standard_photos.HOUSEHOLD'),
                                    (string)$value,
                                    null,
                                    [
                                        'id' => config('const.db.standard_photos.HOUSEHOLD') . '_' . $value,
                                    ]
                                ) !!}
                                {!! Form::label(
                                    config('const.db.standard_photos.HOUSEHOLD') . '_' . $value,
                                    $label,
                                    [
                                        'id' => null,
                                        'class' => null,
                                    ]
                                ) !!}
                                </li>
                                @endforeach
                            </ul>
                            <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.HOUSEHOLD')) }}</p>
                            <p class="note">※「なし」を選択した場合は、表示されません。</p>
                        </td>
                    </tr>
                    <tr>
                        <th>お子さま</th>
                        <td>
                            <ul class="radioList">
                                @foreach (config('const.form.admin.shop.standard_photo.CHILD') as $value => $label)
                                <li>
                                {!! Form::radio(
                                    config('const.db.standard_photos.CHILD'),
                                    (string)$value,
                                    null,
                                    [
                                        'id' => config('const.db.standard_photos.CHILD') . '_' . $value,
                                    ]
                                ) !!}
                                {!! Form::label(
                                    config('const.db.standard_photos.CHILD') . '_' . $value,
                                    $label,
                                    [
                                        'id' => null,
                                        'class' => null,
                                    ]
                                ) !!}
                                </li>
                                @endforeach
                            </ul>
                            <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.CHILD')) }}</p>
                            <p class="note">※「なし」を選択した場合は、表示されません。</p>
                        </td>
                    </tr>
                    <tr>
                        <th>ペット</th>
                        <td>
                            <ul class="radioList">
                                <input type="hidden" name="{!! config('const.db.standard_photos.PET') !!}" value>
                                @foreach (config('const.form.admin.shop.standard_photo.PET') as $value => $label)
                                <li>
                                {!! Form::checkbox(
                                    config('const.db.standard_photos.PET') . '[]',
                                    (string)$value,
                                    null,
                                    [
                                        'id' => config('const.db.standard_photos.PET') . '_' . $value,
                                    ]
                                ) !!}
                                {!! Form::label(
                                    config('const.db.standard_photos.PET') . '_' . $value,
                                    $label,
                                    [
                                        'id' => null,
                                        'class' => null,
                                    ]
                                ) !!}
                                </li>
                                @endforeach
                            </ul>
                            <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.PET')) }}</p>
                        </td>
                    </tr>
                </table>
            </div>
        </section>

        <section class="registSec _before">
            <h2>施工前</h2>
            <div class="registSecInr">
                <table class="formTbl">
                    <tr>
                        <th>テキスト <span class="require">※</span></th>
                        <td>
                            <p>

                                {!! Form::textarea(
                                    config('const.db.standard_photos.BEFORE_TEXT'),
                                    null,
                                    [
                                        'id' => null,
                                        'class' => null,
                                        'rows' => 10,
                                        'placeholder' => 'お客さまからお問い合わせをいただいた経緯やリフォームのニーズ・エピソード等をわかりやすいコメントで掲載しましょう！',
                                    ]
                                ) !!}
                            </p>
                            <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.BEFORE_TEXT')) }}</p>
                        </td>
                    </tr>
                    <tr>
                        <th>写真1 <span class="require">※</span></th>
                        <td>
                            <p>
                                <file-upload name="{{ config('const.form.admin.shop.standard_photo.BEFORE_PICTURE') }}" image="{{ $beforePicture !== null ? "{$beforePicture}" : null }}" image-cls="shopPhoto"></file-upload>
                            </p>
                            <p class="errMsg">{{ $errors->first(config('const.form.admin.shop.standard_photo.BEFORE_PICTURE')) }}</p>
                        </td>
                    </tr>
                    <tr>
                        <th>写真2</th>
                        <td>
                            <p>
                                <file-upload name="{{ config('const.form.admin.shop.standard_photo.BEFORE_PICTURE_2') }}" image="{{ $beforePicture2 !== null ? "{$beforePicture2}" : null }}" image-cls="shopPhoto"></file-upload>
                            </p>
                            <p class="errMsg">{{ $errors->first(config('const.form.admin.shop.standard_photo.BEFORE_PICTURE_2')) }}</p>
                        </td>
                    </tr>
                    <tr>
                        <th>写真3</th>
                        <td>
                            <p>
                                <file-upload name="{{ config('const.form.admin.shop.standard_photo.BEFORE_PICTURE_3') }}" image="{{ $beforePicture3 !== null ? "{$beforePicture3}" : null }}" image-cls="shopPhoto"></file-upload>
                            </p>
                            <p class="errMsg">{{ $errors->first(config('const.form.admin.shop.standard_photo.BEFORE_PICTURE_3')) }}</p>
                        </td>
                    </tr>
                </table>
                <p class="voiceCheck">※写真1～3は、縦横の比率がなるべく同じ写真を挿入して下さい。</p>
            </div>
        </section>

        <section class="registSec _after">
            <h2>施工後</h2>
            <div class="registSecInr">
                <table class="formTbl">
                    <tr>
                        <th>テキスト <span class="require">※</span></th>
                        <td>
                            <p>
                                {!! Form::textarea(
                                    config('const.db.standard_photos.AFTER_TEXT'),
                                    null,
                                    [
                                        'id' => null,
                                        'class' => null,
                                        'rows' => 10,
                                        'placeholder' => 'お客さまのリフォームニーズに対して、どのような提案内容により、改善したのかをわかりやすいコメントで掲載しましょう！',
                                    ]
                                ) !!}
                            </p>
                            <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.AFTER_TEXT')) }}</p>
                        </td>
                    </tr>
                    <tr>
                        <th>写真1 <span class="require">※</span></th>
                        <td>
                            <p>
                                <file-upload name="{{ config('const.form.admin.shop.standard_photo.AFTER_PICTURE') }}" image="{{ $afterPicture !== null ? "{$afterPicture}" : null }}" image-cls="shopPhoto"></file-upload>
                            </p>
                            <p class="errMsg">{{ $errors->first(config('const.form.admin.shop.standard_photo.AFTER_PICTURE')) }}</p>
                        </td>
                    </tr>
                    <tr>
                        <th>写真2</th>
                        <td>
                            <p>
                                <file-upload name="{{ config('const.form.admin.shop.standard_photo.AFTER_PICTURE_2') }}" image="{{ $afterPicture2 !== null ? "{$afterPicture2}" : null }}" image-cls="shopPhoto"></file-upload>
                            </p>
                            <p class="errMsg">{{ $errors->first(config('const.form.admin.shop.standard_photo.AFTER_PICTURE_2')) }}</p>
                        </td>
                    </tr>
                    <tr>
                        <th>写真3</th>
                        <td>
                            <p>
                                <file-upload name="{{ config('const.form.admin.shop.standard_photo.AFTER_PICTURE_3') }}" image="{{ $afterPicture3 !== null ? "{$afterPicture3}" : null }}" image-cls="shopPhoto"></file-upload>
                            </p>
                            <p class="errMsg">{{ $errors->first(config('const.form.admin.shop.standard_photo.AFTER_PICTURE_3')) }}</p>
                        </td>
                    </tr>
                </table>
                <p class="voiceCheck">※写真1～3は、縦横の比率がなるべく同じ写真を挿入して下さい。</p>
            </div>
        </section>

        <section class="registSec _voice">
            <h2>お客さまの声</h2>
            <div class="registSecInr">
                <p class="voiceCheck">
                    {!! Form::hidden(config('const.db.standard_photos.IS_CUSTOMER_PUBLISH'), '0') !!}
                    {!! Form::checkbox(config('const.db.standard_photos.IS_CUSTOMER_PUBLISH'), '1', null, [
                            'id' => config('const.db.standard_photos.IS_CUSTOMER_PUBLISH')
                        ]) !!}
                    {!! Form::label(config('const.db.standard_photos.IS_CUSTOMER_PUBLISH'), 'お客さまの声を登録する', [
                        'id' => null,
                        'class' => null,
                    ]) !!}
                </p>
                <table class="formTbl">
                    <tr>
                        <th>テキスト1</th>
                        <td>
                            <p>
                                {!! Form::textarea(
                                    config('const.db.standard_photos.CUSTOMER_TEXT'),
                                    null,
                                    [
                                        'id' => null,
                                        'class' => null,
                                        'rows' => 10,
                                        'placeholder' => 'お客さまからいただいた言葉で、リフォームのきっかけとリフォーム後にどのように住まい方が変わったのかをわかりやすいコメントで掲載しましょう！',
                                    ]
                                ) !!}
                            </p>
                            <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.CUSTOMER_TEXT')) }}</p>
                        </td>
                    </tr>
                    <tr>
                        <th>写真1</th>
                        <td>
                            <p>
                                <file-upload name="{{ config('const.form.admin.shop.standard_photo.CUSTOMER_PICTURE') }}" image="{{ $customerPicture !== null ? "{$customerPicture}" : null }}" image-cls="shopPhoto"></file-upload>
                            </p>
                            <p class="errMsg">{{ $errors->first(config('const.form.admin.shop.standard_photo.CUSTOMER_PICTURE')) }}</p>
                        </td>
                    </tr>
                </table>
                <p class="voiceCheck">※ご家族・ペットの写真を添付することで、「お客さまの声」がより伝わりやすく、店舗の信頼性にもつながります。</p>

                <table class="formTbl">
                    <tr>
                        <th>テキスト2</th>
                        <td>
                            <p>
                                {!! Form::textarea(
                                    config('const.db.standard_photos.CUSTOMER_TEXT_2'),
                                    null,
                                    [
                                        'id' => null,
                                        'class' => null,
                                        'rows' => 10,
                                        'placeholder' => '「お客さまの声」や「お客さまアンケート」等に店舗からお礼のコメント等を記載しましょう！',
                                    ]
                                ) !!}
                            </p>
                            <p class="errMsg">{{ $errors->first(config('const.db.standard_photos.CUSTOMER_TEXT_2')) }}</p>
                        </td>
                    </tr>
                    <tr>
                        <th>写真2</th>
                        <td>
                            <p>
                                <file-upload name="{{ config('const.form.admin.shop.standard_photo.CUSTOMER_PICTURE_2') }}" image="{{ $customerPicture2 !== null ? "{$customerPicture2}" : null }}" image-cls="shopPhoto"></file-upload>
                            </p>
                            <p class="errMsg">{{ $errors->first(config('const.form.admin.shop.standard_photo.CUSTOMER_PICTURE_2')) }}</p>
                        </td>
                    </tr>
                </table>
                <p class="voiceCheck">※お客さまアンケート等を掲載することで、店舗のCS評価があがります。</p>
            </div>
        </section>

        <div class="btnBlock">
            <p>{!! Form::submit('入力内容の確認', ['class' => 'button _submit']) !!}</p>
        </div>

        </div>
    {!! Form::close() !!}
</main>
@endsection
