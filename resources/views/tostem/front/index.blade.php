@extends("tostem.front.template")
@section('head')
    @parent
    <link rel="stylesheet" href="{{asset('tostem/front/door/css/door.css')}}">
@endsection

@section('content')
    <div>fronted</div>
@endsection

@section('script')
    @parent
    <script href="{{asset('tostem/front/door/js/door.js')}}"></script>
@endsection