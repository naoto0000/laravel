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
            @if(request()->route()->getName() === 'admin_category_confirm')
            <h2>商品カテゴリ登録</h2>
            @elseif(request()->route()->getName() === 'admin_category_edit_confirm')
            <h2>商品カテゴリ編集</h2>
            @endif
        </div>
        <div class="admin_header_contents">
            @if(request()->route()->getName() === 'admin_category_confirm')
            <a href="{{ route('admin_category_list') }}" class="admin_logout_btn">一覧へ戻る</a>
            @elseif(request()->route()->getName() === 'admin_category_edit_confirm')
            <a href="{{ route('admin_category_list', ['page' => session('page')]) }}" class="admin_logout_btn">一覧へ戻る</a>
            @endif
        </div>
    </header>

    <main>
        <div class="container">
            @if(request()->route()->getName() === 'admin_category_confirm')
            <form action="{{ route('admin_category_complete') }}" method="post" onsubmit="disableSubmitButton()">
                @csrf
                @elseif(request()->route()->getName() === 'admin_category_edit_confirm')
                <form action="{{ route('admin_category_edit_complete') }}" method="post" onsubmit="disableSubmitButton()">
                    @csrf
                    @endif

                    <div class="item_group">
                        <div class="input_name">
                            <p class="sub_title admin_sub_group">ID</p>
                            @if(request()->route()->getName() === 'admin_category_confirm')
                            <p class="confirm_item_contents">登録後自動採番</p>
                            @elseif(request()->route()->getName() === 'admin_category_edit_confirm')
                            <p class="confirm_item_contents">{{ $id }}</p>
                            <input type="hidden" name="id" value="{{ $id }}">
                            @endif
                        </div>
                    </div>

                    <div class="item_group">
                        <div class="input_name">
                            <p class="sub_title admin_sub_group">商品大カテゴリ</p>
                            <p class="confirm_item_contents">{{ $category }}</p>
                            <input type="hidden" name="category" value="{{ $category }}">
                        </div>
                    </div>

                    <div class="item_group">
                        <div class="input_items">
                            <p class="sub_title admin_sub_group">商品小カテゴリ</p>
                            <div>
                                @foreach ($subcategories as $subcategory)
                                <p class="confirm_item_contents">{{ $subcategory }}</p>
                                <input type="hidden" name="subcategory[]" value="{{ $subcategory }}">
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="member_regi_submit">
                        <div class="regi_btn">
                            @if(request()->route()->getName() === 'admin_category_confirm')
                            <input type="submit" id="submitBtn" name="" value="登録完了" class="admin_member_confirm_btn">
                            @elseif(request()->route()->getName() === 'admin_category_edit_confirm')
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