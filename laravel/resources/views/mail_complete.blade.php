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
            <div class="mail_complete_text">
                <p>パスワード再設定の案内メールを送信しました。</p>
                <p>（まだパスワード再設定は完了しておりません。）</p>
                <p>届きましたメールに記載されている</p>
                <p>『パスワード再設定URL』をクリックし、</p>
                <p>パスワードの再設定を完了させてください。</p>
            </div>
        </div>

        <div class="member_regi_submit">
            <div class="member_confirm_btn">
                <a href="{{ url('/top_show') }}" class="login_submit login_back_submit">トップに戻る</a>
            </div>
        </div>

    </main>
</body>

</html>