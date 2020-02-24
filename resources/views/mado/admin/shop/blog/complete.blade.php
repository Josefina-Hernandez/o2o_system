@extends('mado.admin.shop.template')

@if('admin.shop.blog.complete' === \Route::currentRouteName())
    @section('title', '現場ブログ登録完了')
@elseif('admin.shop.blog.edit.complete' === \Route::currentRouteName())
    @section('title', '現場ブログ編集完了')
@endif

@section('main')

@if('admin.shop.blog.complete' === \Route::currentRouteName())
    <p>現場ブログ登録完了</p>
@elseif('admin.shop.blog.edit.complete' === \Route::currentRouteName())
    <p>現場ブログ編集完了</p>
@endif

@endsection
