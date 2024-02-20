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

<body>
    <main>
        <div class="container">
            <h1 class="main_title">商品登録</h1>

            <form action="{{ route('product_confirm') }}" method="post">
                @csrf

                <input type="hidden" name="member_id" value="{{ $user->id }}">

                <div class="item_group">
                    <div class="input_name">
                        <p class="sub_title sub_group category_sub_title">商品名</p>
                        <input type="text" name="product_name" value="{{ old('product_name') }}">
                    </div>
                    <div class="name_indi">
                        @if ($errors->has('product_name'))
                        <span class="indi indi_sub">
                            {{ $errors->first('product_name') }}
                        </span>
                        @endif
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_items">
                        <p class="sub_title category_sub_title">商品カテゴリ</p>
                        <select id="category" name="category" class="category_select">
                            <option value="">カテゴリを選択してください</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>

                        <div id="subcategory-list">
                            <!-- サブカテゴリーを表示する -->
                        </div>
                    </div>
                </div>
                <div class="name_indi">
                    @if ($errors->has('category'))
                    <span class="indi indi_sub">
                        {{ $errors->first('category') }}
                    </span>
                    @endif
                </div>
                <div class="name_indi">
                    @if ($errors->has('subcategory'))
                    <span class="indi indi_sub">
                        {{ $errors->first('subcategory') }}
                    </span>
                    @endif
                </div>

                <div class="item_group">
                    <p class="sub_title category_sub_title">商品写真</p>
                    <div class="input_photo">
                        <p class="sub_title sub_group category_sub_title">写真１</p>
                        <div class="upload_group">
                            <div id="preview1" class="preview">
                                @if(old('image1'))
                                <img src="{{ old('image1') }}" alt="Uploaded Image" class="upload_img">
                                <input type="hidden" id="fileInput1" value="{{ old('image1') }}" class="fileInput" name="image1" accept="image/*">
                                @endif
                            </div>
                            <input type="file" class="js-droparea" id="upload_file1" name="upload_file">
                            <input type="hidden" id="fileInput1" value="" class="fileInput" name="image1" accept="image/*">
                            <button type="button" class="photo_upload_btn">アップロード</button>
                        </div>
                    </div>
                </div>
                <div class="item_group">
                    <div class="input_photo">
                        <p class="sub_title sub_group category_sub_title">写真2</p>
                        <div class="upload_group">
                            <div id="preview2" class="preview">
                                @if(old('image2'))
                                <img src="{{ old('image2') }}" alt="Uploaded Image" class="upload_img">
                                <input type="hidden" id="fileInput2" value="{{ old('image2') }}" class="fileInput" name="image2" accept="image/*">
                                @endif
                            </div>
                            <input type="file" class="js-droparea" id="upload_file2" name="upload_file">
                            <input type="hidden" id="image2" value="" name="image2">
                            <button type="button" class="photo_upload_btn">アップロード</button>
                        </div>
                    </div>
                </div>
                <div class="item_group">
                    <div class="input_photo">
                        <p class="sub_title sub_group category_sub_title">写真3</p>
                        <div class="upload_group">
                            <div id="preview3" class="preview">
                                @if(old('image3'))
                                <img src="{{ old('image3') }}" alt="Uploaded Image" class="upload_img">
                                <input type="hidden" id="fileInput3" value="{{ old('image3') }}" class="fileInput" name="image3" accept="image/*">
                                @endif
                            </div>
                            <input type="file" class="js-droparea" id="upload_file3" name="upload_file">
                            <input type="hidden" id="image3" value="" name="image3">
                            <button type="button" class="photo_upload_btn">アップロード</button>
                        </div>
                    </div>
                </div>
                <div class="item_group">
                    <div class="input_photo">
                        <p class="sub_title sub_group category_sub_title">写真4</p>
                        <div class="upload_group">
                            <div id="preview4" class="preview">
                                @if(old('image4'))
                                <img src="{{ old('image4') }}" alt="Uploaded Image" class="upload_img">
                                <input type="hidden" id="fileInput4" value="{{ old('image4') }}" class="fileInput" name="image4" accept="image/*">
                                @endif
                            </div>
                            <input type="file" class="js-droparea" id="upload_file4" name="upload_file">
                            <input type="hidden" id="image4" value="" name="image4">
                            <button type="button" class="photo_upload_btn">アップロード</button>
                        </div>
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_name">
                        <p class="sub_title sub_group category_sub_title">商品説明</p>
                        <textarea name="product_text" id="" cols="30" rows="10">{{ old('product_text') }}</textarea>
                    </div>
                    <div class="name_indi">
                        @if ($errors->has('product_text'))
                        <span class="indi indi_sub">
                            {{ $errors->first('product_text') }}
                        </span>
                        @endif
                    </div>
                </div>

                <div class="member_regi_submit">
                    <div class="regi_btn">
                        <input type="submit" name="" value="確認画面へ" class="member_regi_btn">
                    </div>
                    <div class="member_confirm_btn">
                        <a href="{{ route('login_top') }}" class="login_submit login_back_submit">トップに戻る</a>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script>
        // selectbox選択肢表示
        // =================
        $(document).ready(function() {
            $('#category').change(function() {
                var categoryId = $(this).val();

                $.ajax({
                    url: "{{ route('getSubcategories') }}",
                    method: 'get',
                    data: {
                        category_id: categoryId
                    },
                    success: function(response) {
                        $('#subcategory-list').html(response);
                    }
                });
            });
        });

        // 画像アップロード
        // =============
        $(document).ready(function() {
            // アップロードボタンがクリックされたときの処理
            $('.photo_upload_btn').click(function(event) {
                event.preventDefault();
                var uploadGroup = $(this).closest('.upload_group'); // 最も近い.upload_group要素を取得
                var fileInput = uploadGroup.find('.js-droparea')[0]; // 最も近い.upload_group内の.js-droparea要素を取得
                var file = fileInput.files[0];

                // ファイルサイズが10MB以下かどうかを検証
                if (file.size > 10 * 1024 * 1024) { // 10MB以上の場合
                    alert('ファイルサイズは10MB以下にしてください。');
                    return;
                }

                // ファイルの拡張子がjpg、jpeg、png、gifかどうかを検証
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                if (!allowedExtensions.exec(file.name)) { // 拡張子が許可されていない場合
                    alert('jpg、jpeg、png、gif形式の画像ファイルのみアップロードできます。');
                    return;
                }

                var formData = new FormData();
                formData.append('file', file);

                // 画像のアップロードを実行
                uploadFile(formData, uploadGroup);
            });

            function uploadFile(formData, uploadGroup) {
                $.ajax({
                    url: '{{ route("upload") }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('File uploaded successfully');
                        var previewDiv = uploadGroup.find('.preview');
                        previewDiv.html('<img src="' + response.imageUrl + '" alt="Uploaded Image" class="upload_img">');

                        // アップロードされた画像の URL を hidden input フィールドの値として設定
                        var hiddenInput = uploadGroup.find('.fileInput');
                        hiddenInput.val(response.imageUrl);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error uploading file:', error);
                    }
                });
            }
        });
    </script>

</body>

</html>