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
            <h1 class="main_title">会員登録完了</h1>
            <p class="complete_text">会員登録が完了しました</p>
        </div>

        <div class="member_regi_submit">
            <div class="member_confirm_btn">
                <a href="{{ url('/top_show') }}" class="member_regi_btn">トップに戻る</a>
            </div>
        </div>

    </main>
</body>

</html>