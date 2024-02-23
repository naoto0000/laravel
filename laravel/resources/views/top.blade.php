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
            <div class="top_btn_group">
                <div class="product_list_btn">
                    <a href="{{ route('product_list') }}" class="btn">商品一覧</a>
                </div>
                @if ($is_login)
                <div class="header_btn_login">
                    <div>
                        <a href="{{ route('product_regist') }}" class="header_product_btn">新規商品登録</a>
                    </div>

                    <div>
                        <a href="{{ route('mypage') }}" class="header_product_btn">マイページ</a>
                    </div>

                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="top_logout_btn">
                            ログアウト
                        </button>
                    </form>
                </div>
                @else
                <div class="header_login_group">
                    <a href="{{ route('member_regist') }}" class="btn">新規会員登録</a>
                    <a href="{{ url('/login') }}" class="btn">ログイン</a>
                </div>
                @endif
            </div>
        </div>
    </header>

    <main>
        <div class="container">
        </div>
    </main>

</body>

</html>