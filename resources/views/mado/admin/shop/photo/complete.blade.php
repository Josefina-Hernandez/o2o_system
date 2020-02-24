@extends('mado.admin.shop.template')

@if('admin.shop.photo.complete' === \Route::currentRouteName())
    @section('title', '事例登録完了')
@elseif('admin.shop.photo.edit.complete' === \Route::currentRouteName())
    @section('title', '事例編集完了')
@endif

@section('main')

@if('admin.shop.photo.complete' === \Route::currentRouteName())
    <p>事例登録完了</p>
@elseif('admin.shop.photo.edit.complete' === \Route::currentRouteName())
    <p>事例編集完了</p>
@endif

@endsection
