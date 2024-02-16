<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// 会員登録のルーティング
Route::get('/member_regist', 'MemberController@showList')->name('member_regist');

// 会員登録確認のルーティング
Route::post('/member_confirm', 'MemberController@showConfirm')->name('member_confirm');

// 会員登録完了のルーティング
Route::post('/member_complete', 'MemberController@showComplete')->name('member_complete');
