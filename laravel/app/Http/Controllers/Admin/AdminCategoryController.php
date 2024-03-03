<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    // カテゴリ登録画面に遷移
    public function showCategoryRegist()
    {
        $is_login = Auth::guard('admin')->check();

        if ($is_login === false) {
            return redirect()->route('show_admin_login');
        }

        return view('admin.category.regist');
    }

    // カテゴリ登録確認画面に遷移
    public function showCategoryConfirm(Request $request)
    {
        $category = $request->input('category');
        $subcategories = $request->input('subcategory') ?? [];

        $rules = [
            'category' => 'required|max:20',
            'subcategory.*' => 'max:20',
        ];

        $messages = [
            'category.required' => '※カテゴリ大を入力してください。',
            'category.max' => '※カテゴリ大は20文字以内で入力してください。',
            'subcategory.*.max' => '※カテゴリ小は20文字以内で入力してください。',
        ];

        // サブカテゴリが空でないことを確認
        if (empty(array_filter($subcategories))) {
            $rules['subcategory.0'] = 'required'; 
            $messages['subcategory.0.required'] = '※カテゴリ小を最低でも1つ入力してください。';
        }

        $request->validate($rules, $messages);

        return view('admin.category.confirm', compact('category', 'subcategories'));
    }

    // カテゴリ登録完了処理
    public function showCategoryComplete(Request $request)
    {
        if ($request->input('back') == 'back') {
            return redirect('/admin_category_regist')->withInput();
        }

        DB::beginTransaction();
        try {
            $category = new Category();

            $created_category = $category->create([
                'name' => $request->input('category'),
            ]);

            $id = $created_category->id;

            $subcategories = $request->input('subcategory');

            foreach ($subcategories as $subcategory) {
                if (is_null($subcategory)) {
                    continue;
                }
                $subcategory_insert = new Subcategory();
                $subcategory_insert->create([
                    'product_category_id' => $id,
                    'name' => $subcategory,
                ]);
            }

            $request->session()->regenerateToken();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return redirect()->route('admin_category_list');
    }

    // カテゴリ編集画面に遷移
    public function showCategoryEdit(Request $request, $id)
    {
        $is_login = Auth::guard('admin')->check();

        if ($is_login === false) {
            return redirect()->route('show_admin_login');
        }

        // ページをセッションに保存
        $page = $request->query('page');
        $request->session()->put('page', $page);

        // $idを使って必要な処理を行う
        $category = Category::find($id);
        $category->load('subcategories');

        return view('admin.category.regist', ['category' => $category]);
    }

    // カテゴリ編集確認画面に遷移
    public function showCategoryEditConfirm(Request $request)
    {
        $id = $request->input('id');
        $category = $request->input('category');
        $subcategories = $request->input('subcategory') ?? [];

        $rules = [
            'category' => 'required|max:20',
            'subcategory.*' => 'max:20',
        ];

        $messages = [
            'category.required' => '※カテゴリ大を入力してください。',
            'category.max' => '※カテゴリ大は20文字以内で入力してください。',
            'subcategory.*.max' => '※カテゴリ小は20文字以内で入力してください。',
        ];

        // サブカテゴリが空でないことを確認
        if (empty(array_filter($subcategories))) {
            $rules['subcategory.0'] = 'required'; 
            $messages['subcategory.0.required'] = '※カテゴリ小を最低でも1つ入力してください。';
        }

        $request->validate($rules, $messages);

        return view('admin.category.confirm', compact('id', 'category', 'subcategories'));
    }

    // カテゴリ編集完了処理
    public function showCategoryEditComplete(Request $request)
    {
        $id = $request->input('id');

        if ($request->input('back') == 'back') {
            return redirect('/admin_category_edit/' . $id)->withInput();
        }

        DB::beginTransaction();
        try {
            // 指定されたIDに対応する既存のカテゴリレコードを取得
            $category = Category::findOrFail($id);

            $category->update([
                'name' => $request->input('category'),
            ]);

            // 既存のサブカテゴリを削除
            $category->subcategories()->delete();

            $subcategories = $request->input('subcategory');

            foreach ($subcategories as $subcategory) {
                if (is_null($subcategory)) {
                    continue;
                }
                $subcategory_insert = new Subcategory();
                $subcategory_insert->create([
                    'product_category_id' => $id,
                    'name' => $subcategory,
                ]);
            }

            $request->session()->regenerateToken();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return redirect()->route('admin_category_list');
    }
}
