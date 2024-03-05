<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Member;
use App\Models\Product;
use App\Models\Subcategory;
use App\Rules\CategoryValue;
use App\Rules\MemberValue;
use App\Rules\SubCategoryValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        // 商品登録のセッションをクリア
        session()->forget('member_id');
        session()->forget('product_name');
        session()->forget('category');
        session()->forget('subcategory');
        session()->forget('image1');
        session()->forget('image2');
        session()->forget('image3');
        session()->forget('image4');
        session()->forget('product_text');

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

    // 会員登録画面に遷移
    public function showProductRegist()
    {
        $is_login = Auth::guard('admin')->check();

        if ($is_login === false) {
            return redirect()->route('show_admin_login');
        }

        $members = Member::all();
        $categories = Category::all();

        return view('admin.product.regist', compact('members', 'categories'));
    }

    public function getSubcategories(Request $request)
    {
        // Ajaxリクエストから選択されたカテゴリーのIDを取得
        $categoryId = $request->input('category_id');
        $subcategoryId = $request->input('subcategory');

        // カテゴリーIDに関連するサブカテゴリーを取得
        $subcategories = Subcategory::where('product_category_id', $categoryId)->get();

        // サブカテゴリーの選択肢をHTML形式で返す
        $options = '<option value="">サブカテゴリーを選択してください</option>';
        foreach ($subcategories as $subcategory) {
            $options .= '<option value="' . $subcategory->id . '"';
            if ($subcategoryId == $subcategory->id) {
                $options .= ' selected';
            } elseif (session('subcategory') == $subcategory->id) {
                $options .= ' selected';
            }
            $options .= '>' . $subcategory->name . '</option>';
        }

        if ($subcategoryId) {
            // サブカテゴリーの選択肢を設定する
            return response()->json(['options' => $options, 'selected' => $subcategoryId]);// // 取得したサブカテゴリーをビューに渡して、Ajaxリクエストに応答
        } else {
            // サブカテゴリーの選択肢を設定する
            return response()->json(['options' => $options, 'selected' => session('subcategory')]);// // 取得したサブカテゴリーをビューに渡して、Ajaxリクエストに応答

        }
    }

    // 画像アップロード
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public', $fileName); // ファイルを保存するディレクトリは storage/app/public になります
            $imageUrl = asset('storage/' . str_replace('public/', '', $filePath)); // 保存した画像のURLを取得
            return response()->json(['imageUrl' => $imageUrl]);
        } else {
            return response()->json(['error' => 'File not found.'], 404);
        }
    }

    // 確認画面に遷移
    public function adminShowConfirm(Request $request)
    {

        $member_id = $request->input('member_id');
        $product_name = $request->input('product_name');
        $category = $request->input('category');
        $subcategory = $request->input('subcategory');
        $image1 = $request->input('image1');
        $image2 = $request->input('image2');
        $image3 = $request->input('image3');
        $image4 = $request->input('image4');
        $product_text = $request->input('product_text');

        // リクエストデータをセッションに保存
        $request->session()->put('member_id', $member_id);
        $request->session()->put('product_name', $product_name);
        $request->session()->put('category', $category);
        $request->session()->put('subcategory', $subcategory);
        $request->session()->put('image1', $image1);
        $request->session()->put('image2', $image2);
        $request->session()->put('image3', $image3);
        $request->session()->put('image4', $image4);
        $request->session()->put('product_text', $product_text);


        $request->validate([
            'member_id' => ['required', 'numeric', new MemberValue],
            'product_name' => ['required', 'max:100'],
            'category' => ['required', 'numeric', new CategoryValue],
            'subcategory' => ['required', 'numeric', new SubCategoryValue],
            'product_text' => ['required', 'max:500'],
        ], [
            'member_id.required' => '※値を入力してください。',
            'member_id.numeric' => '※値を数値にしてください。',
            'product_name.required' => '※商品名を入力してください。',
            'product_name.max' => '※商品名は100文字以内で入力してください。',
            'category.required' => '※値を入力してください。',
            'category.numeric' => '※値を数値にしてください。',
            'subcategory.required' => '※値を入力してください。',
            'subcategory.numeric' => '※値を数値にしてください。',
            'product_text.required' => '※商品説明を入力してください。',
            'product_text.max' => '※商品説明は500文字以内で入力してください。',
        ]);

        $memberNameSei = DB::table('members')->where('id', $member_id)->value('name_sei');
        $memberNameMei = DB::table('members')->where('id', $member_id)->value('name_mei');
        $categoryName = DB::table('product_categories')->where('id', $category)->value('name');
        $categoryNameSub = DB::table('product_subcategories')->where('id', $subcategory)->value('name');

        $request->session()->put('memberNameSei', $memberNameSei);
        $request->session()->put('memberNameMei', $memberNameMei);
        $request->session()->put('categoryName', $categoryName);
        $request->session()->put('categoryNameSub', $categoryNameSub);

        return view('admin.product.confirm');
    }

    // 登録完了処理
    public function adminShowComplete(Request $request)
    {
        if ($request->input('back') == 'back') {
            return redirect('/admin_product_regist');
        }

        $product = new Product();

        $product->create([
            'member_id' => $request->input('member_id'),
            'product_category_id' => $request->input('category'),
            'product_subcategory_id' => $request->input('subcategory'),
            'name' => $request->input('product_name'),
            'image_1' => $request->input('image1'),
            'image_2' => $request->input('image2'),
            'image_3' => $request->input('image3'),
            'image_4' => $request->input('image4'),
            'product_content' => $request->input('product_text'),
        ]);

        $request->session()->regenerateToken();

        return redirect()->route('admin_product_list');
    }

    // 商品編集画面に遷移
    public function showProductEdit(Request $request, $id)
    {
        $is_login = Auth::guard('admin')->check();

        if ($is_login === false) {
            return redirect()->route('show_admin_login');
        }

        // ページをセッションに保存
        $page = $request->query('page');
        $request->session()->put('page', $page);

        // $idを使って必要な処理を行う
        $product = Product::find($id);

        // リクエストデータをセッションに保存
        $request->session()->put('member_id', $product->member_id);
        $request->session()->put('product_name', $product->name);
        $request->session()->put('category', $product->product_category_id);
        $request->session()->put('subcategory', $product->product_subcategory_id);
        $request->session()->put('image1', $product->image_1);
        $request->session()->put('image2', $product->image_2);
        $request->session()->put('image3', $product->image_3);
        $request->session()->put('image4', $product->image_4);
        $request->session()->put('product_text', $product->product_content);

        $members = Member::all();
        $categories = Category::all();

        return view('admin.product.regist', compact('product', 'members', 'categories'));
    }

    // 編集確認画面に遷移
    public function showProductEditConfirm(Request $request)
    {

        $product_id = $request->input('product_id');
        $member_id = $request->input('member_id');
        $product_name = $request->input('product_name');
        $category = $request->input('category');
        $subcategory = $request->input('subcategory');
        $image1 = $request->input('image1');
        $image2 = $request->input('image2');
        $image3 = $request->input('image3');
        $image4 = $request->input('image4');
        $product_text = $request->input('product_text');

        // リクエストデータをセッションに保存
        $request->session()->put('product_id', $product_id);
        $request->session()->put('member_id', $member_id);
        $request->session()->put('product_name', $product_name);
        $request->session()->put('category', $category);
        $request->session()->put('subcategory', $subcategory);
        $request->session()->put('image1', $image1);
        $request->session()->put('image2', $image2);
        $request->session()->put('image3', $image3);
        $request->session()->put('image4', $image4);
        $request->session()->put('product_text', $product_text);


        $request->validate([
            'member_id' => ['required', 'numeric', new MemberValue],
            'product_name' => ['required', 'max:100'],
            'category' => ['required', 'numeric', new CategoryValue],
            'subcategory' => ['required', 'numeric', new SubCategoryValue],
            'product_text' => ['required', 'max:500'],
        ], [
            'member_id.required' => '※値を入力してください。',
            'member_id.numeric' => '※値を数値にしてください。',
            'product_name.required' => '※商品名を入力してください。',
            'product_name.max' => '※商品名は100文字以内で入力してください。',
            'category.required' => '※値を入力してください。',
            'category.numeric' => '※値を数値にしてください。',
            'subcategory.required' => '※値を入力してください。',
            'subcategory.numeric' => '※値を数値にしてください。',
            'product_text.required' => '※商品説明を入力してください。',
            'product_text.max' => '※商品説明は500文字以内で入力してください。',
        ]);

        $memberNameSei = DB::table('members')->where('id', $member_id)->value('name_sei');
        $memberNameMei = DB::table('members')->where('id', $member_id)->value('name_mei');
        $categoryName = DB::table('product_categories')->where('id', $category)->value('name');
        $categoryNameSub = DB::table('product_subcategories')->where('id', $subcategory)->value('name');

        $request->session()->put('memberNameSei', $memberNameSei);
        $request->session()->put('memberNameMei', $memberNameMei);
        $request->session()->put('categoryName', $categoryName);
        $request->session()->put('categoryNameSub', $categoryNameSub);

        return view('admin.product.confirm');
    }

    // 編集完了処理
    public function showProductEditComplete(Request $request)
    {
        $id = $request->input('product_id');

        if ($request->input('back') == 'back') {
            return redirect('/admin_product_edit/' . $id)->withInput();
        }

        // 指定されたIDに対応する既存の会員レコードを取得
        $product = Product::findOrFail($id);

        // 会員情報を更新
        $product->update([
            'member_id' => $request->input('member_id'),
            'product_category_id' => $request->input('category'),
            'product_subcategory_id' => $request->input('subcategory'),
            'name' => $request->input('product_name'),
            'image_1' => $request->input('image1'),
            'image_2' => $request->input('image2'),
            'image_3' => $request->input('image3'),
            'image_4' => $request->input('image4'),
            'product_content' => $request->input('product_text'),
        ]);

        $request->session()->regenerateToken();

        return redirect()->route('admin_product_list');
    }
}
