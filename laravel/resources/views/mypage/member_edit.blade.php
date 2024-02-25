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
            <form action="{{ route('mypage_member_edit_confirm') }}" method="post">
                @csrf
                <div class="mypage_edit_title">
                    <h2>会員情報登録</h2>
                </div>
                <div class="item_group">
                    <div class="input_name">
                        <p class="sub_title sub_group">氏名</p>
                        <div class="input_name_items">
                            <label for="" class="item_label">姓</label>
                            <input type="text" name="first_name" value="{{ old('first_name') ?? $user->name_sei }}">
                        </div>
                        <div class="input_name_items">
                            <label for="" class="item_label">名</label>
                            <input type="text" name="second_name" value="{{ old('second_name') ?? $user->name_mei }}">
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
                        <input type="text" name="nickname" value="{{ old('nickname') ?? $user->nickname }}" class="regi_input">
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
                            <input type="radio" name="gender" value="1" {{ old('gender', $user->gender) == "1" ? 'checked' : '' }}>
                            <label for="" class="item_label">男性</label>
                        </div>
                        <div class="gender_radio">
                            <input type="radio" name="gender" value="2" {{ old('gender', $user->gender) == "2" ? 'checked' : '' }}>
                            <label for="" class="item_label">女性</label>
                        </div>
                    </div>
                    @if ($errors->has('gender'))
                    <span class="indi indi_sub">
                        {{ $errors->first('gender') }}
                    </span>
                    @endif

                    <div class="mypage_edit_btn">
                        <input type="submit" id="submitBtn" class="mypage_mail_submit" value="確認画面へ">
                    </div>

                    <div class="mypage_edit_btn">
                        <a href="{{ route('mypage') }}" class="mypage_withdraw_btn">マイページに戻る</a>
                    </div>
            </form>
        </div>
    </main>

</body>

</html>