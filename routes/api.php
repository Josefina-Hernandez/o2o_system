<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * プレミアム店舗のWordPressと事例の同期を行うAPI
 */
Route::middleware('credentialClient')->name('api.photo')->namespace('Mado\Api')->group(function () {
    // 事例をプレミアム店舗と同期するAPI
    Route::post('/photo/update', ['as' => '.update', 'uses' => 'PremiumPhotoSyncController@update']);
    Route::post('/photo/delete', ['as' => '.delete', 'uses' => 'PremiumPhotoSyncController@delete']);

    // 現場ブログ/イベント・キャンペーンをプレミアム店舗と同期するAPI
    Route::post('/article/update', ['as' => '.update', 'uses' => 'PremiumArticleSyncController@update']);
    Route::post('/article/delete', ['as' => '.delete', 'uses' => 'PremiumArticleSyncController@delete']);
});

/**
 * 都道府県に紐付いた市区町村を取得するAPI
 */
Route::name('api.pref.city')->namespace('Mado\Api')->group(function ($group) {
    Route::get('/pref/{pref_id}/city', ['as' => '', 'uses' => 'CityController@getCities'])->where(['pref_id' => '[0-9]+']);
});
