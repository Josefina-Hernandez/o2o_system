@extends('mado.admin.shop.template')

@section('title', 'LIXIL Administrator')

@section('main')
@include ('mado.admin.parts.notice_message')

<main class="mypage">
    <h1 class="mainTtl"></h1>

    <ul class="navList">
            <li><a href="{{ route('admin.shop.users.usershop',[Auth::user()->shop->id]) }}" >Account</a></li>
            <li><a href="#">Quotation <br>Result</a></li>
    </ul>
</main>
@endsection
