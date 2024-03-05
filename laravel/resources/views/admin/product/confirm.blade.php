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
            @if(request()->route()->getName() === 'admin_product_confirm')
            <h2>商品登録確認</h2>
            @elseif(request()->route()->getName() === 'admin_product_edit_confirm')
            <h2>商品編集確認</h2>
            @endif
        </div>
        <div class="admin_header_contents">
            @if(request()->route()->getName() === 'admin_product_confirm')
            <a href="{{ route('admin_product_list') }}" class="admin_logout_btn">一覧へ戻る</a>
            @elseif(request()->route()->getName() === 'admin_product_edit_confirm')
            <a href="{{ route('admin_product_list', ['page' => session('page')]) }}" class="admin_logout_btn">一覧へ戻る</a>
            @endif
        </div>
    </header>

    <main>
        <div class="container">
            @if(request()->route()->getName() === 'admin_product_confirm')
            <form action="{{ route('admin_product_complete') }}" method="post" onsubmit="disableSubmitButton()">
                @csrf
            @elseif(request()->route()->getName() === 'admin_product_edit_confirm')
            <form action="{{ route('admin_product_edit_complete') }}" method="post" onsubmit="disableSubmitButton()">
                @csrf
            @endif

                <div class="item_group">
                    <div class="input_name">
                        <p class="sub_title sub_group category_sub_title">ID</p>
                        @if(request()->route()->getName() === 'admin_product_confirm')
                        <p class="confirm_item_contents">登録後に自動採番</p>
                        @elseif(request()->route()->getName() === 'admin_product_edit_confirm')
                        <p class="confirm_item_contents">{{ session('product_id') }}</p>
                        <input type="hidden" name="product_id" value="{{ session('product_id') }}">
                        @endif
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_name">
                        <p class="sub_title sub_group category_sub_title">会員</p>
                        <p class="confirm_item_contents">{{ session('memberNameSei') }}{{ session('memberNameMei') }}</p>
                        <input type="hidden" name="member_id" value="{{ session('member_id') }}">
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_name">
                        <p class="sub_title sub_group category_sub_title">商品名</p>
                        <p class="confirm_item_contents">{{ session('product_name') }}</p>
                        <input type="hidden" name="product_name" value="{{ session('product_name') }}">
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title category_sub_title">商品カテゴリ</p>
                        <p class="confirm_item_contents">{{ session('categoryName') }}>{{ session('categoryNameSub') }}</p>
                        <input type="hidden" name="category" value="{{ session('category') }}">
                        <input type="hidden" name="subcategory" value="{{ session('subcategory') }}">
                    </div>
                </div>

                <div class="item_group">
                    <p class="sub_title category_sub_title">商品写真</p>
                    <div class="input_photo">
                        <p class="sub_title sub_group category_sub_title">写真１</p>
                        <p class="confirm_item_contents"><img src="{{ session('image1') }}" alt=""></p>
                        <input type="hidden" name="image1" value="{{ session('image1') }}">
                    </div>
                </div>
                <div class="item_group">
                    <div class="input_photo">
                        <p class="sub_title sub_group category_sub_title">写真2</p>
                        <p class="confirm_item_contents"><img src="{{ session('image2') }}" alt=""></p>
                        <input type="hidden" name="image2" value="{{ session('image2') }}">
                    </div>
                </div>
                <div class="item_group">
                    <div class="input_photo">
                        <p class="sub_title sub_group category_sub_title">写真3</p>
                        <p class="confirm_item_contents"><img src="{{ session('image3') }}" alt=""></p>
                        <input type="hidden" name="image3" value="{{ session('image3') }}">
                    </div>
                </div>
                <div class="item_group">
                    <div class="input_photo">
                        <p class="sub_title sub_group category_sub_title">写真4</p>
                        <p class="confirm_item_contents"><img src="{{ session('image4') }}" alt=""></p>
                        <input type="hidden" name="image4" value="{{ session('image4') }}">
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_name">
                        <p class="sub_title sub_group category_sub_title">商品説明</p>
                        <p class="confirm_item_contents">{{ session('product_text') }}</p>
                        <input type="hidden" name="product_text" value="{{ session('product_text') }}">
                    </div>
                </div>

                <div class="member_regi_submit">
                    <div class="regi_btn">
                        @if(request()->route()->getName() === 'admin_product_confirm')
                        <input type="submit" id="submitBtn" name="" value="登録完了" class="admin_member_confirm_btn">
                        @elseif(request()->route()->getName() === 'admin_product_edit_confirm')
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