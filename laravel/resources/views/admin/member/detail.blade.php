<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>福岡 laravel課題</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="admin_body">
    <header class="admin_header">
        <div class="admin_header_title">
            <h2>会員詳細</h2>
        </div>
        <div class="admin_header_contents">
            <a href="{{ route('admin_member_list', ['page' => session('page')]) }}" class="admin_logout_btn">一覧へ戻る</a>
        </div>
    </header>

    <main>
        <div class="container">
            <form action="{{ route('admin_member_delete') }}" method="post">
            @csrf
                <div class="item_group">
                    <div class="input_name">
                        <p class="sub_title sub_group">ID</p>
                        <p class="confirm_item_contents">{{ $member->id }}</p>
                        <input type="hidden" name="id" value="{{ $member->id }}">
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_name">
                        <p class="sub_title sub_group">氏名</p>
                        <p class="confirm_item_contents">{{ $member->name_sei }}{{ $member->name_mei }}</p>
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title">ニックネーム</p>
                        <p class="confirm_item_contents">{{ $member->nickname }}</p>
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title sub_group">性別</p>
                        <p class="confirm_item_contents">{{ config('master.genders.' . $member->gender) }}</p>
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title">パスワード</p>
                        <p class="confirm_item_contents">セキュリティのため非表示</p>
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title">メールアドレス</p>
                        <p class="confirm_item_contents">{{ $member->email }}</p>
                    </div>
                </div>

                <div class="admin_member_detail_btn_group">
                    <a href="{{ route('admin_member_edit', ['id' => $member->id, 'page' => session('page')]) }}" class="admin_member_detail_btn">編集</a>
                    <input type="submit" class="admin_member_delete_btn" value="削除">
                </div>
            </form>
        </div>
    </main>

</body>

</html>