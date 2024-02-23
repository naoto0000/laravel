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
                <h2 class="header_h2">商品詳細</h2>
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
                <div class="detail_category">{{ $product->category_name }} > {{ $product->subcategory_name }}</div>
                <div class="detail_name_group">
                    <h3>{{ $product->name }}</h3>
                    <p>更新日時：{{ $product->updated_at }}</p>
                </div>
                <div class="detail_img">
                    <img src="{{ $product->image_1 }}" alt="商品画像1">
                    <img src="{{ $product->image_2 }}" alt="商品画像2">
                    <img src="{{ $product->image_3 }}" alt="商品画像3">
                    <img src="{{ $product->image_4 }}" alt="商品画像4">
                </div>
                <div class="detail_text">
                    <p>◾️商品説明</p>
                    <p class="detail_text_contents">{{ $product->product_content }}</p>
                </div>
                <div class="detail_review">
                    <p>◾️商品レビュー</p>
                    <div class="detail_review_contents">
                        <p class="total_review">総合評価</p>
                        <div class="review_average">
                            <p>
                                @for ($i = 0; $i < $average; $i++) ★ @endfor
                            </p>
                            <p>{{ $average }}</p>
                        </div>
                    </div>
                </div>

                <a href="{{ route('review_list', ['id' => $product->id, 'page' => $request->query('page')]) }}" class="review_link">>>レビューを見る</a>

            </div>

            <!-- ログイン時のみレビュー登録に遷移可能 -->
            @if ($is_login)
            <div class="review_regist_btn_group">
                <a href="{{ route('review_regist', ['id' => $product->id, 'page' => $request->query('page')]) }}" class="review_regist_btn">この商品についてのレビューを登録</a>
            </div>
            @endif

            <div class="detail_back">
                @if (session('referer_detail') === 1)
                <a href="{{ route('product_list', ['page' => $request->query('page')]) }}" class="detail_back_btn">商品一覧に戻る</a>
                @else
                <a href="{{ route('product_search', ['category' => session('category'), 'subcategory' => session('subcategory'), 'product_search_freeword' => session('product_search_freeword'), 'page' => $request->query('page')]) }}" class="detail_back_btn">商品一覧に戻る</a>
                @endif
            </div>
        </div>
    </main>
</body>

</html>