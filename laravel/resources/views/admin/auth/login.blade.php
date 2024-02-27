<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>福岡 laravel課題</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="admin_body">
    <header class="admin_header"></header>

    <main>
        <div class="container">
            <h1 class="main_title">管理画面</h1>
            <form method="POST" action="{{ route('admin_login') }}">
                @csrf

                <div class="login_input">
                    <div class="login_items">
                        <p>ログインID</p>
                        <input id="login_id" type="text" class="" name="login_id" value="{{ old('login_id') }}">
                    </div>
                    <div class="login_items">
                        <p>パスワード</p>
                        <input id="password" type="password" class="" name="password">
                    </div>
                </div>

                @if ($errors->any())
                <span class="indi login_indi">
                    ※IDもしくはパスワードが間違っています。
                </span>
                @endif

                <div class="login_btn">
                    <div class="member_confirm_btn">
                        <button type="submit" class="admin_login_submit">ログイン</button>
                    </div>
                </div>

            </form>
        </div>
    </main>
    <footer class="admin_footer"></footer>

</body>

</html>