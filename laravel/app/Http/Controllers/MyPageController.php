<?php

namespace App\Http\Controllers;

use App\Mail\AuthMail;
use App\Models\Member;
use App\Models\Product;
use App\Models\Review;
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

    // 商品レビュー管理画面に遷移
    public function mypageReview(Request $request)
    {
        $is_login = Auth::check();

        if ($is_login === false) {
            return redirect()->route('top');
        }

        // レビュー編集のセッションをクリア
        session()->forget('evaluation');
        session()->forget('review_comment');

        // ログインユーザーの情報を取得
        $user = Auth::user();

        $id = $user->id;

        $reviews = Review::join('members', 'reviews.member_id', '=', 'members.id')
            ->join('products', 'reviews.product_id', '=', 'products.id')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->join('product_subcategories', 'products.product_subcategory_id', '=', 'product_subcategories.id')
            ->where('members.id', $id)
            ->whereColumn('products.id', 'reviews.product_id')
            ->orderBy('reviews.id', 'desc') // reviews.idの降順
            ->select(
                'reviews.*',
                'products.name as product_name',
                'products.image_1 as product_image',
                'product_categories.name as category_name',
                'product_subcategories.name as subcategory_name'
            )
            ->paginate(5);

        return view('mypage.review_list', compact('reviews'));
    }

    // 商品レビュー編集画面に遷移
    public function mypageReviewEdit(Request $request)
    {
        $is_login = Auth::check();

        if ($is_login === false) {
            return redirect()->route('top');
        }

        // ルーティングからIDを取得
        $id = $request->route('id');

        $product_id = Review::where('id', $id)->value('product_id');

        $average = Review::where('product_id', $product_id)->avg('evaluation');
        $average = ceil($average);

        $product = Product::where('id', $product_id)->first();
        $review = Review::where('id', $id)->first();

        return view('mypage.review_edit', compact('product', 'average', 'review', 'request'));
    }

    // 商品レビュー編集確認画面に遷移
    public function mypageReviewConfirm(Request $request)
    {
        // ルーティングからIDを取得
        $id = $request->route('id');

        $product_id = Review::where('id', $id)->value('product_id');

        $average = Review::where('product_id', $product_id)->avg('evaluation');
        $average = ceil($average);

        $product = Product::where('id', $product_id)->first();
        $review = Review::where('id', $id)->first();

        $evaluation = $request->input('evaluation');
        $review_comment = $request->input('review_comment');

        // リクエストデータをセッションに保存
        $request->session()->put('evaluation', $evaluation);
        $request->session()->put('review_comment', $review_comment);

        $request->validate([
            'evaluation' => ['required', 'numeric', 'between:1,5'],
            'review_comment' => ['required', 'max:500'],
        ], [
            'evaluation.required' => '※商品評価を入力してください。',
            'evaluation.numeric' => '※値を入力してください。',
            'evaluation.between' => '※値は1~5で入力してください。',
            'review_comment.required' => '※商品コメントを入力してください。',
            'review_comment.max' => '※商品コメントは500文字以内で入力してください。',
        ]);

        return view('mypage.review_confirm', compact('product', 'average', 'review', 'request'));
    }

    // 商品レビュー編集処理後、商品レビュー管理画面に遷移
    public function mypageReviewComplete(Request $request)
    {
        // ルーティングからIDを取得
        $id = $request->route('id');

        $page = $request->query('page');

        $evaluation = $request->input('evaluation');
        $review_comment = $request->input('review_comment');

        // レビューモデルを取得して更新
        $review = Review::findOrFail($id);
        $review->evaluation = $evaluation;
        $review->comment = $review_comment;
        $review->save();

        return redirect()->route('mypage_review', ['page' => $page]);
    }

    // 商品レビュー削除画面に遷移
    public function mypageReviewWithdraw(Request $request)
    {
        $is_login = Auth::check();

        if ($is_login === false) {
            return redirect()->route('top');
        }

        // ルーティングからIDを取得
        $id = $request->route('id');

        $product_id = Review::where('id', $id)->value('product_id');

        $average = Review::where('product_id', $product_id)->avg('evaluation');
        $average = ceil($average);

        $product = Product::where('id', $product_id)->first();
        $review = Review::where('id', $id)->first();

        return view('mypage.review_withdraw', compact('product', 'average', 'review', 'request'));
    }

    // 商品レビュー編集処理後、商品レビュー管理画面に遷移
    public function mypageReviewWithdrawComplete(Request $request)
    {
        // ルーティングからIDを取得
        $id = $request->route('id');

        // レビューモデルを取得して削除
        $review = Review::where('id', $id)->first();
        if ($review) {
            $review->delete();
        }

        return redirect()->route('mypage_review');
    }
}
