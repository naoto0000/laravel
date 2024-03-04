<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProductController extends Controller
{
    // 商品一覧画面に遷移
    public function showProductList()
    {
        $is_login = Auth::guard('admin')->check();

        if ($is_login === false) {
            return redirect()->route('show_admin_login');
        }

        // 検索条件のセッションをクリア
        session()->forget('product_search_id');
        session()->forget('product_search_freeword');

        $products = Product::sortable()->orderBy('id', 'desc')->paginate(10);
        return view('admin.product.list', ['products' => $products]);
    }

    // 検索処理
    public function showProductSearch(Request $request)
    {
        // 昇降順を取得
        $direction = $request->query('direction');
        $sort = $request->query('sort');

        // フォームから送信された検索クエリを取得
        $product_search_id = $request->input('product_search_id');
        $product_search_freeword = $request->input('product_search_freeword');

        $request->session()->put('product_search_id', $product_search_id);
        $request->session()->put('product_search_freeword', $product_search_freeword);

        $products = Product::where(function ($query) use ($product_search_id, $product_search_freeword) {
            if ($product_search_id) {
                $query->where('id', $product_search_id);
            }
            if ($product_search_freeword) {
                $query->where(function ($query) use ($product_search_freeword) {
                    $query->where('name', 'like', '%' . $product_search_freeword . '%')
                        ->orWhere('product_content', 'like', '%' . $product_search_freeword . '%');
                });
            }
        });

        if ($direction == 'asc') {
            $products = $products->sortable()->orderBy('created_at', 'asc')->paginate(10);
        } else {
            $products = $products->sortable()->orderBy('created_at', 'desc')->paginate(10);
        }

        return view('admin.product.list', ['products' => $products, 'direction' => $direction, 'sort' => $sort]);
    }
}
