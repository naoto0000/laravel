<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>福岡 laravel課題</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="admin_body">
    <header class="admin_header">
        <div class="admin_header_title">
            @if(request()->route()->getName() === 'admin_review_regist')
            <h2>商品レビュー登録</h2>
            @elseif(request()->route()->getName() === 'admin_review_edit')
            <h2>商品レビュー編集</h2>
            @endif
        </div>
        <div class="admin_header_contents">
            @if(request()->route()->getName() === 'admin_review_regist')
            <a href="{{ route('admin_review_list') }}" class="admin_logout_btn">一覧へ戻る</a>
            @elseif(request()->route()->getName() === 'admin_review_edit')
            <a href="{{ route('admin_review_list', ['page' => session('page')]) }}" class="admin_logout_btn">一覧へ戻る</a>
            @endif
        </div>
    </header>

    <main>
        <div class="container">
            @if(request()->route()->getName() === 'admin_review_regist')
            <form action="{{ route('admin_review_confirm') }}" method="post">
                @csrf
                @elseif(request()->route()->getName() === 'admin_review_edit')
                <form action="{{ route('admin_review_edit_confirm') }}" method="post">
                    @csrf
                    @endif

                    <div class="item_group">
                        <div class="input_name">
                            <p class="sub_title category_sub_title">商品</p>
                            <select name="product_id" class="category_select">
                                <option value="">商品を選択してください</option>
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id', session('product_id')) == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="name_indi">
                            @if ($errors->has('product_id'))
                            <span class="indi indi_sub">
                                {{ $errors->first('product_id') }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="item_group">
                        <div class="input_name">
                            <p class="sub_title category_sub_title">会員</p>
                            <select name="member_id" class="category_select">
                                <option value="">会員を選択してください</option>
                                @foreach ($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id', session('member_id')) == $member->id ? 'selected' : '' }}>{{ $member->name_sei }}{{ $member->name_mei }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="name_indi">
                            @if ($errors->has('member_id'))
                            <span class="indi indi_sub">
                                {{ $errors->first('member_id') }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="item_group">
                        <div class="input_name">
                            <p class="sub_title category_sub_title">ID</p>
                            @if(request()->route()->getName() === 'admin_review_regist')
                            <p>登録後に自動採番</p>
                            @elseif(request()->route()->getName() === 'admin_review_edit')
                            <p>{{ $review->id }}</p>
                            <input type="hidden" name="review_id" value="{{ $review->id }}">
                            @endif
                        </div>
                    </div>

                    <div class="item_group">
                        <div class="input_name">
                            <p class="sub_title category_sub_title">商品評価</p>
                            <select name="evaluation" id="" class="evaluation_select">
                                <option value="">評価を選択</option>
                                
                                <option value="1" {{ old('evaluation', session('evaluation')) == "1" ? 'selected' : '' }}>1</option>
                                <option value="2" {{ old('evaluation', session('evaluation')) == "2" ? 'selected' : '' }}>2</option>
                                <option value="3" {{ old('evaluation', session('evaluation')) == "3" ? 'selected' : '' }}>3</option>
                                <option value="4" {{ old('evaluation', session('evaluation')) == "4" ? 'selected' : '' }}>4</option>
                                <option value="5" {{ old('evaluation', session('evaluation')) == "5" ? 'selected' : '' }}>5</option>
                            </select>
                        </div>
                        <div class="name_indi">
                            @if ($errors->has('evaluation'))
                            <span class="indi indi_sub">
                                {{ $errors->first('evaluation') }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="item_group">
                        <div class="input_name">
                            <p class="sub_title category_sub_title">商品コメント</p>
                            <textarea name="review_comment" id="" cols="30" rows="10">{{ old('review_comment', session('review_comment')) }}</textarea>
                        </div>
                        <div class="name_indi">
                            @if ($errors->has('review_comment'))
                            <span class="indi indi_sub">
                                {{ $errors->first('review_comment') }}
                            </span>
                            @endif
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