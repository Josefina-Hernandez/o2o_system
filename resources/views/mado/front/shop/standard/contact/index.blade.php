@extends('mado.front.shop.standard.template')

@section('title', "お問い合わせ｜{$shop->{config('const.db.shops.NAME')}}｜LIXIL簡易見積りシステム")
   @section('description', "LIXIL簡易見積りシステムサービス加盟店「{$shop->{config('const.db.shops.NAME')}}」のお問い合わせページです。")

@section('main')
<main id="mainArea" class="contact">
    @include('mado.front.shop.standard.parts.header')

    <article>
        @include ('mado.front.parts.breadcrumbs')
        <h1>お問い合わせ</h1>

        {!! Form::open([
            'route' => ['front.shop.standard.contact.confirm', 'pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')],
        ]) !!}
            <table class="contactTbl">
                <tbody>
                    <tr>
                        <th>お名前（全角）</th>
                        <td class="require"><span>必須</span></td>
                        <td>
                            <div class="inputBlock">
                                <p class="inputName">
                                    {!! Form::text(
                                        config('const.form.front.standard.contact.NAME1'),
                                        old(config('const.form.front.standard.contact.NAME1'), null), [
                                            'id' => null,
                                            'class' => null,
                                            'placeholder' => '山田',
                                            'required' => '',
                                        ]
                                    ) !!}
                                </p>
                                <p class="inputName">
                                    {!! Form::text(
                                        config('const.form.front.standard.contact.NAME2'),
                                        old(config('const.form.front.standard.contact.NAME2'), null), [
                                            'id' => null,
                                            'class' => null,
                                            'placeholder' => '太郎',
                                            'required' => '',
                                        ]
                                    ) !!}
                                </p>
                            </div>
                            <p class="errMsg">{{ $errors->first(config('const.form.front.standard.contact.NAME1')) }}</p>
                            <p class="errMsg">{{ $errors->first(config('const.form.front.standard.contact.NAME2')) }}</p>
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>フリガナ（全角）</th>
                        <td class="require"><span>必須</span></td>
                        <td>
                            <div class="inputBlock">
                                <p class="inputName">
                                    {!! Form::text(
                                        config('const.form.front.standard.contact.KANA1'),
                                        old(config('const.form.front.standard.contact.KANA1'), null), [
                                            'id' => null,
                                            'class' => null,
                                            'placeholder' => 'ヤマダ',
                                            'required' => '',
                                        ]
                                    ) !!}
                                </p>
                                <p class="inputName">
                                    {!! Form::text(
                                        config('const.form.front.standard.contact.KANA2'),
                                        old(config('const.form.front.standard.contact.KANA2'), null), [
                                            'id' => null,
                                            'class' => null,
                                            'placeholder' => 'タロウ',
                                            'required' => '',
                                        ]
                                    ) !!}
                                </p>
                            </div>
                            <p class="errMsg">{{ $errors->first(config('const.form.front.standard.contact.KANA1')) }}</p>
                            <p class="errMsg">{{ $errors->first(config('const.form.front.standard.contact.KANA2')) }}</p>
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>ご連絡方法</th>
                        <td class="require"><span>必須</span></td>
                        <td>
                            <ul class="radioList">
                                @foreach (config('const.form.front.standard.contact.CONTACT_WAY_LIST') as $value => $label)
                                    <li>
                                    {!! Form::radio(
                                        config('const.form.front.standard.contact.CONTACT_WAY'),
                                        (string)$value,
                                        null,
                                        [
                                            'id' => config('const.form.front.standard.contact.CONTACT_WAY') . '_' . $value,
                                        ]
                                    ) !!}
                                    {!! Form::label(
                                        config('const.form.front.standard.contact.CONTACT_WAY') . '_' . $value,
                                        $label,
                                        [
                                            'id' => null,
                                            'class' => null,
                                        ]
                                    ) !!}
                                    </li>
                                @endforeach
                            </ul>
                            <p class="errMsg">{{ $errors->first(config('const.form.front.standard.contact.CONTACT_WAY')) }}</p>
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>メールアドレス</th>
                        <td class="require"><span>必須</span></td>
                        <td>
                            <div class="inputBlock">
                                <p>
                                    {!! Form::email(
                                        config('const.form.front.standard.contact.EMAIL'),
                                        old(config('const.form.front.standard.contact.EMAIL'), null), [
                                            'id' => null,
                                            'class' => null,
                                            'placeholder' => 'sample@madohonpo.jp',
                                            'required' => '',
                                        ]
                                    ) !!}
                                </p>
                            </div>
                            <p class="errMsg">{{ $errors->first(config('const.form.front.standard.contact.EMAIL')) }}</p>
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>電話番号</th>
                        <td class="require"><span>必須</span></td>
                        <td>
                            <div class="inputBlock">
                                <p>
                                    {!! Form::tel(
                                        config('const.form.front.standard.contact.TEL'),
                                        old(config('const.form.front.standard.contact.TEL'), null), [
                                            'id' => null,
                                            'class' => null,
                                            'placeholder' => '00-0000-0000',
                                            'required' => '',
                                        ]
                                    ) !!}
                                </p>
                            </div>
                            <p class="errMsg">{{ $errors->first(config('const.form.front.standard.contact.TEL')) }}</p>
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>リフォーム先の住所</th>
                        <td class="require _top"><span>必須</span></td>
                        <td>
                            <div class="inputBlock">
                                <p>
                                    {!! Form::text(
                                        config('const.form.front.standard.contact.ADDRESS'),
                                        old(config('const.form.front.standard.contact.ADDRESS'), null), [
                                            'id' => null,
                                            'class' => null,
                                            'placeholder' => '東京都千代田区',
                                            'required' => '',
                                        ]
                                    ) !!}
                                </p>
                            </div>
                            <p class="errMsg">{{ $errors->first(config('const.form.front.standard.contact.ADDRESS')) }}</p>
                            <p class="note">※リフォーム先の地域を都道府県と市区町村までご記入ください。</p>
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>お問い合わせ内容</th>
                        <td class="require"><span>必須</span></td>
                        <td>
                            <ul class="radioList">
                                @foreach (config('const.form.front.standard.contact.CONTACT_CATEGORY_LIST') as $value => $label)
                                    <li>
                                    {!! Form::radio(
                                        config('const.form.front.standard.contact.CONTACT_CATEGORY'),
                                        (string)$value,
                                        null,
                                        [
                                            'id' => config('const.form.front.standard.contact.CONTACT_CATEGORY') . '_' . $value,
                                            (isset($estimate_data) && is_array($estimate_data) && ($label === 'お見積り')) ? 'checked'  : '' //Add Estimate Thanh 20190507

                                        ]
                                    ) !!}
                                    {!! Form::label(
                                        config('const.form.front.standard.contact.CONTACT_CATEGORY') . '_' . $value,
                                        $label,
                                        [
                                            'id' => null,
                                            'class' => null,
                                        ]
                                    ) !!}
                                    </li>
                                @endforeach
                            </ul>
                            <p class="errMsg">{{ $errors->first(config('const.form.front.standard.contact.CONTACT_CATEGORY')) }}</p>
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>ご相談内容を詳しくご入力ください</th>
                        <td class="require _top"><span>必須</span></td>
                        <td>
                            {!! Form::textarea(
                                config('const.form.front.standard.contact.CONTACT_TEXT'),
                                //Add Start Estimate Thanh 20190507
                                (isset($estimate_data) && is_array($estimate_data)) ?
                                     $estimate_data['content_mail'] :
                                //End Estimate Thanh 20190507
                                     old(config('const.form.front.standard.contact.CONTACT_TEXT'),
                                ''), [
                                    'id' => null,
                                    'class' => null,
                                    'placeholder' => 'リフォームのご希望場所（リビング／キッチン／トイレなど、建物種別（一戸建て／マンション）、ご要望、出張ご希望日時（ご希望に添えない場合がございますので、いくつかご入力ください）などをご入力ください。',
                                ]
                            ) !!}
                            {!! Form::hidden('e_data_type', $e_data_type) !!} {{--  //Add Estimate Thanh 20190507 --}}
                            <p class="errMsg">{{ $errors->first(config('const.form.front.standard.contact.CONTACT_TEXT')) }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <section class="privacySec">
                <h2>プライバシーポリシー</h2>
                <div class="privacyBox">
                    @include ('mado.static.contact_privacy_policy')
                </div>
            </section>

            <p class="confirmTxt">
            {{ Form::checkbox(
                config("const.form.front.contact.CONTACT_PRIVACY") ,
                1,
                null,[
                    'required'=>''
                ])
            }}
                LIXILの<a href="{{ route('front.privacy') }}" target="_blank">プライバシーポリシー</a>に同意の上、確認画面にお進みください。</p>
                <p class="errMsg">{{ $errors->first(config('const.form.front.standard.contact.CONTACT_PRIVACY')) }}</p>
            <div class="btnBlock">
                <button type="submit" class="submitBtn"><i class="fas fa-arrow-circle-right"></i>上記に同意して確認画面に進む</button>
            </div>
        </form>
    </article>
</main>
@endsection
