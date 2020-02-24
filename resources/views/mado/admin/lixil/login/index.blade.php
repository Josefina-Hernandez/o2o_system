@extends('mado.admin.lixil.template')

@section('title', 'LIXIL Administrator')

{{-- ログイン画面はheaderを表示しない --}}
@section('header')
@endsection

@section('main')
<main class="login">
    <h1 class="logo">
    	@if ( Schema::hasColumn('shops', 'shop_type') === false )
	    	<img src="{{ asset('img/logo_main.png') }}" alt="LIXIL administrator" width="360" height="60">
	    @else
	    	<img src="{{ asset('/common/img/general_logo.png') }}" alt="LIXIL administrator" height="67">
	    @endif
    </h1>
    <h2 class="red">@if ( Schema::hasColumn('shops', 'shop_type') === false ) Login @endif Login</h2>

    {!! Form::open([
        'class' => null,
        'route' => 'admin.lixil.login',
    ]) !!}
        <dl class="loginBlock">
            <dt>ID</dt>
            <dd>
                {!! Form::text(
                    config('const.form.admin.lixil.login.LOGIN_ID'),
                    old('login_id'),
                    [
                        'class' => null,
                        'placeholder' => 'ID'
                    ]
                ) !!}
                <p class="errors">{{ $errors->first(config('const.form.admin.lixil.login.LOGIN_ID')) }}</p>
            </dd>
        </dl>
        <dl class="loginBlock">
            <dt>Password</dt>
            <dd>
                <input type="password" placeholder="Password" name="{{ config('const.form.admin.lixil.login.PASSWORD') }}">
                <p class="errors">{{ $errors->first('password') }}</p>
            </dd>
        </dl>
        {!! Form::submit('Login', ['class' => 'loginBtn']) !!}
    {!! Form::close() !!}
</main>
@endsection
