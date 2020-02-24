@extends("tostem.template")

@section("head")

@endsection



@section("header")
    @include('tostem.front.layout.header')
@endsection

@section("main")
    <main id="site-main">
        @yield('content')
    </main>
@endsection

@section("footer")
    @include('tostem.front.layout.footer')
@endsection

@section('script')

@endsection
