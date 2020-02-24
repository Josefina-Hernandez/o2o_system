@extends('mado.front.template')

@section('title', 'お問い合わせ｜LIXIL簡易見積りシステム')

@section('frontcss')
<link rel="stylesheet" href="{{ asset('/css/shop.css') }}">
@endsection

@section('main')
<main id="mainArea" class="contact _confirm">
    <article>
        @include ('mado.front.parts.breadcrumbs')
        <h1>お問い合わせ確認</h1>

        <div id="confirm-complete">
        {!! Form::open([
            'route' => ['front.contact.confirm'],
            'v-on:submit.prevent' => 'onSubmit',
        ]) !!}
            <table class="contactTbl">
                <tbody>
                    <tr>
                        <th>お名前（全角）</th>
                        <td>
                            <div class="inputBlock">
                                <p class="inputName">{{ $data[config('const.form.front.contact.NAME1') ]}}</p>
                                <p class="inputName">{{ $data[config('const.form.front.contact.NAME2') ]}}</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>フリガナ（全角）</th>
                        <td>
                            <div class="inputBlock">
                                <p class="inputName">{{ $data[config('const.form.front.contact.KANA1') ]}}</p>
                                <p class="inputName">{{ $data[config('const.form.front.contact.KANA2') ]}}</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>ご連絡方法</th>
                        <td>
                            {{ config('const.form.front.contact.CONTACT_WAY_LIST')[$data[config('const.form.front.contact.CONTACT_WAY')]] }}
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>メールアドレス</th>
                        <td>
                            {{ $data[config('const.form.front.contact.EMAIL') ]}}
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>電話番号</th>
                        <td>
                            {{ $data[config('const.form.front.contact.TEL') ]}}
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>リフォーム先の住所</th>
                        <td>
                            {{ $data[config('const.form.front.contact.ADDRESS') ]}}
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>お問い合わせ内容</th>
                        <td>
                            {{ config('const.form.front.contact.CONTACT_CATEGORY_LIST')[$data[config('const.form.front.contact.CONTACT_CATEGORY')]] }}
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>ご相談内容を詳しくご入力ください</th>
                        <td>
                            {{ $data[config('const.form.front.contact.CONTACT_TEXT')] }}
                        </td>
                    </tr>
                </tbody>
            </table>

            {!! Form::hidden(config('const.form.front.contact.NAME1'), $data[config('const.form.front.contact.NAME1')]) !!}
            {!! Form::hidden(config('const.form.front.contact.NAME2'), $data[config('const.form.front.contact.NAME2')]) !!}
            {!! Form::hidden(config('const.form.front.contact.KANA1'), $data[config('const.form.front.contact.KANA1')]) !!}
            {!! Form::hidden(config('const.form.front.contact.KANA2'), $data[config('const.form.front.contact.KANA2')]) !!}
            {!! Form::hidden(config('const.form.front.contact.CONTACT_WAY'), $data[config('const.form.front.contact.CONTACT_WAY')]) !!}
            {!! Form::hidden(config('const.form.front.contact.EMAIL'), $data[config('const.form.front.contact.EMAIL')]) !!}
            {!! Form::hidden(config('const.form.front.contact.TEL'), $data[config('const.form.front.contact.TEL')]) !!}
            {!! Form::hidden(config('const.form.front.contact.ADDRESS'), $data[config('const.form.front.contact.ADDRESS')]) !!}
            {!! Form::hidden(config('const.form.front.contact.CONTACT_CATEGORY'), $data[config('const.form.front.contact.CONTACT_CATEGORY')]) !!}
            {!! Form::hidden(config('const.form.front.contact.CONTACT_TEXT'), $data[config('const.form.front.contact.CONTACT_TEXT')]) !!}

            <p class="confirmTxt">上記内容を確認の上、送信ボタンを押してください。</p>
            <div class="btnBlock _two">
                <button type="submit" class="submitBtn" v-on:click='onClick("{{ route('front.contact.complete') }}")'><i class="fas fa-arrow-circle-right"></i>送信</button>
                {!! Form::submit('修正', [
                    'class' => 'submitBtn _back',
                    'v-on:click' => 'onClick("' . route('front.contact') . '")',
                ]) !!}
            </div>
        </form>
        </div>
    </article>
</main>
@endsection

@section('script')
<script src="{{asset('js/app.js')}}" ></script>
@parent
@endsection
