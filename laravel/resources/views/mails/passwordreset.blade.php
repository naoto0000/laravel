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
        <div>
            <p>パスワード再発行</p>
            <p>以下のURLをクリックしてパスワードを再発行してください。</p>
            <p>{{ $reset_url }}</p>
        </div>
    </main>
</body>

</html>
