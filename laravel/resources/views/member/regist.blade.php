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
            <h1 class="main_title">会員情報登録</h1>

            <form action="{{ url('/member_confirm') }}" method="post">
            @csrf

                <div class="item_group">
                    <div class="input_name">
                        <p class="sub_title sub_group">氏名</p>
                        <div class="input_name_items">
                            <label for="" class="item_label">姓</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}">
                        </div>
                        <div class="input_name_items">
                            <label for="" class="item_label">名</label>
                            <input type="text" name="second_name" value="{{ old('second_name') }}">
                        </div>
                    </div>
                    <div class="name_indi">
                        @if ($errors->has('first_name'))
                        <span class="indi indi_sub">
                            {{ $errors->first('first_name') }}
                        </span>
                        @endif
                        @if ($errors->has('second_name'))
                        <span class="indi indi_sub">
                            {{ $errors->first('second_name') }}
                        </span>
                        @endif
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_items">
                    <p class="sub_title">ニックネーム</p>
                        <input type="text" name="nickname" value="{{ old('nickname') }}" class="regi_input">
                    </div>
                    @if ($errors->has('nickname'))
                        <span class="indi indi_sub">
                            {{ $errors->first('nickname') }}
                        </span>
                    @endif
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title sub_group">性別</p>
                        <div class="gender_radio">
                                <input type="radio" name="gender" value="1" {{ old('gender') == "1" ? 'checked' : '' }}>
                            <label for="" class="item_label">男性</label>
                        </div>
                        <div class="gender_radio">
                                <input type="radio" name="gender" value="2" {{ old('gender') == "2" ? 'checked' : '' }}>
                            <label for="" class="item_label">女性</label>
                        </div>
                    </div>
                    @if ($errors->has('gender'))
                        <span class="indi indi_sub">
                            {{ $errors->first('gender') }}
                        </span>
                    @endif

                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title">パスワード</p>
                        <input type="password" name="password" class="regi_input">
                    </div>
                    @if ($errors->has('password'))
                        <span class="indi indi_sub">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title">パスワード確認</p>
                        <input type="password" name="pass_conf" class="regi_input">
                    </div>
                    @if ($errors->has('pass_conf'))
                        <span class="indi indi_sub">
                            {{ $errors->first('pass_conf') }}
                        </span>
                    @endif
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title">メールアドレス</p>
                        <input type="text" name="email" class="regi_input" value="{{ old('email') }}">
                    </div>
                    @if ($errors->has('email'))
                        <span class="indi indi_sub">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>

                <div class="member_regi_submit">
                    <div class="regi_btn">
                        <input type="submit" name="" value="確認画面へ" class="member_regi_btn">
                    </div>
                </div>
            </form>
        </div>
    </main>

</body>
</html>