<?php

namespace App\Http\Controllers;

use App\Mail\AuthMail;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

    // 会員情報変更画面に遷移
    public function memberEdit()
    {
        $is_login = Auth::check();

        if ($is_login === false) {
            return redirect()->route('top');
        }

        // ログインユーザーの情報を取得
        $user = Auth::user();

        return view('mypage.member_edit', compact('is_login', 'user'));
    }

    // 会員情報変更確認画面に遷移
    public function memberEditConfirm(Request $request)
    {
        $first_name = $request->input('first_name');
        $second_name = $request->input('second_name');
        $nickname = $request->input('nickname');
        $gender = $request->input('gender');

        $request->validate([
            'first_name' => 'required|max:20',
            'second_name' => 'required|max:20',
            'nickname' => 'required|max:10',
            'gender' => 'required|in:1,2',
        ], [
            'first_name.required' => '※氏名(姓)を入力してください。',
            'first_name.max' => '※氏名(姓)は20文字以内で入力してください。',
            'second_name.required' => '※氏名(名)を入力してください。',
            'second_name.max' => '※氏名(名)は20文字以内で入力してください。',
            'nickname.required' => '※ニックネームを入力してください。',
            'nickname.max' => '※ニックネームは10文字以内で入力してください。',
            'gender.required' => '※性別を選択してください。',
            'gender.in' => '※性別の値が不正です。',
        ]);

        return view('mypage.member_edit_confirm', compact('first_name', 'second_name', 'nickname', 'gender'));
    }

    // 会員情報変更の処理
    public function memberEditComplete(Request $request)
    {
        if ($request->input('back') == 'back') {
            return redirect('/mypage_member_edit')->withInput();
        }

        // ログインユーザーの情報を取得
        $user = Auth::user();

        $id = $user->id;

        $first_name = $request->input('first_name');
        $second_name = $request->input('second_name');
        $nickname = $request->input('nickname');
        $gender = $request->input('gender');

        // ユーザーの情報を更新
        $member = Member::find($id);
        $member->name_sei = $first_name;
        $member->name_mei = $second_name;
        $member->nickname = $nickname;
        $member->gender = $gender;
        $member->save();

        return redirect()->route('mypage');
    }

    // パスワード変更画面に遷移
    public function passwordEdit()
    {
        $is_login = Auth::check();

        if ($is_login === false) {
            return redirect()->route('top');
        }

        return view('mypage.password_edit', compact('is_login'));
    }

    // パスワード変更処理後、マイページに遷移
    public function passwordEditComplete(Request $request)
    {
        // ログインユーザーの情報を取得
        $user = Auth::user();

        $id = $user->id;

        $password = $request->input('password');

        $request->validate([
            'password' => 'required|between:8,20|alpha_num',
            'pass_conf' => 'required|between:8,20|same:password|alpha_num',
        ], [
            'password.required' => '※パスワードを入力してください。',
            'password.between' => '※パスワードは8文字以上20文字以内で入力してください。',
            'password.alpha_num' => '※パスワードは英数字のみで入力してください。',
            'pass_conf.required' => '※パスワード確認を入力してください。',
            'pass_conf.between' => '※パスワード確認は8文字以上20文字以内で入力してください。',
            'pass_conf.same' => '※パスワードとパスワード確認が一致しません。',
            'pass_conf.alpha_num' => '※パスワード確認は英数字のみで入力してください。',
        ]);

        // ユーザーの情報を更新
        $member = Member::find($id);
        $member->password = Hash::make($password);
        $member->save();

        return redirect()->route('mypage');
    }

    // メールアドレス変更画面に遷移
    public function mailEdit()
    {
        $is_login = Auth::check();

        if ($is_login === false) {
            return redirect()->route('top');
        }

        // ログインユーザーの情報を取得
        $user = Auth::user();

        return view('mypage.mail_edit', compact('is_login', 'user'));
    }

    // メールアドレス変更メール送信処理
    public function mailEditAuth(Request $request)
    {
        // ログインユーザーの情報を取得
        $user = Auth::user();

        $id = $user->id;

        $email = $request->input('email');
        $request->validate([
            'email' => 'required|email|max:200|unique:members',
        ], [
            'email.required' => '※メールアドレスを入力してください。',
            'email.email' => '※メールアドレスの形式で入力してください。',
            'email.max' => '※メールアドレスは200文字以内で入力してください。',
            'email.unique' => '※入力されたメールアドレスは既に使用されています。',
        ]);

        $authNumber = rand(100000, 999999);

        // メンバーモデルを取得してauth_codeを更新
        $member = Member::findOrFail($id);
        $member->auth_code = $authNumber;
        $member->save();

        $request->session()->put('auth_email', $email);

        try {
            // メール送信
            Mail::to($request->input('email'))->send(new AuthMail($authNumber));
        } catch (\Exception $e) {
            // メール送信中に例外が発生した場合のエラーハンドリング
            Log::error('Failed to send email: ' . $e->getMessage());

            // ユーザーにエラーメッセージを表示
            return redirect()->back()->with('error', 'メールの送信に失敗しました。');
        }

        return redirect()->route('show_mail_edit_auth', compact('email'));
    }

    // 認証チェック画面に遷移
    public function showMailEditAuth(Request $request)
    {
        $is_login = Auth::check();

        if ($is_login === false) {
            return redirect()->route('top');
        }

        return view('mypage.mail_edit_auth');
    }

    // メールアドレス変更、認証チェック処理後、マイページに遷移
    public function mailEditAuthComplete(Request $request)
    {
        // ログインユーザーの情報を取得
        $user = Auth::user();
        $id = $user->id;

        $email = session()->get('auth_email');
        $auth_code = (int)$request->input('auth_code');
        $user_auth_code = $user->auth_code;

        $error_msg = "";

        if (!$auth_code) {
            $error_msg = '※認証コードを入力してください。';
        } elseif ($auth_code !== $user_auth_code) {
            $error_msg = '※認証コードの値が間違っています。';
        }

        if ($error_msg) {
            return back()->withErrors($error_msg)->withInput();
        }

        // メンバーモデルを取得してemailを更新
        $member = Member::findOrFail($id);
        $member->email = $email;
        $member->save();

        return redirect()->route('mypage');
    }
}
