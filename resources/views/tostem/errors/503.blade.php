@extends("tostem.template")

@section("head")

@endsection



@section("header")
    @include('tostem.front.layout.header')
@endsection

@section("main")
    <main>
        <h1>503 error</h1>
    </main>
@endsection

@section("footer")
    @include('tostem.front.layout.footer')
@endsection

@section('script')
    <script src="{{asset('js/app.js')}}" ></script>
@endsection
