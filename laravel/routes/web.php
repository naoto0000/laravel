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

// レビュー登録画面への遷移
Route::get('/review_regist/{id}', 'ReviewController@showRegist')->name('review_regist');

// レビュー登録確認のルーティング
Route::post('/review_confirm/{id}', 'ReviewController@showConfirm')->name('review_confirm');

// レビュー登録完了のルーティング
Route::post('/review_complete/{id}', 'ReviewController@showComplete')->name('review_complete');

// マイページ関連
// ===========
// マイページへの遷移
Route::get('/mypage', 'MyPageController@showMypage')->name('mypage');

// 退会画面への遷移
Route::get('/mypage_withdraw', 'MyPageController@showWithdraw')->name('mypage_withdraw');

// 退会処理
Route::post('/member_withdraw', 'MyPageController@memberWithdraw')->name('member_withdraw');

// 会員情報変更画面への遷移
Route::get('/mypage_member_edit', 'MyPageController@memberEdit')->name('mypage_member_edit');

// 会員情報変更確認画面への遷移
Route::post('/mypage_member_confirm', 'MyPageController@memberEditConfirm')->name('mypage_member_edit_confirm');

// 会員情報変更登録処理
Route::post('/mypage_member_complete', 'MyPageController@memberEditComplete')->name('mypage_member_edit_complete');

// パスワード変更画面への遷移
Route::get('/mypage_password_edit', 'MyPageController@passwordEdit')->name('mypage_password_edit');

// パスワード変更処理
Route::post('/mypage_password_edit', 'MyPageController@passwordEditComplete')->name('mypage_password_complete');

// メールアドレス変更画面への遷移
Route::get('/mypage_mail_edit', 'MyPageController@mailEdit')->name('mypage_mail_edit');

// メールアドレス変更メール送信処理
Route::post('/mypage_mail_edit', 'MyPageController@mailEditAuth')->name('mypage_mail_edit_auth');

// メールアドレス変更メール送信後、認証画面への遷移
Route::get('/mypage_mail_edit_complete', 'MyPageController@showMailEditAuth')->name('show_mail_edit_auth');

// メールアドレス認証確認後、マイページへの遷移
Route::post('/mypage_mail_edit_complete', 'MyPageController@mailEditAuthComplete')->name('mypage_mail_edit_auth_complete');

// 商品レビュー管理画面への遷移
Route::get('/mypage_review', 'MyPageController@mypageReview')->name('mypage_review');

// 商品レビュー編集画面への遷移
Route::get('/mypage_review_edit/{id}', 'MyPageController@mypageReviewEdit')->name('mypage_review_edit');

// 商品レビュー編集確認画面への遷移
Route::post('/mypage_review_confirm/{id}', 'MyPageController@mypageReviewConfirm')->name('mypage_review_confirm');

// 商品レビュー編集処理後、商品レビュー管理画面に遷移
Route::post('/mypage_review_complete/{id}', 'MyPageController@mypageReviewComplete')->name('mypage_review_complete');

// 商品レビュー削除画面への遷移
Route::get('/mypage_review_withdraw/{id}', 'MyPageController@mypageReviewWithdraw')->name('mypage_review_withdraw');

// 商品レビュー削除処理後、商品レビュー管理画面に遷移
Route::post('/mypage_review_withdraw_complete/{id}', 'MyPageController@mypageReviewWithdrawComplete')->name('mypage_review_withdraw_complete');

// 管理者画面関連のルーティング
// =======================
// 管理者ログイン画面への遷移
Route::get('/admin_login', 'Admin\AdminLoginController@showLogin')->name('show_admin_login');

// 管理者ログイン処理
Route::post('/admin_login', 'Admin\AdminLoginController@adminLogin')->name('admin_login');

// 管理者ログイン処理後、トップ画面に遷移
Route::get('/admin_top', 'Admin\AdminLoginController@showTop')->name('admin_top');

// 管理者ログアウト処理後、ログイン画面に遷移
Route::get('/admin_logout', 'Admin\AdminLoginController@adminLogout')->name('admin_logout');

// 管理者会員一覧画面への遷移
Route::get('/admin_member_list', 'Admin\AdminMemberController@showMemberList')->name('admin_member_list');

// 検索処理、管理者会員一覧画面への遷移
Route::get('/admin_member_list_search', 'Admin\AdminMemberController@showMemberSearch')->name('admin_member_list_search');

// 管理者会員登録画面への遷移
Route::get('/admin_member_regist', 'Admin\AdminMemberController@showMemberRegist')->name('admin_member_regist');

// 管理者会員登録確認画面への遷移
Route::post('/admin_member_confirm', 'Admin\AdminMemberController@showMemberConfirm')->name('admin_member_confirm');

// 管理者会員登録処理後、会員一覧画面に遷移
Route::post('/admin_member_complete', 'Admin\AdminMemberController@showMemberComplete')->name('admin_member_complete');

// 管理者会員編集画面への遷移
Route::get('/admin_member_edit/{id}', 'Admin\AdminMemberController@showMemberEdit')->name('admin_member_edit');

// 管理者会員編集確認への遷移
Route::post('/admin_member_edit_confirm', 'Admin\AdminMemberController@showMemberEditConfirm')->name('admin_member_edit_confirm');

// 管理者会員編集処理後、会員一覧画面に遷移
Route::post('/admin_member_edit_complete', 'Admin\AdminMemberController@showMemberEditComplete')->name('admin_member_edit_complete');

// 管理者会員詳細画面への遷移
Route::get('/admin_member_detail/{id}', 'Admin\AdminMemberController@showMemberDetail')->name('admin_member_detail');

// 管理者会員削除処理後、会員一覧画面に遷移
Route::post('/admin_member_delete', 'Admin\AdminMemberController@showMemberDelete')->name('admin_member_delete');

// 管理者カテゴリ一覧画面への遷移
Route::get('/admin_category_list', 'Admin\AdminCategoryController@showCategoryList')->name('admin_category_list');

// 検索処理、管理者カテゴリ一覧画面への遷移
Route::get('/admin_category_list_search', 'Admin\AdminCategoryController@showCategorySearch')->name('admin_category_list_search');

// 管理者カテゴリ登録画面への遷移
Route::get('/admin_category_regist', 'Admin\AdminCategoryController@showCategoryRegist')->name('admin_category_regist');

// 管理者カテゴリ登録確認画面への遷移
Route::post('/admin_category_confirm', 'Admin\AdminCategoryController@showCategoryConfirm')->name('admin_category_confirm');

// 管理者カテゴリ登録処理後、カテゴリ一覧画面に遷移
Route::post('/admin_category_complete', 'Admin\AdminCategoryController@showCategoryComplete')->name('admin_category_complete');

// 管理者カテゴリ編集画面への遷移
Route::get('/admin_category_edit/{id}', 'Admin\AdminCategoryController@showCategoryEdit')->name('admin_category_edit');

// 管理者カテゴリ編集確認への遷移
Route::post('/admin_category_edit_confirm', 'Admin\AdminCategoryController@showCategoryEditConfirm')->name('admin_category_edit_confirm');

// 管理者カテゴリ編集処理後、カテゴリ一覧画面に遷移
Route::post('/admin_category_edit_complete', 'Admin\AdminCategoryController@showCategoryEditComplete')->name('admin_category_edit_complete');
