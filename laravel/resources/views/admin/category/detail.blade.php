<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>福岡 laravel課題</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="admin_body">
    <header class="admin_header">
        <div class="admin_header_title">
            <h2>商品カテゴリ詳細</h2>
        </div>
        <div class="admin_header_contents">
            <a href="{{ route('admin_category_list', ['page' => session('page')]) }}" class="admin_logout_btn">一覧へ戻る</a>
        </div>
    </header>

    <main>
        <div class="container">
            <form action="{{ route('admin_category_delete') }}" method="post">
                @csrf
                <div class="item_group">
                    <div class="input_name">
                        <p class="admin_sub_title">商品大カテゴリID</p>
                        <p class="confirm_item_contents">{{ $category->id }}</p>
                        <input type="hidden" name="id" value="{{ $category->id }}">
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_name">
                        <p class="admin_sub_title">商品大カテゴリ</p>
                        <p class="confirm_item_contents">{{ $category->name }}</p>
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="admin_sub_title">商品小カテゴリ</p>
                        <div>
                            @foreach ($category->subcategories as $subcategory)
                            <p class="confirm_item_contents">{{ $subcategory->name }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="admin_member_detail_btn_group">
                    <a href="{{ route('admin_category_edit', ['id' => $category->id, 'page' => session('page')]) }}" class="admin_member_detail_btn">編集</a>
                    <input type="submit" class="admin_member_delete_btn" value="削除">
                </div>
            </form>
        </div>
    </main>

</body>

</html>