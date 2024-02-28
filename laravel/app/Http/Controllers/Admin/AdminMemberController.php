<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminMemberController extends Controller
{
    // 一覧画面に遷移
    public function showMemberList()
    {
        // 検索条件のセッションをクリア
        session()->forget('member_search_id');
        session()->forget('member_search_gender');
        session()->forget('member_search_freeword');

        // 表示順のセッションをクリア
        session()->forget('member_order');

        $members = Member::sortable()->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.member.list', ['members' => $members]);
    }

    // 検索処理
    public function showMemberSearch(Request $request)
    {
        // 昇降順を取得
        $direction = $request->query('direction');
        $sort = $request->query('sort');

        // フォームから送信された検索クエリを取得
        $member_search_id = $request->input('member_search_id');
        $member_search_gender = $request->input('member_search_gender') ?? [];
        $member_search_freeword = $request->input('member_search_freeword');

        $request->session()->put('member_search_id', $member_search_id);
        $request->session()->put('member_search_gender', $member_search_gender);
        $request->session()->put('member_search_freeword', $member_search_freeword);

        $members = Member::where(function ($query) use ($member_search_id, $member_search_gender, $member_search_freeword) {
            if ($member_search_id) {
                $query->where('id', $member_search_id);
            }
            if ($member_search_gender) {
                // $member_search_genderが配列でない場合は配列に変換する
                if (!is_array($member_search_gender)) {
                    $member_search_gender = [$member_search_gender];
                }

                // どちらか片方が選択されている場合はそれに合わせて検索条件を追加
                $query->where(function ($query) use ($member_search_gender) {
                    if (in_array(1, $member_search_gender)) {
                        $query->orWhere('gender', 1); // 男性
                    }
                    if (in_array(2, $member_search_gender)) {
                        $query->orWhere('gender', 2); // 女性
                    }
                });
            }
            if ($member_search_freeword) {
                $query->where(function ($query) use ($member_search_freeword) {
                    $query->where('name_sei', 'like', '%' . $member_search_freeword . '%')
                        ->orWhere('name_mei', 'like', '%' . $member_search_freeword . '%')
                        ->orWhere('email', 'like', '%' . $member_search_freeword . '%');
                });
            }
        });

        if ($direction == 'asc') {
            $members = $members->sortable()->orderBy('created_at', 'asc')->paginate(10);
        } else {
            $members = $members->sortable()->orderBy('created_at', 'desc')->paginate(10);
        }

        return view('admin.member.list', ['members' => $members, 'direction' => $direction, 'sort' => $sort]);
    }

    // 会員登録画面に遷移
    public function showMemberRegist()
    {
        return view('admin.member.regist');
    }

    // 会員登録確認画面に遷移
    public function showMemberConfirm(Request $request)
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

        return view('admin.member.confirm', compact('first_name', 'second_name', 'nickname', 'gender', 'password', 'pass_conf', 'email'));
    }

    public function showMemberComplete(Request $request)
    {
        if ($request->input('back') == 'back') {
            return redirect('/admin_member_regist')->withInput();
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

        $request->session()->regenerateToken();

        return redirect()->route('admin_member_list');
    }

    // 会員編集画面に遷移
    public function showMemberEdit(Request $request, $id)
    {
        // ページをセッションに保存
        $page = $request->query('page');
        $request->session()->put('page', $page);

        // $idを使って必要な処理を行う
        $member = Member::find($id);
        return view('admin.member.regist', ['member' => $member]);
    }

    // 会員編集確認画面に遷移
    public function showMemberEditConfirm(Request $request)
    {
        $id = $request->input('id');
        $first_name = $request->input('first_name');
        $second_name = $request->input('second_name');
        $nickname = $request->input('nickname');
        $gender = $request->input('gender');
        $password = $request->input('password');
        $pass_conf = $request->input('pass_conf');
        $email = $request->input('email');

        $rules = [
            'first_name' => 'required|max:20',
            'second_name' => 'required|max:20',
            'nickname' => 'required|max:10',
            'gender' => 'required|in:1,2',
            'email' => [
                'required',
                'email',
                'max:200',
                Rule::unique('members')->ignore($id),
            ],
        ];

        if ($password != "" || $pass_conf != "" || $password != "" && $pass_conf != "") {
            $rules['password'] = 'between:8,20|alpha_num';
            $rules['pass_conf'] = 'between:8,20|same:password|alpha_num';
        }

        $request->validate($rules, [
            'first_name.required' => '※氏名(姓)を入力してください。',
            'first_name.max' => '※氏名(姓)は20文字以内で入力してください。',
            'second_name.required' => '※氏名(名)を入力してください。',
            'second_name.max' => '※氏名(名)は20文字以内で入力してください。',
            'nickname.required' => '※ニックネームを入力してください。',
            'nickname.max' => '※ニックネームは10文字以内で入力してください。',
            'gender.required' => '※性別を選択してください。',
            'gender.in' => '※性別の値が不正です。',
            'password.between' => '※パスワードは8文字以上20文字以内で入力してください。',
            'password.alpha_num' => '※パスワードは英数字のみで入力してください。',
            'pass_conf.between' => '※パスワード確認は8文字以上20文字以内で入力してください。',
            'pass_conf.same' => '※パスワードとパスワード確認が一致しません。',
            'pass_conf.alpha_num' => '※パスワード確認は英数字のみで入力してください。',
            'email.required' => '※メールアドレスを入力してください。',
            'email.email' => '※メールアドレスの形式で入力してください。',
            'email.max' => '※メールアドレスは200文字以内で入力してください。',
            'email.unique' => '※入力されたメールアドレスは既に使用されています。',
        ]);

        return view('admin.member.confirm', compact('id', 'first_name', 'second_name', 'nickname', 'gender', 'password', 'pass_conf', 'email'));
    }

    // 編集処理後、会員一覧画面に遷移
    public function showMemberEditComplete(Request $request)
    {

        $id = $request->input('id');

        if ($request->input('back') == 'back') {
            return redirect('/admin_member_edit/' . $id)->withInput();
        }

        // 指定されたIDに対応する既存の会員レコードを取得
        $member = Member::findOrFail($id);

        // 会員情報を更新
        if ($request->input('password') == "") {
            $member->update([
                'name_sei' => $request->input('first_name'),
                'name_mei' => $request->input('second_name'),
                'nickname' => $request->input('nickname'),
                'gender' => $request->input('gender'),
                'email' => $request->input('email'),
            ]);
        } else {
            $member->update([
                'name_sei' => $request->input('first_name'),
                'name_mei' => $request->input('second_name'),
                'nickname' => $request->input('nickname'),
                'gender' => $request->input('gender'),
                'password' => Hash::make($request->input('password')),
                'email' => $request->input('email'),
            ]);
        }

        $request->session()->regenerateToken();

        return redirect()->route('admin_member_list');
    }
}
