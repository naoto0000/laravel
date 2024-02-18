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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 会員登録のルーティング
Route::get('/member_regist', 'MemberController@showList')->name('member_regist');

// 会員登録確認のルーティング
Route::post('/member_confirm', 'MemberController@showConfirm')->name('member_confirm');

// 会員登録完了のルーティング
Route::post('/member_complete', 'MemberController@showComplete')->name('member_complete');

// トップ画面のルーティング
Route::get('/top_show', 'MemberController@showTop')->name('top');

// // ログイン画面のルーティング
// Route::get('/login', 'MemberController@showLogin')->name('login_show');

// // ログイン画面からトップ画面へのルーティング
// Route::post('/top_login', 'MemberController@login')->name('login');
Route::get('/top_login', 'MemberController@showLoginTop')->name('login_top');

// // ログアウトのルーティング
// Route::get('/top', 'MemberController@showLogout')->name('logout');

// Authのルーティング
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

// パスワード再設定のルーティング
// リンクメール送信画面へのルーティング
Route::post('/mail_complete', 'MemberController@mailComplete')->name('mail_complete');
Route::get('/mail_complete', 'MemberController@showMailComplete')->name('show_mail_complete');
