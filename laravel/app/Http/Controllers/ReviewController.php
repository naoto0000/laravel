<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    // レビュー一覧画面へ遷移
    public function showList(Request $request)
    {
        $is_login = Auth::check();

        // ルーティングからIDを取得
        $id = $request->route('id');

        $product = DB::table('products')
            ->select('*')
            ->where('id', $id)
            ->first();

        // レビューの総合評価取得
        $average = DB::table('reviews')
            ->where('product_id', $id)
            ->avg('evaluation');

        $average = ceil($average);

        // レビュー取得
        $reviews = DB::table('reviews')
            ->join('members', 'reviews.member_id', '=', 'members.id')
            ->select('reviews.*', 'members.name_sei as name_sei', 'members.name_mei as name_mei')
            ->where('reviews.product_id', $id)
            ->orderByDesc('reviews.id')
            ->paginate(5);

        // 商品情報を詳細ビューに渡して表示
        return view('review.list', compact('is_login', 'product', 'average', 'reviews', 'request'));
    }

    // レビュー登録画面へ遷移
    public function showRegist(Request $request)
    {
        $is_login = Auth::check();

        if ($is_login === false) {
            return redirect()->route('top');
        }

        // ルーティングからIDを取得
        $id = $request->route('id');

        $product = DB::table('products')
            ->select('*')
            ->where('id', $id)
            ->first();

        // レビューの総合評価取得
        $average = DB::table('reviews')
            ->where('product_id', $id)
            ->avg('evaluation');

        $average = ceil($average);

        // 商品情報を詳細ビューに渡して表示
        return view('review.regist', compact('is_login', 'product', 'average', 'request'));
    }

    // 確認画面に遷移
    public function showConfirm(Request $request)
    {
        $is_login = Auth::check();

        // ルーティングからIDを取得
        $id = $request->route('id');

        $product = DB::table('products')
            ->select('*')
            ->where('id', $id)
            ->first();

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

        // レビューの総合評価取得
        $average = DB::table('reviews')
            ->where('product_id', $id)
            ->avg('evaluation');

        $average = ceil($average);

        return view('review.confirm', compact('is_login', 'product', 'average', 'request'));
    }

    public function showComplete(Request $request)
    {

        $is_login = Auth::check();
        $user = Auth::user();

        // ルーティングからIDを取得
        $id = $request->route('id');

        $product = DB::table('products')
            ->select('*')
            ->where('id', $id)
            ->first();

        $review = new Review();

        $review->create([
            'member_id' => $user->id,
            'product_id' => $id,
            'evaluation' => $request->input('evaluation'),
            'comment' => $request->input('review_comment'),
        ]);

        $request->session()->regenerateToken();

        return view('review.complete', compact('is_login', 'product', 'request'));
    }
}
