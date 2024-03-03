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
            @if(request()->route()->getName() === 'admin_category_regist')
            <h2>商品カテゴリ登録</h2>
            @elseif(request()->route()->getName() === 'admin_category_edit')
            <h2>商品カテゴリ編集</h2>
            @endif
        </div>
        <div class="admin_header_contents">
            @if(request()->route()->getName() === 'admin_category_regist')
            <a href="{{ route('admin_category_list') }}" class="admin_logout_btn">一覧へ戻る</a>
            @elseif(request()->route()->getName() === 'admin_category_edit')
            <a href="{{ route('admin_category_list', ['page' => session('page')]) }}" class="admin_logout_btn">一覧へ戻る</a>
            @endif
        </div>
    </header>

    <main>
        <div class="container">

            @if(request()->route()->getName() === 'admin_category_regist')
            <form action="{{ route('admin_category_confirm') }}" method="post">
                @csrf
                @elseif(request()->route()->getName() === 'admin_category_edit')
                <form action="{{ route('admin_category_edit_confirm') }}" method="post">
                    @csrf
                    @endif

                    <div class="item_group_admin">
                        <div class="input_items">
                            <p class="sub_title_admin">ID</p>
                            @if(request()->route()->getName() === 'admin_category_regist')
                            <p>登録後に自動採番</p>
                            @elseif(request()->route()->getName() === 'admin_category_edit')
                            <p>{{ $category->id }}</p>
                            <input type="hidden" name="id" value="{{ $category->id }}">
                            @endif
                        </div>
                    </div>

                    <div class="item_group_admin">
                        <div class="input_name">
                            <p class="sub_title_admin">商品大カテゴリ</p>
                            @if(request()->route()->getName() === 'admin_category_regist')
                            <input type="text" name="category" value="{{ old('category') }}" class="regi_input">
                            @elseif(request()->route()->getName() === 'admin_category_edit')
                            <input type="text" name="category" value="{{ old('category') !== null ? old('category') : ($errors->any() ? '' : $category->name) }}" class="regi_input">
                            @endif
                        </div>
                        <div class="name_indi">
                            @if ($errors->has('category'))
                            <span class="indi">
                                {{ $errors->first('category') }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- 小カテゴリ入力欄 -->
                    <div class="item_group_admin">
                        <div class="input_items">
                            <p class="sub_title_admin">商品小カテゴリ</p>
                            <div class="subcategory_input_group">
                                @if(request()->route()->getName() === 'admin_category_regist')
                                @for ($i = 1; $i <= 10; $i++) <input type="text" name="subcategory[]" value="{{ old('subcategory.' . ($i - 1)) }}" class="regi_input subcategory_input">
                                    @if ($errors->has('subcategory.' . ($i - 1)))
                                    <span class="indi admin_indi_sub">
                                        {{ $errors->first('subcategory.' . ($i - 1)) }}
                                    </span>
                                    @endif
                                    @endfor
                                    @elseif(request()->route()->getName() === 'admin_category_edit')
                                    @for ($i = 1; $i <= 10; $i++) <input type="text" name="subcategory[]" value="{{ old('subcategory.' . ($i - 1)) !== null ? old('subcategory.' . ($i - 1)) : ($errors->any() ? '' : old('subcategory.' . ($i - 1), (isset($category->subcategories[$i - 1]) ? $category->subcategories[$i - 1]->name : ''))) }}" class="regi_input subcategory_input">
                                        @if ($errors->has('subcategory.' . ($i - 1)))
                                        <span class="indi admin_indi_sub">
                                            {{ $errors->first('subcategory.' . ($i - 1)) }}
                                        </span>
                                        @endif
                                        @endfor
                                        @endif
                            </div>
                        </div>
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