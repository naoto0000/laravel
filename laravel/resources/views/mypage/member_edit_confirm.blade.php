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
            <h1 class="main_title">会員情報確認画面</h1>

            <form action="{{ route('mypage_member_edit_complete') }}" method="post">
                @csrf

                <div class="item_group">
                    <div class="input_name">
                        <p class="sub_title sub_group">氏名</p>
                        <p class="confirm_item_contents">{{ $first_name }}{{ $second_name }}</p>
                        <input type="hidden" name="first_name" value="{{ $first_name }}">
                        <input type="hidden" name="second_name" value="{{ $second_name }}">
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title">ニックネーム</p>
                        <p class="confirm_item_contents">{{ $nickname }}</p>
                        <input type="hidden" name="nickname" value="{{ $nickname }}">
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title sub_group">性別</p>
                        <p class="confirm_item_contents">{{ config('master.genders.' . $gender) }}</p>
                        <input type="hidden" name="gender" value="{{ $gender }}">
                    </div>
                </div>

                <div class="mypage_edit_btn">
                    <input type="submit" id="submitBtn" class="mypage_mail_submit" value="変更完了">
                </div>

                <div class="mypage_edit_btn">
                    <button type="submit" name='back' value="back" class="mypage_withdraw_btn">前に戻る</button>
                </div>
            </form>
        </div>
    </main>

</body>

</html>