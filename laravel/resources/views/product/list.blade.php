<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>福岡 laravel課題</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <header>
        <div class="product_list_header">
            <div class="product_list_header">
                <h2 class="header_h2">商品一覧</h2>
            </div>
            @if ($is_login)
            <div>
                <a href="{{ route('product_regist') }}" class="list_header_product_btn">新規商品登録</a>
            </div>
            @endif
        </div>
    </header>

    <main>
        <div class="container">
            <div class="product_search">
                <div class="search_items">
                    <p>カテゴリ</p>
                    <div class="search_category">
                        <select id="category" name="category" class="category_select">
                            <option value="">カテゴリを選択してください</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>

                        <div id="subcategory-list">
                            <!-- サブカテゴリーを表示する -->
                        </div>
                    </div>
                </div>
                <div class="search_items">
                    <p>フリーワード</p>
                    <input type="text" name="product_search_freeword">
                </div>
                <div class="search_submit_btn">
                    <input type="submit" value="商品検索">
                </div>
            </div>

            <div>
                @foreach ($products as $product)
                <div class="list_items">
                    <img src="{{ $product->image_1 }}" alt="商品画像" class="product_list_img">
                    <div class="item_contents_group">
                        <div class="items_category">{{ $product->category_name }} > {{ $product->subcategory_name }}</div>
                        <p>{{ $product->name }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- ページネーションリンクを表示 -->
            {{ $products->onEachSide(0)->links() }}

            <div class="list_back_btn">
                <a href="{{ route('login_top') }}" class="login_submit login_back_submit">トップに戻る</a>
            </div>

        </div>
    </main>
    <script>
        // selectbox選択肢表示
        // =================
        $(document).ready(function() {
            $('#category').change(function() {
                var categoryId = $(this).val();

                $.ajax({
                    url: "{{ route('getSubcategories') }}",
                    method: 'get',
                    data: {
                        category_id: categoryId
                    },
                    success: function(response) {
                        $('#subcategory-list').html(response);
                    }
                });
            });
        });
    </script>

</body>

</html>