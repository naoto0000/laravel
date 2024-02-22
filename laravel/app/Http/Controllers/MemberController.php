<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Member;
use App\Mail\CompleteMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    // 会員登録画面を表示
    // @return view

    public function showList()
    {
        return view('member.regist');
    }

    public function showConfirm(Request $request)
    {

        $first_name = $request->input('first_name');
        $second_name = $request->input('second_name');
        $nickname = $request->input('nickname');
        $gender = $request->input('gender');
        $password = $request->input('password');
        $pass_conf = $request->input('pass_conf');
        $email = $request->input('email');

        $request->validate([
            'first_name' => 'required|max:20',
            'second_name' => 'required|max:20',
            'nickname' => 'required|max:10',
            'gender' => 'required|in:1,2',
            'password' => 'required|between:8,20|alpha_num',
            'pass_conf' => 'required|between:8,20|same:password|alpha_num',
            'email' => 'required|email|max:200|unique:members',
        ], [
            'first_name.required' => '※氏名(姓)を入力してください。',
            'first_name.max' => '※氏名(姓)は20文字以内で入力してください。',
            'second_name.required' => '※氏名(名)を入力してください。',
            'second_name.max' => '※氏名(名)は20文字以内で入力してください。',
            'nickname.required' => '※ニックネームを入力してください。',
            'nickname.max' => '※ニックネームは10文字以内で入力してください。',
            'gender.required' => '※性別を選択してください。',
            'gender.in' => '※性別の値が不正です。',
            'password.required' => '※パスワードを入力してください。',
            'password.between' => '※パスワードは8文字以上20文字以内で入力してください。',
            'password.alpha_num' => '※パスワードは英数字のみで入力してください。',
            'pass_conf.required' => '※パスワード確認を入力してください。',
            'pass_conf.between' => '※パスワード確認は8文字以上20文字以内で入力してください。',
            'pass_conf.same' => '※パスワードとパスワード確認が一致しません。',
            'pass_conf.alpha_num' => '※パスワード確認は英数字のみで入力してください。',
            'email.required' => '※メールアドレスを入力してください。',
            'email.email' => '※メールアドレスの形式で入力してください。',
            'email.max' => '※メールアドレスは200文字以内で入力してください。',
            'email.unique' => '※入力されたメールアドレスは既に使用されています。',
        ]);

        return view('member.confirm', compact('first_name', 'second_name', 'nickname', 'gender', 'password', 'pass_conf', 'email'));
    }

    public function showComplete(Request $request)
    {
        if ($request->input('back') == 'back') {
            return redirect('/member_regist')->withInput();
        }

        $member = new Member();

        $member->create([
            'name_sei' => $request->input('first_name'),
            'name_mei' => $request->input('second_name'),
            'nickname' => $request->input('nickname'),
            'gender' => $request->input('gender'),
            'password' => Hash::make($request->input('password')),
            'email' => $request->input('email'),
        ]);

        $name = $request->input('first_name') . $request->input('second_name');

        try {
            // メール送信
            Mail::to($request->input('email'))->send(new CompleteMail($name));
        } catch (\Exception $e) {
            // メール送信中に例外が発生した場合のエラーハンドリング
            Log::error('Failed to send email: ' . $e->getMessage());

            // ユーザーにエラーメッセージを表示
            return redirect()->back()->with('error', 'メールの送信に失敗しました。');
        }

        $request->session()->regenerateToken();

        return view('member.complete');
    }

    // トップ画面に遷移
    public function showTop()
    {
        return view('top', ['is_login' => false]);
    }

    // ログイン画面に遷移
    public function showLogin()
    {
        return view('login');
    }

    // ログイン画面からトップ画面に遷移
    public function showLoginTop()
    {

        // 商品登録画面のリファラーをクリア
        session()->forget('referer_page');

        $is_login = Auth::check();
        // ログインユーザーの情報を取得
        $user = Auth::user();
        return view('top', ['is_login' => $is_login, 'user' => $user]);
    }

    // ログイン画面からトップ画面に遷移
    public function showLogout()
    {
        session()->put('login', '');
        return view('top');
    }

    public function mailComplete()
    {
        return redirect()->route('show_mail_complete');
    }

    // パスワード再設定メール送信後、完了画面に遷移
    public function showMailComplete()
    {
        return view('mail_complete');
    }
}
