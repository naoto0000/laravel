<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    // ログイン画面に遷移
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    // ログイン処理
    public function adminLogin(Request $request)
    {
        $request->validate([
            'login_id' => 'required|regex:/^[a-zA-Z0-9]{7,10}$/',
            'password' => 'required|regex:/^[a-zA-Z0-9]{8,20}$/',
        ]);

        $credentials = $request->only(['login_id', 'password']);

        if (Auth::guard('admin')->attempt($credentials)) {
            // ログインしたら管理画面トップにリダイレクト
            return redirect()->route('admin_top');
        }

        return back()->withErrors([
            'login' => ['ログインに失敗しました'],
        ])->withInput();
    }

    // トップ画面に遷移
    public function showTop()
    {
        // ページセッションを削除
        session()->forget('page');

        $is_login = Auth::guard('admin')->check();

        if ($is_login === false) {
            return redirect()->route('show_admin_login');
        }

        $admin = Auth::guard('admin')->user();
        return view('admin.top', ['admin' => $admin]);
    }

    // ログアウト処理
    public function adminLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ログアウトしたらログインフォームにリダイレクト
        return redirect()->route('show_admin_login');
    }
}
