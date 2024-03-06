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
            <h2>商品レビュー詳細</h2>
        </div>
        <div class="admin_header_contents">
            <a href="{{ route('admin_review_list', ['page' => session('page')]) }}" class="admin_logout_btn">一覧へ戻る</a>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="detail_contents admin_review_border">
                <div class="product_view">
                    <img src="{{ $product->image_1 }}" alt="" class="review_img">
                    <div class="product_view_text">
                        <p>商品ID {{ $product->id }}</p>
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

            <form action="{{ route('admin_review_delete') }}" method="post">
                @csrf
                <div class="item_group">
                    <div class="input_name">
                        <p class="sub_title">ID</p>
                        <p class="confirm_item_contents">{{ $review->id }}</p>
                        <input type="hidden" name="id" value="{{ $review->id }}">
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title">商品評価</p>
                        <p class="confirm_item_contents">{{ $review->evaluation }}</p>
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title">商品コメント</p>
                        <p class="confirm_item_contents">{{ $review->comment }}</p>
                    </div>
                </div>

                <div class="admin_member_detail_btn_group">
                    <a href="{{ route('admin_review_edit', ['id' => $review->id, 'page' => session('page')]) }}" class="admin_member_detail_btn">編集</a>
                    <input type="submit" class="admin_member_delete_btn" value="削除">
                </div>
            </form>
        </div>
    </main>

</body>

</html>