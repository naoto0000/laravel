<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyPageController extends Controller
{
    // レビュー一覧画面へ遷移
    public function showMypage(Request $request)
    {
        $is_login = Auth::check();

        if ($is_login === false) {
            return redirect()->route('top');
        }

        // ログインユーザーの情報を取得
        $user = Auth::user();

        // 商品情報を詳細ビューに渡して表示
        return view('mypage.mypage', compact('is_login', 'user'));
    }
}
