<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;

use App\Rules\CategoryValue;
use App\Rules\SubCategoryValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function showRegist()
    {
        $categories = Category::all();
        $user = Auth::user();
        if ($user === null) {
            return redirect()->route('top');
        } else {
            return view('product.regist', compact('categories', 'user'));
        }
    }

    public function getSubcategories(Request $request)
    {
        // Ajaxリクエストから選択されたカテゴリーのIDを取得
        $categoryId = $request->input('category_id');

        // カテゴリーIDに関連するサブカテゴリーを取得
        $subcategories = Subcategory::where('product_category_id', $categoryId)->get();

        // サブカテゴリーの選択肢をHTML形式で返す
        $options = '<option value="">サブカテゴリーを選択してください</option>';
        foreach ($subcategories as $subcategory) {
            $options .= '<option value="' . $subcategory->id . '"';
            if (session('subcategory') == $subcategory->id) {
                $options .= ' selected';
            }
            $options .= '>' . $subcategory->name . '</option>';
        }

        // サブカテゴリーの選択肢を設定する
        return response()->json(['options' => $options, 'selected' => session('subcategory')]);        // // 取得したサブカテゴリーをビューに渡して、Ajaxリクエストに応答
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
    public function showConfirm(Request $request)
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
            'product_name' => ['required', 'max:100'],
            'category' => ['required', 'numeric', new CategoryValue],
            'subcategory' => ['required', 'numeric', new SubCategoryValue],
            'product_text' => ['required', 'max:500'],
        ], [
            'product_name.required' => '※商品名を入力してください。',
            'product_name.max' => '※商品名は100文字以内で入力してください。',
            'category.required' => '※値を入力してください。',
            'category.numeric' => '※値を数値にしてください。',
            'subcategory.required' => '※値を入力してください。',
            'subcategory.numeric' => '※値を数値にしてください。',
            'product_text.required' => '※商品説明を入力してください。',
            'product_text.max' => '※商品説明は500文字以内で入力してください。',
        ]);

        $categoryName = DB::table('product_categories')->where('id', $category)->value('name');
        $categoryNameSub = DB::table('product_subcategories')->where('id', $subcategory)->value('name');

        $request->session()->put('categoryName', $categoryName);
        $request->session()->put('categoryNameSub', $categoryNameSub);


        return view('product.confirm');
    }

    public function showComplete(Request $request)
    {
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

        return redirect()->route('login_top');
    }

    public function showList()
    {
        $is_login = Auth::check();
        $products = DB::table('products')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->join('product_subcategories', 'products.product_subcategory_id', '=', 'product_subcategories.id')
            ->select('products.*', 'product_categories.name as category_name', 'product_subcategories.name as subcategory_name')
            ->orderByDesc('products.id')
            ->paginate(10);
        $categories = Category::all();
        return view('product.list', ['is_login' => $is_login, 'categories' => $categories, 'products' => $products]);
    }
}
