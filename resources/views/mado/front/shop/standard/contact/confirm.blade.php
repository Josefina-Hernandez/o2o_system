@extends('mado.front.shop.standard.template')

@section('title', "お問い合わせ確認｜{$shop->{config('const.db.shops.NAME')}}｜LIXIL簡易見積りシステム")
@section('description', "LIXIL簡易見積りシステムサービス加盟店「{$shop->{config('const.db.shops.NAME')}}」のお問い合わせ確認ページです。")

@section('main')
<main id="mainArea" class="contact _confirm">
    @include('mado.front.shop.standard.parts.header')

    <article>
        @include ('mado.front.parts.breadcrumbs')
        <h1>お問い合わせ確認</h1>

        <div id="confirm-complete">
        {!! Form::open([
            'route' => ['front.shop.standard.contact.confirm', 'pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')],
            'v-on:submit.prevent' => 'onSubmit',
        ]) !!}
            <table class="contactTbl">
                <tbody>
                    <tr>
                        <th>お名前（全角）</th>
                        <td>
                            <div class="inputBlock">
                                <p class="inputName">{{ $data[config('const.form.front.standard.contact.NAME1') ]}}</p>
                                <p class="inputName">{{ $data[config('const.form.front.standard.contact.NAME2') ]}}</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>フリガナ（全角）</th>
                        <td>
                            <div class="inputBlock">
                                <p class="inputName">{{ $data[config('const.form.front.standard.contact.KANA1') ]}}</p>
                                <p class="inputName">{{ $data[config('const.form.front.standard.contact.KANA2') ]}}</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>ご連絡方法</th>
                        <td>
                            {{ config('const.form.front.standard.contact.CONTACT_WAY_LIST')[$data[config('const.form.front.standard.contact.CONTACT_WAY')]] }}
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>メールアドレス</th>
                        <td>
                            {{ $data[config('const.form.front.standard.contact.EMAIL') ]}}
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>電話番号</th>
                        <td>
                            {{ $data[config('const.form.front.standard.contact.TEL') ]}}
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>リフォーム先の住所</th>
                        <td>
                            {{ $data[config('const.form.front.standard.contact.ADDRESS') ]}}
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>お問い合わせ内容</th>
                        <td>
                            {{ config('const.form.front.standard.contact.CONTACT_CATEGORY_LIST')[$data[config('const.form.front.standard.contact.CONTACT_CATEGORY')]] }}
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>ご相談内容を詳しくご入力ください</th>
                        <td>
                            {!! str_replace(' ', '&nbsp;', nl2br($data[config('const.form.front.standard.contact.CONTACT_TEXT')], false)) !!}
                        </td>
                    </tr>
                </tbody>
            </table>

            {!! Form::hidden(config('const.form.front.standard.contact.NAME1'), $data[config('const.form.front.standard.contact.NAME1')]) !!}
            {!! Form::hidden(config('const.form.front.standard.contact.NAME2'), $data[config('const.form.front.standard.contact.NAME2')]) !!}
            {!! Form::hidden(config('const.form.front.standard.contact.KANA1'), $data[config('const.form.front.standard.contact.KANA1')]) !!}
            {!! Form::hidden(config('const.form.front.standard.contact.KANA2'), $data[config('const.form.front.standard.contact.KANA2')]) !!}
            {!! Form::hidden(config('const.form.front.standard.contact.CONTACT_WAY'), $data[config('const.form.front.standard.contact.CONTACT_WAY')]) !!}
            {!! Form::hidden(config('const.form.front.standard.contact.EMAIL'), $data[config('const.form.front.standard.contact.EMAIL')]) !!}
            {!! Form::hidden(config('const.form.front.standard.contact.TEL'), $data[config('const.form.front.standard.contact.TEL')]) !!}
            {!! Form::hidden(config('const.form.front.standard.contact.ADDRESS'), $data[config('const.form.front.standard.contact.ADDRESS')]) !!}
            {!! Form::hidden(config('const.form.front.standard.contact.CONTACT_CATEGORY'), $data[config('const.form.front.standard.contact.CONTACT_CATEGORY')]) !!}
            {!! Form::hidden(config('const.form.front.standard.contact.CONTACT_TEXT'), $data[config('const.form.front.standard.contact.CONTACT_TEXT')]) !!}
            {!! Form::hidden(config('const.form.front.standard.contact.CONTACT_PRIVACY'), $data[config('const.form.front.standard.contact.CONTACT_PRIVACY')]) !!}
            {!! Form::hidden('e_data_type', $data['e_data_type']) !!} {{--  //Add Estimate Thanh 20190507 --}}
            <p class="confirmTxt">上記内容を確認の上、送信ボタンを押してください。</p>
            <div class="btnBlock _two">
                <button type="submit" class="submitBtn" v-on:click='onClick("{{ route('front.shop.standard.contact.complete', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) }}")'><i class="fas fa-arrow-circle-right"></i>送信</button>
                {!! Form::submit('修正', [
                    'class' => 'submitBtn _back',
                    'v-on:click' => 'onClick("' . route('front.shop.standard.contact', ['pref_code' => app()->request->route('pref_code'), 'shop_code' => app()->request->route('shop_code')]) . '")',
                ]) !!}
            </div>
        </form>
        </div>
    </article>
</main>
@endsection
