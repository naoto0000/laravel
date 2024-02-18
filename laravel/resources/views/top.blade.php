<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>福岡 laravel課題</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <header>
        @if ($is_login)
        <div class="header_name">
            {{ $user->name_sei.$user->name_mei }}様
        </div>
        @endif
        <div class="header_link">
            @if ($is_login)
            <div>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn">
                        ログアウト
                    </button>
                </form>
                <!-- <a href="{{ route('logout') }}" class="btn">ログアウト</a> -->
            </div>
            @else
            <div class="header_login_group">
                <a href="{{ route('member_regist') }}" class="btn">新規会員登録</a>
                <a href="{{ url('/login') }}" class="btn">ログイン</a>
            </div>
            @endif
        </div>
    </header>

    <main>
        <div class="container">

        </div>
    </main>

</body>

</html>