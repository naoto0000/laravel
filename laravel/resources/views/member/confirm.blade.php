<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>福岡 laravel課題</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<main>
        <div class="container">
            <h1 class="main_title">会員情報確認画面</h1>

            <form action="{{ url('/member_complete') }}" method="post" onsubmit="disableSubmitButton()">
            @csrf

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
                        <input type="submit" id="submitBtn" name="" value="登録完了" class="member_regi_btn">
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