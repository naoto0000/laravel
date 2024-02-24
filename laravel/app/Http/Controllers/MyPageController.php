<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyPageController extends Controller
{
    // マイページへ遷移
    public function showMypage(Request $request)
    {
        $is_login = Auth::check();

        if ($is_login === false) {
            return redirect()->route('top');
        }

        // ログインユーザーの情報を取得
        $user = Auth::user();

        return view('mypage.mypage', compact('is_login', 'user'));
    }

    // 退会画面へ遷移
    public function showWithdraw(Request $request)
    {
        $is_login = Auth::check();

        if ($is_login === false) {
            return redirect()->route('top');
        }

        // ログインユーザーの情報を取得
        $user = Auth::user();

        return view('mypage.withdraw', compact('is_login', 'user'));
    }

    // 退会処理後トップ画面に遷移
    public function memberWithdraw()
    {
        // ログインユーザーの情報を取得
        $user = Auth::user();

        $id = $user->id;

        $member = Member::where('id', $id)->first();
        if ($member) {
            $member->delete();
        }
        
        return redirect()->route('top');
    }
}
