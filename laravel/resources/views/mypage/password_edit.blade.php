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
            <form action="{{ route('mypage_password_complete') }}" method="post" onsubmit="disableSubmitButton()">
                @csrf
                <div class="mypage_edit_title">
                    <h2>パスワード変更</h2>
                </div>
                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title">パスワード</p>
                        <input type="password" name="password" class="regi_input">
                    </div>
                    @if ($errors->has('password'))
                    <span class="indi indi_sub">
                        {{ $errors->first('password') }}
                    </span>
                    @endif
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title">パスワード確認</p>
                        <input type="password" name="pass_conf" class="regi_input">
                    </div>
                    @if ($errors->has('pass_conf'))
                    <span class="indi indi_sub">
                        {{ $errors->first('pass_conf') }}
                    </span>
                    @endif
                </div>

                <div class="mypage_edit_btn">
                    <input type="submit" id="submitBtn" class="mypage_mail_submit" value="パスワードを変更">
                </div>

                <div class="mypage_edit_btn">
                    <a href="{{ route('mypage') }}" class="mypage_withdraw_btn">マイページに戻る</a>
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