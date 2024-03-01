<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCategoryController extends Controller
{
    // 一覧画面に遷移
    public function showCategoryList()
    {
        $is_login = Auth::guard('admin')->check();

        if ($is_login === false) {
            return redirect()->route('show_admin_login');
        }

        // 検索条件のセッションをクリア
        session()->forget('category_search_id');
        session()->forget('category_search_freeword');

        $categories = Category::sortable()->orderBy('id', 'desc')->paginate(10);
        return view('admin.category.list', ['categories' => $categories]);
    }

    // 検索処理
    public function showCategorySearch(Request $request)
    {
        // 昇降順を取得
        $direction = $request->query('direction');
        $sort = $request->query('sort');

        // フォームから送信された検索クエリを取得
        $category_search_id = $request->input('category_search_id');
        $category_search_freeword = $request->input('category_search_freeword');

        $request->session()->put('category_search_id', $category_search_id);
        $request->session()->put('category_search_freeword', $category_search_freeword);

        $categories = Category::where(function ($query) use ($category_search_id, $category_search_freeword) {
            if ($category_search_id) {
                $query->where('id', $category_search_id);
            }
            if ($category_search_freeword) {
                $query->where('name', 'like', '%' . $category_search_freeword . '%')
                    ->orWhereHas('subcategories', function ($subquery) use ($category_search_freeword) {
                        $subquery->where('name', 'like', '%' . $category_search_freeword . '%');
                    });
            }
        });

        if ($direction == 'asc') {
            $categories = $categories->sortable()->orderBy('id', 'asc')->paginate(10);
        } else {
            $categories = $categories->sortable()->orderBy('id', 'desc')->paginate(10);
        }

        return view('admin.category.list', ['categories' => $categories, 'direction' => $direction, 'sort' => $sort]);
    }
}
