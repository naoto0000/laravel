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
            <form action="{{ route('mypage_mail_edit_auth') }}" method="post" onsubmit="disableSubmitButton()">
                @csrf
                <div class="mypage_edit_title">
                    <h2>メールアドレス変更</h2>
                </div>
                <div class="item_group">
                    <div class="input_name">
                        <p class="sub_group mypage_title">現在のメールアドレス</p>
                        <p class="confirm_item_contents">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="mypage_title">変更後のメールアドレス</p>
                        <input type="text" name="email" class="input_edit_email">
                    </div>
                    <div class="name_indi">
                        @if ($errors->has('email'))
                        <span class="indi indi_sub">
                            {{ $errors->first('email') }}
                        </span>
                        @endif
                    </div>
                </div>

                <div class="mypage_edit_btn">
                    <input type="submit" id="submitBtn" class="mypage_mail_submit" value="認証メール送信">
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