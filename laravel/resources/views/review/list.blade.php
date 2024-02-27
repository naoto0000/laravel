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
                <h2 class="header_h2">商品レビュー一覧</h2>
            </div>
            @if ($is_login)
            <div>
                <a href="{{ route('login_top') }}" class="list_header_product_btn">トップに戻る</a>
            </div>
            @else
            <div>
                <a href="{{ route('top') }}" class="list_header_product_btn">トップに戻る</a>
            </div>
            @endif
        </div>
    </header>

    <main>
        <div class="detail_container">
            <div class="detail_contents">
                <div class="product_view">
                    <img src="{{ $product->image_1 }}" alt="" class="review_img">
                    <div class="product_view_text">
                        <p>{{ $product->name }}</p>
                        <div class="detail_review_contents">
                            <p class="total_review">総合評価</p>
                            <div class="review_average">
                                <p>
                                    @for ($i = 0; $i < $average; $i++) ★ @endfor </p>
                                        <p>{{ $average }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                @foreach ($reviews as $review)
                <div class="review_items">
                    <div class="review_item">
                        <h3>{{ $review->name_sei }}{{ $review->name_mei }}さん</h3>
                        <div class="review_average">
                            <p>
                                @for ($i = 0; $i < $review->evaluation; $i++) ★ @endfor </p>
                            <p>{{ $review->evaluation }}</p>
                        </div>
                    </div>
                    <div class="review_item">
                        <h3>商品コメント</h3>
                        <p class="review_item_comment">{{ $review->comment }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- ページネーションリンクを表示 -->
            {{ $reviews->appends(request()->query())->onEachSide(0)->links() }}

            <div class="detail_list_back">
                <a href="{{ route('product_detail', ['id' => $product->id, 'page' => session('page')]) }}" class="detail_list_back_btn">商品詳細に戻る</a>
            </div>
        </div>
    </main>
</body>

</html>