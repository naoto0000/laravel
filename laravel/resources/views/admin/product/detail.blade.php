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
            <h2>商品詳細</h2>
        </div>
        <div class="admin_header_contents">
            <a href="{{ route('admin_product_list', ['page' => session('list_page')]) }}" class="admin_logout_btn">一覧へ戻る</a>
        </div>
    </header>

    <main>
        <div class="container">
            <form action="{{ route('admin_product_delete') }}" method="post">
                @csrf
                <div class="item_group">
                    <div class="input_name">
                        <p class="sub_title">商品ID</p>
                        <p class="confirm_item_contents">{{ $product->id }}</p>
                        <input type="hidden" name="id" value="{{ $product->id }}">
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_name">
                        <p class="sub_title">会員</p>
                        <p class="confirm_item_contents">{{ $member->name_sei }}{{ $member->name_mei }}</p>
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title">商品名</p>
                        <p class="confirm_item_contents">{{ $product->name }}</p>
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title">商品カテゴリ</p>
                        <p class="confirm_item_contents">{{ $category->name }}>{{ $subcategory->name }}</p>
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title">商品写真</p>
                        <div>
                            <div>
                                <p>写真1</p>
                                <img src="{{ $product->image_1 }}" alt="">
                            </div>
                            <div>
                                <p>写真2</p>
                                <img src="{{ $product->image_2 }}" alt="">
                            </div>
                            <div>
                                <p>写真3</p>
                                <img src="{{ $product->image_3 }}" alt="">
                            </div>
                            <div>
                                <p>写真4</p>
                                <img src="{{ $product->image_4 }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title">商品説明</p>
                        <p class="confirm_item_contents">{{ $product->product_content }}</p>
                    </div>
                </div>

                <div class="product_detail_review_avg">
                    <p>総合評価</p>
                    <div class="admin_list_item_evaluation">
                        <p class="admin_list_star">
                            @for ($i = 0; $i < $average; $i++) ★ @endfor </p>
                                <p class="admin_product_list_review">{{ $average }}</p>
                    </div>
                </div>

                <!-- レビュー一覧 -->
                @if (count($reviews) === 0)
                <p>レビューはありません。</p>
                @endif
                <div>
                    @foreach ($reviews as $review)
                    <div class="review_items">
                        <div class="review_item">
                            <h3>商品レビューID</h3>
                            <p class="review_item_comment">{{ $review->id }}</p>
                        </div>
                        <div class="review_item">
                            <h3>
                                <a href="{{ route('admin_member_edit', ['id' => $review->member_id]) }}">
                                    {{ $review->name_sei }}{{ $review->name_mei }}さん
                                </a>
                            </h3>
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

                <div class="admin_member_detail_btn_group">
                    <a href="{{ route('admin_product_edit', ['id' => $product->id, 'page' => session('list_page')]) }}" class="admin_member_detail_btn">編集</a>
                    <input type="submit" class="admin_member_delete_btn" value="削除">
                </div>
            </form>
        </div>
    </main>

</body>

</html>