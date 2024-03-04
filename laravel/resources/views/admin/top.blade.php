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
            <h2>管理画面メインメニュー</h2>
        </div>
        <div class="admin_header_contents">
            <p>ようこそ{{ $admin->name }}さん</p>
            <a href="{{ route('admin_logout') }}" class="admin_logout_btn">ログアウト</a>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="admin_top_btn_group">
                <a href="{{ route('admin_member_list') }}" class="admin_top_list_btn">会員一覧</a>
            </div>
            <div class="admin_top_btn_group admin_top_second_btn">
                <a href="{{ route('admin_category_list') }}" class="admin_top_list_btn">商品カテゴリ一覧</a>
            </div>
            <div class="admin_top_btn_group admin_top_second_btn">
                <a href="{{ route('admin_product_list') }}" class="admin_top_list_btn">商品一覧</a>
            </div>
        </div>
    </main>

</body>

</html>