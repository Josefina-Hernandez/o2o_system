@extends("tostem.template")

@section("head")

@endsection

@section("header")
    @include('tostem.admin.layout.header')
@endsection

@section("main")
    <main>
        @yield('content')
    </main>
@endsection

@section("footer")
    @include('tostem.admin.layout.footer')
@endsection

@section('script')
@endsection
