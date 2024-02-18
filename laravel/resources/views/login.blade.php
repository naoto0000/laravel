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
            <h1 class="main_title">ログイン</h1>

            <form action="{{ route('login_top') }}" method="post">
                @csrf
                <div class="login_input">
                    <div class="login_items">
                        <p>メールアドレス（ID）</p>
                        <input type="text" name="login_id" value="">
                    </div>
                    <div class="login_items">
                        <p>パスワード</p>
                        <input type="password" name="login_pass">
                    </div>
                    @if ($errors->has('login'))
                    <span class="indi">
                        {{ $errors->first('login') }}
                    </span>
                    @endif
                </div>
                <div class="login_btn">
                    <div class="member_confirm_btn">
                        <button type="submit" class="member_regi_back_btn">ログイン</button>
                        <!-- <input type="submit" name="login_submit" value="ログイン" class="login_submit"> -->
                    </div>
                    <div class="member_confirm_btn">
                    <a href="{{ url('/top') }}" class="member_regi_back_btn">トップに戻る</a>
                        <!-- <button type="submit" name='back' value="back" class="member_regi_back_btn">トップに戻る</button> -->
                    </div>
                </div>
            </form>

        </div>
    </main>

</body>

</html>