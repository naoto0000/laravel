<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminReviewController extends Controller
{
    // 商品レビュー一覧画面に遷移
    public function showReviewList()
    {
        $is_login = Auth::guard('admin')->check();

        if ($is_login === false) {
            return redirect()->route('show_admin_login');
        }

        // 検索条件のセッションをクリア
        session()->forget('review_search_id');
        session()->forget('review_search_freeword');

        $reviews = Review::sortable()->orderBy('id', 'desc')->paginate(10);
        return view('admin.review.list', ['reviews' => $reviews]);
    }

    // 検索処理
    public function showReviewSearch(Request $request)
    {
        // 昇降順を取得
        $direction = $request->query('direction');
        $sort = $request->query('sort');

        // フォームから送信された検索クエリを取得
        $review_search_id = $request->input('review_search_id');
        $review_search_freeword = $request->input('review_search_freeword');

        $request->session()->put('review_search_id', $review_search_id);
        $request->session()->put('review_search_freeword', $review_search_freeword);

        $reviews = Review::where(function ($query) use ($review_search_id, $review_search_freeword) {
            if ($review_search_id) {
                $query->where('id', $review_search_id);
            }
            if ($review_search_freeword) {
                $query->where(function ($query) use ($review_search_freeword) {
                    $query->where('comment', 'like', '%' . $review_search_freeword . '%');
                });
            }
        });

        if ($direction == 'asc') {
            $reviews = $reviews->sortable()->orderBy('created_at', 'asc')->paginate(10);
        } else {
            $reviews = $reviews->sortable()->orderBy('created_at', 'desc')->paginate(10);
        }

        return view('admin.review.list', ['reviews' => $reviews, 'direction' => $direction, 'sort' => $sort]);
    }
}
