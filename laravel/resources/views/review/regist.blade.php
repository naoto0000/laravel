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
                <h2 class="header_h2">商品レビュー登録</h2>
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

            <form action="{{ route('review_confirm', ['id' => $product->id]) }}" method="post">
                @csrf
                <div class="review_regist_form">
                    <div class="review_resist_form_items">
                        <div class="review_input_group">
                            <p>商品評価</p>
                            <select name="evaluation" id="" class="evaluation_select">
                                <option value="">評価を選択</option>
                                <option value="1" {{ session('evaluation') == '1' ? 'selected' : '' }}>1</option>
                                <option value="2" {{ session('evaluation') == '2' ? 'selected' : '' }}>2</option>
                                <option value="3" {{ session('evaluation') == '3' ? 'selected' : '' }}>3</option>
                                <option value="4" {{ session('evaluation') == '4' ? 'selected' : '' }}>4</option>
                                <option value="5" {{ session('evaluation') == '5' ? 'selected' : '' }}>5</option>
                            </select>
                        </div>
                        <div class="name_indi">
                            @if ($errors->has('evaluation'))
                            <span class="indi indi_sub">
                                {{ $errors->first('evaluation') }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="review_resist_form_items">
                        <div class="review_input_group">
                            <p>商品コメント</p>
                            <textarea name="review_comment" id="" cols="30" rows="10">{{ session('review_comment') }}</textarea>
                        </div>
                        <div class="name_indi">
                            @if ($errors->has('review_comment'))
                            <span class="indi indi_sub">
                                {{ $errors->first('review_comment') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="review_submit">
                    <input type="submit" name="" value="商品レビュー確認" class="review_subimt_btn">
                </div>
            </form>

            <div class="detail_back_submit">
                <a href="{{ route('product_detail', ['id' => $product->id, 'page' => session('page')]) }}" class="review_submit_back_btn">商品詳細に戻る</a>
            </div>
        </div>
    </main>
</body>

</html>