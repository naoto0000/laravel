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
            @if(request()->route()->getName() === 'admin_member_confirm')
            <h2>会員登録</h2>
            @elseif(request()->route()->getName() === 'admin_member_edit_confirm')
            <h2>会員編集</h2>
            @endif
        </div>
        <div class="admin_header_contents">
            @if(request()->route()->getName() === 'admin_member_confirm')
            <a href="{{ route('admin_member_list') }}" class="admin_logout_btn">一覧へ戻る</a>
            @elseif(request()->route()->getName() === 'admin_member_edit_confirm')
            <a href="{{ route('admin_member_list', ['page' => session('page')]) }}" class="admin_logout_btn">一覧へ戻る</a>
            @endif
        </div>
    </header>

    <main>
        <div class="container">
            @if(request()->route()->getName() === 'admin_member_confirm')
            <form action="{{ route('admin_member_complete') }}" method="post" onsubmit="disableSubmitButton()">
                @csrf
                @elseif(request()->route()->getName() === 'admin_member_edit_confirm')
                <form action="{{ route('admin_member_edit_complete') }}" method="post" onsubmit="disableSubmitButton()">
                    @csrf
                    @endif

                    @if(request()->route()->getName() === 'admin_member_edit_confirm')
                    <input type="hidden" name="id" value="{{ $id }}">
                    @endif

                    <div class="item_group">
                        <div class="input_name">
                            <p class="sub_title sub_group">氏名</p>
                            <p class="confirm_item_contents">{{ $first_name }}{{ $second_name }}</p>
                            <input type="hidden" name="first_name" value="{{ $first_name }}">
                            <input type="hidden" name="second_name" value="{{ $second_name }}">
                        </div>
                    </div>

                    <div class="item_group">
                        <div class="input_items">
                            <p class="sub_title">ニックネーム</p>
                            <p class="confirm_item_contents">{{ $nickname }}</p>
                            <input type="hidden" name="nickname" value="{{ $nickname }}">
                        </div>
                    </div>

                    <div class="item_group">
                        <div class="input_items">
                            <p class="sub_title sub_group">性別</p>
                            <p class="confirm_item_contents">{{ config('master.genders.' . $gender) }}</p>
                            <input type="hidden" name="gender" value="{{ $gender }}">
                        </div>
                    </div>

                    <div class="item_group">
                        <div class="input_items">
                            <p class="sub_title">パスワード</p>
                            <p class="confirm_item_contents">セキュリティのため非表示</p>
                            <input type="hidden" name="password" value="{{ $password }}">
                        </div>
                    </div>

                    <div class="item_group">
                        <div class="input_items">
                            <p class="sub_title">メールアドレス</p>
                            <p class="confirm_item_contents">{{ $email }}</p>
                            <input type="hidden" name="email" value="{{ $email }}">
                        </div>
                    </div>

                    <div class="member_regi_submit">
                        <div class="regi_btn">
                            @if(request()->route()->getName() === 'admin_member_confirm')
                            <input type="submit" id="submitBtn" name="" value="登録完了" class="member_regi_btn">
                            @elseif(request()->route()->getName() === 'admin_member_edit_confirm')
                            <input type="submit" id="submitBtn" name="" value="編集完了" class="member_regi_btn">
                            @endif
                        </div>
                    </div>
                    <div class="member_regi_submit">
                        <div class="regi_btn">
                            <button type="submit" name='back' value="back" class="member_regi_back_btn">前に戻る</button>
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