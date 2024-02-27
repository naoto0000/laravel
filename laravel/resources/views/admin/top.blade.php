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
            <h2>管理画面メインメニュー</h2>
        </div>
        <div class="admin_header_contents">
            <p>ようこそ{{ $admin->name }}さん</p>
            <a href="{{ route('admin_logout') }}" class="admin_logout_btn">ログアウト</a>
        </div>
    </header>

    <main>
        <div class="container">
        </div>
    </main>

</body>

</html>