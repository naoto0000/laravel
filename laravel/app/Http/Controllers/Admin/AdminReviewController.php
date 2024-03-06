<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Product;
use App\Models\Review;
use App\Rules\MemberValue;
use App\Rules\ProductValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        // 商品登録のセッションをクリア
        session()->forget('member_id');
        session()->forget('product_id');
        session()->forget('evaluation');
        session()->forget('review_comment');

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

    // 商品レビュー登録画面に遷移
    public function showReviewRegist()
    {
        $is_login = Auth::guard('admin')->check();

        if ($is_login === false) {
            return redirect()->route('show_admin_login');
        }

        $members = Member::all();
        $products = Product::all();

        return view('admin.review.regist', compact('members', 'products'));
    }

    // 登録処理、確認画面に遷移
    public function adminReviewConfirm(Request $request)
    {

        $product_id = $request->input('product_id');
        $member_id = $request->input('member_id');
        $evaluation = $request->input('evaluation');
        $review_comment = $request->input('review_comment');

        $request->validate([
            'product_id' => ['required', 'numeric', new ProductValue],
            'member_id' => ['required', 'numeric', new MemberValue],
            'evaluation' => ['required', 'numeric', 'between:1,5'],
            'review_comment' => ['required', 'max:500'],
        ], [
            'product_id.required' => '※値を入力してください。',
            'product_id.numeric' => '※値を数値にしてください。',
            'member_id.required' => '※値を入力してください。',
            'member_id.numeric' => '※値を数値にしてください。',
            'evaluation.required' => '※商品評価を入力してください。',
            'evaluation.numeric' => '※値を入力してください。',
            'evaluation.between' => '※値は1~5で入力してください。',
            'review_comment.required' => '※商品コメントを入力してください。',
            'review_comment.max' => '※商品コメントは500文字以内で入力してください。',
        ]);

        // 商品情報を取得
        $product = DB::table('products')
            ->select('*')
            ->where('id', $product_id)
            ->first();

        // 会員情報を取得
        $member = DB::table('members')
            ->select('*')
            ->where('id', $member_id)
            ->first();

        // レビューの総合評価取得
        $average = DB::table('reviews')
            ->where('product_id', $product_id)
            ->avg('evaluation');

        $average = ceil($average);

        return view('admin.review.confirm', compact('product_id', 'member_id', 'evaluation', 'review_comment', 'product', 'member', 'average', 'request'));
    }

    // 登録完了処理
    public function adminReviewComplete(Request $request)
    {
        if ($request->input('back') == 'back') {
            return redirect('/admin_review_regist')->withInput();
        }

        $review = new Review();

        $review->create([
            'member_id' => $request->input('member_id'),
            'product_id' => $request->input('product_id'),
            'evaluation' => $request->input('evaluation'),
            'comment' => $request->input('review_comment'),
        ]);

        $request->session()->regenerateToken();

        return redirect()->route('admin_review_list');
    }

    // 商品レビュー編集画面に遷移
    public function showReviewEdit(Request $request, $id)
    {
        $is_login = Auth::guard('admin')->check();

        if ($is_login === false) {
            return redirect()->route('show_admin_login');
        }

        // ページをセッションに保存
        $page = $request->query('page');
        $request->session()->put('page', $page);

        // $idを使って必要な処理を行う
        $review = Review::find($id);

        // リクエストデータをセッションに保存
        $request->session()->put('member_id', $review->member_id);
        $request->session()->put('product_id', $review->product_id);
        $request->session()->put('evaluation', $review->evaluation);
        $request->session()->put('review_comment', $review->comment);

        $members = Member::all();
        $products = Product::all();

        return view('admin.review.regist', compact('products', 'members', 'review'));
    }

    // 登録処理、確認画面に遷移
    public function showReviewEditConfirm(Request $request)
    {

        $review_id = $request->input('review_id');
        $product_id = $request->input('product_id');
        $member_id = $request->input('member_id');
        $evaluation = $request->input('evaluation');
        $review_comment = $request->input('review_comment');

        $request->validate([
            'product_id' => ['required', 'numeric', new ProductValue],
            'member_id' => ['required', 'numeric', new MemberValue],
            'evaluation' => ['required', 'numeric', 'between:1,5'],
            'review_comment' => ['required', 'max:500'],
        ], [
            'product_id.required' => '※値を入力してください。',
            'product_id.numeric' => '※値を数値にしてください。',
            'member_id.required' => '※値を入力してください。',
            'member_id.numeric' => '※値を数値にしてください。',
            'evaluation.required' => '※商品評価を入力してください。',
            'evaluation.numeric' => '※値を入力してください。',
            'evaluation.between' => '※値は1~5で入力してください。',
            'review_comment.required' => '※商品コメントを入力してください。',
            'review_comment.max' => '※商品コメントは500文字以内で入力してください。',
        ]);

        // 商品情報を取得
        $product = DB::table('products')
            ->select('*')
            ->where('id', $product_id)
            ->first();

        // 会員情報を取得
        $member = DB::table('members')
            ->select('*')
            ->where('id', $member_id)
            ->first();

        // レビューの総合評価取得
        $average = DB::table('reviews')
            ->where('product_id', $product_id)
            ->avg('evaluation');

        $average = ceil($average);

        return view('admin.review.confirm', compact('review_id', 'product_id', 'member_id', 'evaluation', 'review_comment', 'product', 'member', 'average', 'request'));
    }

    // 編集完了処理
    public function showReviewEditComplete(Request $request)
    {
        $review_id = $request->input('review_id');

        if ($request->input('back') == 'back') {
            return redirect('/admin_review_edit/' . $review_id)->withInput();
        }

        // 指定されたIDに対応する既存のレビューレコードを取得
        $review = Review::findOrFail($review_id);

        // レビュー情報を更新
        $review->update([
            'member_id' => $request->input('member_id'),
            'product_id' => $request->input('product_id'),
            'evaluation' => $request->input('evaluation'),
            'comment' => $request->input('review_comment'),
        ]);

        $request->session()->regenerateToken();

        return redirect()->route('admin_review_list');
    }

    // レビュー詳細画面に遷移
    public function showReviewDetail(Request $request, $id)
    {
        $is_login = Auth::guard('admin')->check();

        if ($is_login === false) {
            return redirect()->route('show_admin_login');
        }

        // ページをセッションに保存
        $page = $request->query('page');
        $request->session()->put('page', $page);

        // $idを使って必要な処理を行う
        $review = Review::find($id);

        $product_id = $review->product_id;

        // 商品情報を取得
        $product = DB::table('products')
            ->select('*')
            ->where('id', $product_id)
            ->first();

        // レビューの総合評価取得
        $average = DB::table('reviews')
            ->where('product_id', $product_id)
            ->avg('evaluation');

        $average = ceil($average);

        return view('admin.review.detail', compact('review', 'product', 'average'));
    }

    // 削除処理後、商品レビュー一覧画面に遷移
    public function showReviewDelete(Request $request)
    {
        $id = $request->input('id');

        // レビューモデルを取得して削除
        $review = Review::where('id', $id)->first();
        if ($review) {
            $review->delete();
        }

        $request->session()->regenerateToken();

        return redirect()->route('admin_review_list');
    }
}
