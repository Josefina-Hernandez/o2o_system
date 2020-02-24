@extends('mado.front.template')

@section('frontcss')
<link rel="stylesheet" href="{{ asset('/css/shop.css') }}">
@endsection

@section('head')
@parent
@endsection

@section("body")
@parent
<div onclick="">
@endsection

@section('header')
@parent
@endsection

@section('footer')
@parent
</div>
@endsection

@section('script')
<script src="{{asset('js/app.js')}}" ></script>
@parent
@endsection
