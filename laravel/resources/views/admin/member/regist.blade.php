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
            @if(request()->route()->getName() === 'admin_member_regist')
            <h2>会員登録</h2>
            @elseif(request()->route()->getName() === 'admin_member_edit')
            <h2>会員編集</h2>
            @endif
        </div>
        <div class="admin_header_contents">
            @if(request()->route()->getName() === 'admin_member_regist')
            <a href="{{ route('admin_member_list') }}" class="admin_logout_btn">一覧へ戻る</a>
            @elseif(request()->route()->getName() === 'admin_member_edit')
            <a href="{{ route('admin_member_list', ['page' => session('page')]) }}" class="admin_logout_btn">一覧へ戻る</a>
            @endif
        </div>
    </header>

    <main>
        <div class="container">

            @if(request()->route()->getName() === 'admin_member_regist')
            <form action="{{ route('admin_member_confirm') }}" method="post">
                @csrf
                @elseif(request()->route()->getName() === 'admin_member_edit')
                <form action="{{ route('admin_member_edit_confirm') }}" method="post">
                    @csrf
                    @endif


                    <div class="item_group">
                        <div class="input_items">
                            <p class="sub_title">ID</p>
                            @if(request()->route()->getName() === 'admin_member_regist')
                            <p>登録後に自動採番</p>
                            @elseif(request()->route()->getName() === 'admin_member_edit')
                            <p>{{ $member->id }}</p>
                            <input type="hidden" name="id" value="{{ $member->id }}">
                            @endif
                        </div>
                    </div>

                    <div class="item_group">
                        <div class="input_name">
                            <p class="sub_title sub_group">氏名</p>
                            <div class="input_name_items">
                                <label for="" class="item_label">姓</label>
                                @if(request()->route()->getName() === 'admin_member_regist')
                                <input type="text" name="first_name" value="{{ old('first_name') }}">
                                @elseif(request()->route()->getName() === 'admin_member_edit')
                                <input type="text" name="first_name" value="{{ old('first_name') !== null ? old('first_name') : ($errors->any() ? '' : $member->name_sei) }}">
                                @endif

                            </div>
                            <div class="input_name_items">
                                <label for="" class="item_label">名</label>
                                @if(request()->route()->getName() === 'admin_member_regist')
                                <input type="text" name="second_name" value="{{ old('second_name') }}">
                                @elseif(request()->route()->getName() === 'admin_member_edit')
                                <input type="text" name="second_name" value="{{ old('second_name') !== null ? old('second_name') : ($errors->any() ? '' : $member->name_mei) }}">
                                @endif

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
                            @if(request()->route()->getName() === 'admin_member_regist')
                            <input type="text" name="nickname" value="{{ old('nickname') }}" class="regi_input">
                            @elseif(request()->route()->getName() === 'admin_member_edit')
                            <input type="text" name="nickname" value="{{ old('nickname') !== null ? old('nickname') : ($errors->any() ? '' : $member->nickname) }}" class="regi_input">
                            @endif

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
                                @if(request()->route()->getName() === 'admin_member_regist')
                                <input type="radio" name="gender" value="1" {{ old('gender') == "1" ? 'checked' : '' }}>
                                @elseif(request()->route()->getName() === 'admin_member_edit')
                                <input type="radio" name="gender" value="1" {{ old('gender', $member->gender) == "1" ? 'checked' : '' }}>
                                @endif

                                <label for="" class="item_label">男性</label>
                            </div>
                            <div class="gender_radio">
                                @if(request()->route()->getName() === 'admin_member_regist')
                                <input type="radio" name="gender" value="2" {{ old('gender') == "2" ? 'checked' : '' }}>
                                @elseif(request()->route()->getName() === 'admin_member_edit')
                                <input type="radio" name="gender" value="2" {{ old('gender', $member->gender) == "2" ? 'checked' : '' }}>
                                @endif

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
                            @if(request()->route()->getName() === 'admin_member_regist')
                            <input type="text" name="email" class="regi_input" value="{{ old('email') }}">
                            @elseif(request()->route()->getName() === 'admin_member_edit')
                            <input type="text" name="email" class="regi_input" value="{{ old('email') !== null ? old('email') : ($errors->any() ? '' : $member->email) }}">
                            @endif

                        </div>
                        @if ($errors->has('email'))
                        <span class="indi indi_sub">
                            {{ $errors->first('email') }}
                        </span>
                        @endif
                    </div>

                    <div class="member_regi_submit">
                        <div class="regi_btn">
                            <input type="submit" name="" value="確認画面へ" class="admin_member_regi_btn">
                        </div>
                    </div>
                </form>
        </div>
    </main>

</body>

</html>