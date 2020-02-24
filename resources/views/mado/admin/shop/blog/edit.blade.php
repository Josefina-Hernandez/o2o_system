@extends('mado.admin.shop.template')

@if('admin.shop.blog.new' === \Route::currentRouteName())
    @section('title', '現場ブログ登録')
@elseif('admin.shop.blog.edit' === \Route::currentRouteName())
    @section('title', '現場ブログ編集')
@endif

@section('main')

@if('admin.shop.blog.new' === \Route::currentRouteName())
    <p>現場ブログ登録</p>
@elseif('admin.shop.blog.edit' === \Route::currentRouteName())
    <p>現場ブログ編集</p>
@endif

@endsection
