<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>福岡 laravel課題</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <header>

        <div class="mypage_header_link">
            <p class="mypage_header">商品レビュー管理</p>

            <div class="header_btn_login">
                <div>
                    <a href="{{ route('login_top') }}" class="header_product_btn">トップに戻る</a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div>
                @foreach ($reviews as $review)
                <div class="list_items">
                    <img src="{{ $review->product_image }}" alt="商品画像" class="product_list_img">
                    <div class="item_contents_group">
                        <div class="mypage_product_list_right">
                            <div class="items_category">{{ $review->category_name }} > {{ $review->subcategory_name }}</div>
                            <p>{{ $review->product_name }}</p>
                            <div class="list_item_evaluation">
                                <p class="list_star">
                                    @for ($i = 0; $i < ceil($review->evaluation); $i++) ★ @endfor
                                </p>
                                <p class="product_list_review">{{ ceil($review->evaluation) }}</p>
                            </div>
                            <p>{{ mb_strlen($review->comment) > 15 ? mb_substr($review->comment, 0, 15) . '...' : $review->comment }}</p>
                            <div class="mypage_review_btn_group">
                                <a href="{{ route('mypage_review_edit', ['id' => $review->id, 'page' => $reviews->currentPage()]) }}" class="mypage_review_btn">レビュー編集</a>
                                <a href="{{ route('mypage_review_withdraw', ['id' => $review->id, 'page' => $reviews->currentPage()]) }}" class="mypage_review_btn">レビュー削除</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- ページネーションリンクを表示 -->
            {{ $reviews->appends(request()->query())->onEachSide(0)->links() }}

            <div class="mypage_edit_btn">
                <a href="{{ route('mypage') }}" class="mypage_withdraw_btn">マイページに戻る</a>
            </div>
        </div>
    </main>

</body>

</html>