<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>福岡 laravel課題</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <header></header>

    <main>
        <div class="container">
            <div class="card-header">
                <p>パスワード再設定用のURLを記載したメールを送信します。</p>
                <p>ご登録されたメールアドレスを入力してください</p>
            </div>

            <div class="card-body">
                <!-- @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif -->

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="pass_reset_email form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            <!-- @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror -->
                        </div>
                    </div>
                    <!-- エラーメッセージの表示 -->
                    @if ($errors->has('email'))
                    <span class="indi login_indi">
                        {{ $errors->first('email') }}
                    </span>
                    @endif

                    <div class="login_btn">
                        <div class="member_confirm_btn">
                            <button type="submit" class="login_submit">送信する</button>
                        </div>
                        <div class="member_confirm_btn">
                            <a href="{{ url('/top_show') }}" class="login_submit login_back_submit">トップに戻る</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>