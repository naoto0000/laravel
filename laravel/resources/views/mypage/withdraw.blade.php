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

        <div class="mypage_header_link">
            <p class="mypage_header">マイページ</p>

            <div class="header_btn_login">
                <div>
                    <a href="{{ route('login_top') }}" class="header_product_btn">トップに戻る</a>
                </div>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="top_logout_btn">
                        ログアウト
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="withdraw_text">
                退会します。よろしいですか？
            </div>
            <div class="mypage_withdraw">
                <a href="{{ route('mypage') }}" class="mypage_withdraw_btn">マイページに戻る</a>
            </div>
            <form action="{{ route('member_withdraw') }}" method="post">
                @csrf
                <div class="mypage_withdraw">
                    <input type="submit" class="mypage_withdraw_btn withdraw_submit_btn" value="退会する">
                </div>
            </form>
        </div>
    </main>

</body>

</html>