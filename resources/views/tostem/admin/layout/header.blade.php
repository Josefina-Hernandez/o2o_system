<header>
<div class="headerInr">
        <p class="logo">
            @if ( \Schema::hasColumn('shops', 'shop_type') === false ) {{--portal--}}
            <a href="{{ route('admin.lixil') }}"><img src="{{ asset('img/header_logo.png') }}" alt="簡易見積りシステム" width="183" height="31"></a>
            @else {{--general--}}
            <a href="{{ route('admin.lixil') }}"><img src="{{ asset('estimate/img/icon/h_logo.png') }}" alt="簡易見積りシステム" width="124" height="67"></a>
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

</header>