<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>福岡 laravel課題</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="admin_body">
    <header class="admin_header">
        <div class="admin_header_title">
            @if(request()->route()->getName() === 'admin_review_confirm')
            <h2>商品レビュー登録確認</h2>
            @elseif(request()->route()->getName() === 'admin_review_edit_confirm')
            <h2>商品レビュー編集確認</h2>
            @endif
        </div>
        <div class="admin_header_contents">
            @if(request()->route()->getName() === 'admin_review_confirm')
            <a href="{{ route('admin_review_list') }}" class="admin_logout_btn">一覧へ戻る</a>
            @elseif(request()->route()->getName() === 'admin_review_edit_confirm')
            <a href="{{ route('admin_review_list', ['page' => session('page')]) }}" class="admin_logout_btn">一覧へ戻る</a>
            @endif
        </div>
    </header>

    <main>
        <div class="container">
            <div class="detail_contents admin_review_border">
                <div class="product_view">
                    <img src="{{ $product->image_1 }}" alt="" class="review_img">
                    <div class="product_view_text">
                        <p>商品ID  {{ $product->id }}</p>
                        <p>会員  {{ $member->name_sei }}{{ $member->name_mei }}</p>
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

            @if(request()->route()->getName() === 'admin_review_confirm')
            <form action="{{ route('admin_review_complete') }}" method="post" onsubmit="disableSubmitButton()">
                @csrf
                @elseif(request()->route()->getName() === 'admin_review_edit_confirm')
                <form action="{{ route('admin_review_edit_complete') }}" method="post" onsubmit="disableSubmitButton()">
                    @csrf
                    @endif

                    <div class="item_group">
                        <div class="input_name">
                            <p class="sub_title category_sub_title">ID</p>
                            @if(request()->route()->getName() === 'admin_review_confirm')
                            <p class="confirm_item_contents">登録後に自動採番</p>
                            @elseif(request()->route()->getName() === 'admin_review_edit_confirm')
                            <p class="confirm_item_contents">{{ $review_id }}</p>
                            <input type="hidden" name="review_id" value="{{ $review_id }}">
                            @endif
                        </div>
                    </div>

                    <div class="item_group">
                        <div class="input_name">
                            <p class="sub_title category_sub_title">商品評価</p>
                            <p class="confirm_item_contents">{{ $evaluation }}</p>
                            <input type="hidden" name="evaluation" value="{{ $evaluation }}">
                        </div>
                    </div>

                    <div class="item_group">
                        <div class="input_name">
                            <p class="sub_title category_sub_title">商品コメント</p>
                            <p class="confirm_item_contents">{{ $review_comment }}</p>
                            <input type="hidden" name="review_comment" value="{{ $review_comment }}">
                        </div>
                    </div>

                    <!-- 会員IDと商品IDをinput.hiddenで送信 -->
                    <input type="hidden" name="product_id" value="{{ $product_id }}">
                    <input type="hidden" name="member_id" value="{{ $member_id }}">

                    <div class="member_regi_submit">
                        <div class="regi_btn">
                            @if(request()->route()->getName() === 'admin_review_confirm')
                            <input type="submit" id="submitBtn" name="" value="登録完了" class="admin_member_confirm_btn">
                            @elseif(request()->route()->getName() === 'admin_review_edit_confirm')
                            <input type="submit" id="submitBtn" name="" value="編集完了" class="admin_member_confirm_btn">
                            @endif
                        </div>
                    </div>
                    <div class="member_regi_submit">
                        <div class="regi_btn">
                            <button type="submit" name='back' value="back" class="admin_member_regi_back_btn">前に戻る</button>
                        </div>
                    </div>
                </form>
        </div>
    </main>
    <script>
        // フォーム送信時に呼び出される関数
        function disableSubmitButton() {
            // 送信ボタンを無効化
            document.getElementById('submitBtn').disabled = true;
        }
    </script>

</body>

</html>