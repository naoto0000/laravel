<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

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
}
