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
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="login_input">
                    <div class="login_items">
                        <p>メールアドレス（ID）</p>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    <div class="login_items">
                        <p>パスワード</p>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    </div>
                </div>

                @if (Route::has('password.request'))
                <div class="pass_regi">
                    <a class="btn-link" href="{{ route('password.request') }}">
                        パスワードを忘れた方はこちら
                    </a>
                </div>
                @endif


                @if ($errors->has('login'))
                <span class="indi login_indi">
                    {{ $errors->first('login') }}
                </span>
                @endif

                <!-- <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div> -->

                <div class="login_btn">
                    <div class="member_confirm_btn">
                        <button type="submit" class="login_submit">ログイン</button>
                    </div>
                    <div class="member_confirm_btn">
                        <a href="{{ url('/top_show') }}" class="login_submit login_back_submit">トップに戻る</a>
                    </div>
                </div>


                <!-- <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            ログイン
                        </button>
                    </div>
                </div> -->
            </form>
        </div>
    </main>

</body>

</html>