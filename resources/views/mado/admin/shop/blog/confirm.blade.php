@extends('mado.admin.shop.template')

@if('admin.shop.blog.confirm' === \Route::currentRouteName())
    @section('title', '現場ブログ登録プレビュー')
@elseif('admin.shop.blog.edit.confirm' === \Route::currentRouteName())
    @section('title', '現場ブログ編集プレビュー')
@endif

@section('main')

@if('admin.shop.blog.confirm' === \Route::currentRouteName())
    <p>現場ブログ登録確認</p>
@elseif('admin.shop.blog.edit.confirm' === \Route::currentRouteName())
    <p>現場ブログ編集確認</p>
@endif

@endsection
