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
Route::get('/top_login', 'MemberController@showLoginTop')->name('login_top');


// Authのルーティング
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

// パスワード再設定のルーティング
// リンクメール送信画面へのルーティング
Route::post('/mail_complete', 'MemberController@mailComplete')->name('mail_complete');
Route::get('/mail_complete', 'MemberController@showMailComplete')->name('show_mail_complete');

// 商品登録関連
// ==========
// 商品登録画面へ遷移
Route::get('/product_regist', 'ProductController@showRegist')->name('product_regist');

// 商品登録画面、カテゴリー選択処理
Route::get('/getSubcategories', 'ProductController@getSubcategories')->name('getSubcategories');

// 画像アップロード
Route::post('/upload', 'ProductController@upload')->name('upload');

// 商品登録確認のルーティング
Route::post('/product_confirm', 'ProductController@showConfirm')->name('product_confirm');

// 商品登録完了のルーティング
Route::post('/product_complete', 'ProductController@showComplete')->name('product_complete');

// 商品一覧画面への遷移
Route::get('/product_list', 'ProductController@showList')->name('product_list');

// 商品一覧画面(検索あり)への遷移
Route::get('/product_search', 'ProductController@showSearch')->name('product_search');

// 商品詳細画面への遷移
Route::get('/product_detail/{id}', 'ProductController@showDetail')->name('product_detail');

// レビュー関連
// ==========
// レビュー一覧画面への遷移
Route::get('/review_list/{id}', 'ReviewController@showList')->name('review_list');

// レビュー一覧画面への遷移
Route::get('/review_regist/{id}', 'ReviewController@showRegist')->name('review_regist');

// レビュー登録確認のルーティング
Route::post('/review_confirm/{id}', 'ReviewController@showConfirm')->name('review_confirm');

// レビュー登録確認のルーティング
Route::post('/review_complete/{id}', 'ReviewController@showComplete')->name('review_complete');

// マイページ関連
// ===========
// マイページへの遷移
Route::get('/mypage', 'MyPageController@showMypage')->name('mypage');

// 退会画面への遷移
Route::get('/mypage_withdraw', 'MyPageController@showWithdraw')->name('mypage_withdraw');

// 退会処理
Route::post('/member_withdraw', 'MyPageController@memberWithdraw')->name('member_withdraw');
