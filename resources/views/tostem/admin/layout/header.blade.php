<header>
     
  @if(Auth::user()->isAdmin())   
<div class="headerInr">
        <p class="logo">
            @if ( \Schema::hasColumn('shops', 'shop_type') === false ) {{--portal--}}
            <a class="rendect-page" data-href="{{ route('admin.lixil') }}"><img src="{{ asset('img/header_logo.png') }}" alt="簡易見積りシステム" width="183" height="31"></a>
            @else {{--general--}}
            <a class="rendect-page" data-href="{{ route('admin.lixil') }}"><img src="{{ asset('estimate/img/icon/h_logo.png') }}" alt="簡易見積りシステム" width="124" height="67"></a>
            @endif
        </p>
        <p class="name red">LIXIL administrator</p>
        <p class="logout"><a href="{{ route('admin.lixil.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></p>

        {!! Form::open([
            'id' => 'logout-form',
            'route' => 'admin.lixil.logout',
            'style' => 'display: none;',
        ]) !!}
        {!! Form::close() !!}
    </div>
  @endif
     
@if(!Auth::user()->isAdmin())

    <div class="headerInr">
        <p class="logo">
            @if ( \Schema::hasColumn('shops', 'shop_type') === false ) {{--portal--}}
            <a class="rendect-page" data-href="{{ route('admin.shop', ['shop_id' => Auth::user()->shop->id]) }}"><img src="{{ asset('img/header_logo.png') }}" alt="simple estimation system" width="183" height="31"></a>
            @else {{--general--}}
            <a class="rendect-page" data-href="{{ route('admin.shop', ['shop_id' => Auth::user()->shop->id]) }}"><img src="{{ asset('estimate/img/icon/h_logo.png') }}" alt="LIXIL administrator" width="124" height="67"></a>
            @endif
        </p>
        <!-- <p class="name">{{ Auth::user()->shop->{config('const.db.shops.NAME')} }}</p> -->
        <p class="name red">Management</p>
        <p class="logout"><a href="{{ route('admin.shop.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></p>

        {!! Form::open([
            'id' => 'logout-form',
            'route' => 'admin.shop.logout',
            'style' => 'display: none;',
        ]) !!}
        {!! Form::close() !!}
    </div>

@endif
     
</header>