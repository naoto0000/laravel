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
            <div class="item_group">
                <div class="input_name">
                    <p class="sub_title sub_group mypage_title">氏名</p>
                    <p class="confirm_item_contents">{{ $user->name_sei }}{{ $user->name_mei }}</p>
                </div>
            </div>

            <div class="item_group">
                <div class="input_items">
                    <p class="sub_title mypage_title">ニックネーム</p>
                    <p class="confirm_item_contents">{{ $user->nickname }}</p>
                </div>
            </div>

            <div class="item_group">
                <div class="input_items">
                    <p class="sub_title sub_group mypage_title">性別</p>
                    <p class="confirm_item_contents">{{ config('master.genders.' . $user->gender) }}</p>
                </div>
            </div>

            <div class="mypage_link">
                <a href="{{ route('mypage_member_edit') }}" class="mypage_link_btn">会員情報変更</a>
            </div>

            <div class="item_group">
                <div class="input_items">
                    <p class="sub_title mypage_title">パスワード</p>
                    <p class="confirm_item_contents">セキュリティのため非表示</p>
                </div>
            </div>

            <div class="mypage_link">
                <a href="{{ route('mypage_password_edit') }}" class="mypage_link_btn">パスワード変更</a>
            </div>

            <div class="item_group">
                <div class="input_items">
                    <p class="sub_title mypage_title">メールアドレス</p>
                    <p class="confirm_item_contents">{{ $user->email }}</p>
                </div>
            </div>

            <div class="mypage_link">
                <a href="{{ route('mypage_mail_edit') }}" class="mypage_link_btn">メールアドレス変更</a>
            </div>

            <div class="mypage_link">
                <a href="{{ route('mypage_review') }}" class="mypage_link_btn">商品レビュー管理</a>
            </div>

            <div class="mypage_withdraw">
                <a href="{{ route('mypage_withdraw') }}" class="mypage_withdraw_btn">退会</a>
            </div>
        </div>
    </main>

</body>

</html>