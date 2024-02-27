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
                <h2 class="header_h2">商品レビュー登録確認</h2>
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

            <div class="review_complete_text">
                <p>商品レビューの登録が完了しました。</p>
            </div>

            <div class="review_submit">
                <a href="{{ route('review_list', ['id' => $product->id]) }}" class="review_subimt_btn">商品レビュー一覧へ</a>
            </div>

            <div class="detail_back_submit">
                <a href="{{ route('product_detail', ['id' => $product->id, 'page' => session('page')]) }}" class="review_submit_back_btn">商品詳細に戻る</a>
            </div>
        </div>
    </main>
</body>

</html>