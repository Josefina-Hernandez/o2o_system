@extends('mado.admin.lixil.template')

@section('title', '会員ログイン｜LIXIL簡易見積りシステム')

{{-- ログイン画面はheaderを表示しない --}}
@section('header')
@endsection

@section('main')
<main class="login">
    <h1 class="logo">
    	@if ( Schema::hasColumn('shops', 'shop_type') === false )
	    	<img src="{{ asset('img/logo_main.png') }}" alt="LIXIL簡易見積りシステム" width="360" height="60">
	    @else
	    	<img src="{{ asset('/common/img/general_logo.png') }}" alt="LIXIL簡易見積りシステム" height="67">
	    @endif
    </h1>

	<h2>LIXIL簡易見積りシステム ログイン画面</h2>

    {!! Form::open([
        'class' => null,
        'route' => 'admin.shop.login',
    ]) !!}
        <dl class="loginBlock">
            <dt>ID</dt>
            <dd>
                {!! Form::text(
                    config('const.form.admin.shop.login.LOGIN_ID'),
                    old('login_id'),
                    [
                        'class' => null,
                        'placeholder' => 'ID'
                    ]
                ) !!}
                <p class="errors">{{ $errors->first(config('const.form.admin.shop.login.LOGIN_ID')) }}</p>
            </dd>
        </dl>
        <dl class="loginBlock">
            <dt>パスワード</dt>
            <dd>
                <input type="password" placeholder="パスワード" name="{{ config('const.form.admin.shop.login.PASSWORD') }}">
                <p class="errors">{{ $errors->first('password') }}</p>
            </dd>
        </dl>
        {!! Form::submit('ログイン', ['class' => 'loginBtn']) !!}
    {!! Form::close() !!}
</main>
@endsection
