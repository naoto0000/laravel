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
            <h2>商品一覧</h2>
        </div>
        <div class="admin_header_contents">
            <a href="{{ route('admin_top') }}" class="admin_logout_btn">トップへ戻る</a>
        </div>
    </header>

    <main>
        <div class="admin_list_container">
            <div class="admin_list_regist">
                <a href="{{ route('admin_product_regist') }}" class="admin_list_regist_btn">商品登録</a>
            </div>
            <div class="member_search">
                <form action="{{ route('admin_product_list_search') }}" method="get">
                    <table class="search_admin_group">
                        <tr class="search_items">
                            <td>
                                <p class="admin_search_item_p">ID</p>
                            </td>
                            <td><input type="text" name="product_search_id" value="{{ session('product_search_id') }}"></td>
                        </tr>
                        <tr class="search_items">
                            <td>
                                <p class="admin_search_item_p">フリーワード</p>
                            </td>
                            <td><input type="text" name="product_search_freeword" value="{{ session('product_search_freeword') }}"></td>
                        </tr>
                    </table>
                    <input type="hidden" name="direction" value="{{ request()->query('direction') }}">
                    <input type="hidden" name="sort" value="{{ request()->query('sort') }}">
                    <div class="admin_search_submit_btn">
                        <input type="submit" value="検索する" class="admin_search_submit">
                    </div>
                </form>
            </div>

            <div class="admin_member_list">
                <table class="admin_member_list_display">
                    <tr class="admin_member_table_line">
                        <th class="admin_member_table_th">ID
                            @if(request()->query('direction') === 'asc' && request()->query('sort') === 'id')
                            @sortablelink('id', '▲')
                            @else
                            @sortablelink('id', '▼')
                            @endif
                        </th>
                        <th class="admin_member_table_th">商品名</th>
                        <th class="admin_member_table_th">登録日時
                            @if(request()->query('direction') === 'asc' && request()->query('sort') === 'created_at')
                            @sortablelink('created_at', '▲')
                            @else
                            @sortablelink('created_at', '▼')
                            @endif
                        </th>
                        <th class="admin_member_table_th">編集</th>
                        <th class="admin_member_table_th">詳細</th>
                    </tr>
                    @foreach ($products as $product)
                    <tr class="admin_member_table_line">
                        <td class="admin_member_table_td">{{ $product->id }}</td>
                        <td class="admin_member_table_td">
                            <a href="{{ route('admin_product_detail', ['id' => $product->id, 'list_page' => $products->currentPage()]) }}">
                            {{ $product->name }}
                            </a>
                        </td>
                        <td class="admin_member_table_td">{{ $product->created_at->format('Y/m/d') }}</td>
                        <td class="admin_member_table_td"><a href="{{ route('admin_product_edit', ['id' => $product->id, 'page' => $products->currentPage()]) }}">編集</a></td>
                        <td class="admin_member_table_td"><a href="{{ route('admin_product_detail', ['id' => $product->id, 'list_page' => $products->currentPage()]) }}">詳細</a></td>
                    </tr>
                    @endforeach
                </table>
            </div>

            <!-- ページネーションリンクを表示 -->
            {{ $products->appends(request()->query())->onEachSide(0)->links() }}

        </div>
    </main>

</body>

</html>