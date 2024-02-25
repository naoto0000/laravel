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
            <form action="{{ route('mypage_mail_edit_auth_complete') }}" method="post" onsubmit="disableSubmitButton()">
                @csrf
                <div class="mypage_edit_title">
                    <h2>メールアドレス変更 認証コード入力</h2>
                </div>
                <p>
                    （※メールアドレスの変更はまだ完了していません）</br>
                    変更後のメールアドレスにお送りしましたメールに記載されている「認証コード」を入力してください。
                </p>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title mypage_title">認証コード</p>
                        <input type="text" name="auth_code" class="input_edit_email" value="{{ old('auth_code') }}">
                    </div>
                    <div class="name_indi">
                        @if ($errors->any())
                        <span class="indi indi_sub">
                            @foreach ($errors->all() as $error)
                            {{ $error }}
                            @endforeach
                        </span>
                        @endif
                    </div>
                </div>

                <div class="mypage_withdraw">
                    <input type="submit" class="mypage_mail_submit" id="submitBtn" value="認証コードを送信してメールアドレスの変更を完了する">
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