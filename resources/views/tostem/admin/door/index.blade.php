@extends("tostem.admin.template")
@section('head')
    @parent
    <link rel="stylesheet" href="{{asset('tostem/admin/door/js/door.js')}}">
    <style>
        .test
    </style>
@endsection

@section('content')
    <div>door admin</div>
@endsection

@section('script')

    @parent
    <link rel="stylesheet" href="{{asset('tostem/admin/door/js/door.js')}}">
@endsection