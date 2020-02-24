@extends('mado.front.shop.standard.template')

@section('title', "スタッフ紹介｜{$shop->{config('const.db.shops.NAME')}}｜LIXIL簡易見積りシステム")

@section('description', "LIXIL簡易見積りシステムサービス加盟店「{$shop->{config('const.db.shops.NAME')}}」のスタッフ紹介ページです。")

@section('main')
<main id="mainArea" class="staff">
    @include('mado.front.shop.standard.parts.header')

    <article>
        @include ('mado.front.parts.breadcrumbs')
        <h1>スタッフ紹介</h1>
        @if ($staffs->isEmpty())
            <p class="img100"><img src="{{ ('/img/notregist.png') }}" alt="登録されておりません"></p>
        @else
            <ul class="staffList">
                @foreach ($staffs as $staff)
                    <li>
                        <div class="staffImg">
                            <figure><img src="{{ $staff->imageUrl() }}" alt="{{ $staff->{config('const.db.staffs.NAME')} }}の写真"></figure>
                            <p class="title">{{ $staff->{config('const.db.staffs.POST')} }}</p>
                            <h2>{{ $staff->{config('const.db.staffs.NAME')} }}</h2>
                        </div>
                        <div class="staffTxt">
                            <h3>■メッセージ</h3>
                            <p>{!! nl2br($staff->{config('const.db.staffs.MESSAGE')}, false) !!}</p>
                            @isset ($staff->{config('const.db.staffs.CERTIFICATE')})
                                <h3>■資格</h3>
                                <p>{!! nl2br($staff->{config('const.db.staffs.CERTIFICATE')}, false) !!}</p>
                            @endisset
                            @isset ($staff->{config('const.db.staffs.HOBBY')})
                                <h3>■趣味</h3>
                                <p>{!! nl2br($staff->{config('const.db.staffs.HOBBY')}, false) !!}</p>
                            @endisset
                            @isset ($staff->{config('const.db.staffs.CASE')})
                                <h3>■代表施工事例</h3>
                                <p>{!! nl2br($staff->{config('const.db.staffs.CASE')}, false) !!}</p>
                            @endisset
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif

        @include ('mado.front.shop.standard.parts.shop_contact')

        @include ('mado.front.shop.standard.parts.shop_guide')
    </article>
</main>
@endsection
