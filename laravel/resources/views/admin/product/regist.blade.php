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
            @if(request()->route()->getName() === 'admin_product_regist')
            <h2>商品登録</h2>
            @elseif(request()->route()->getName() === 'admin_product_edit')
            <h2>商品編集</h2>
            @endif
        </div>
        <div class="admin_header_contents">
            @if(request()->route()->getName() === 'admin_product_regist')
            <a href="{{ route('admin_product_list') }}" class="admin_logout_btn">一覧へ戻る</a>
            @elseif(request()->route()->getName() === 'admin_product_edit')
            <a href="{{ route('admin_product_list', ['page' => session('page')]) }}" class="admin_logout_btn">一覧へ戻る</a>
            @endif
        </div>
    </header>

    <main>
        <div class="container">
            @if(request()->route()->getName() === 'admin_product_regist')
            <form action="{{ route('admin_product_confirm') }}" method="post">
                @csrf
            @elseif(request()->route()->getName() === 'admin_product_edit')
            <form action="{{ route('admin_product_edit_confirm') }}" method="post">
                @csrf
            @endif

                <div class="item_group">
                    <div class="input_name">
                        <p class="sub_title sub_group category_sub_title">ID</p>
                        @if(request()->route()->getName() === 'admin_product_regist')
                        <p>登録後に自動採番</p>
                        @elseif(request()->route()->getName() === 'admin_product_edit')
                        <p>{{ $product->id }}</p>
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        @endif
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_name">
                        <p class="sub_title sub_group category_sub_title">会員</p>
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
                        <p class="sub_title sub_group category_sub_title">商品名</p>
                        <input type="text" name="product_name" value="{{ old('product_name', session('product_name')) }}">
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
                            <option value="{{ $category->id }}" {{ old('category', session('category')) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>

                        <select name="subcategory" id="subcategory" class="sub_category_select" style="display: none;">
                        </select>

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
                            <!-- 戻ってきた際にセッションでデータ保持 -->
                            @if(session('image1'))
                            <div id="preview1" class="preview">
                                <img src="{{ old('image1', session('image1')) }}" alt="Uploaded Image" class="upload_img">
                            </div>
                            <label class="photo_upload_btn">
                                アップロード
                                <input type="file" class="js-droparea" id="upload_file1" name="upload_file">
                            </label>
                            <input type="hidden" id="fileInput1" value="{{ old('image1', session('image1')) }}" class="fileInput" name="image1" accept="image/*">
                            @else
                            <div id="preview1" class="preview">
                            </div>
                            <label class="photo_upload_btn">
                                アップロード
                                <input type="file" class="js-droparea" id="upload_file1" name="upload_file">
                            </label>
                            <input type="hidden" id="fileInput1" value="" class="fileInput" name="image1" accept="image/*">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="item_group">
                    <div class="input_photo">
                        <p class="sub_title sub_group category_sub_title">写真2</p>
                        <div class="upload_group">
                            @if(session('image2'))
                            <div id="preview2" class="preview">
                                <img src="{{ old('image2', session('image2')) }}" alt="Uploaded Image" class="upload_img">
                            </div>
                            <label class="photo_upload_btn">
                                アップロード
                                <input type="file" class="js-droparea" id="upload_file2" name="upload_file">
                            </label>
                            <input type="hidden" id="fileInput2" value="{{ old('image2', session('image2')) }}" class="fileInput" name="image2" accept="image/*">
                            @else
                            <div id="preview2" class="preview">
                            </div>
                            <label class="photo_upload_btn">
                                アップロード
                                <input type="file" class="js-droparea" id="upload_file2" name="upload_file">
                            </label>
                            <input type="hidden" id="fileInput2" value="" class="fileInput" name="image2" accept="image/*">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="item_group">
                    <div class="input_photo">
                        <p class="sub_title sub_group category_sub_title">写真3</p>
                        <div class="upload_group">
                            @if(session('image3'))
                            <div id="preview3" class="preview">
                                <img src="{{ old('image3', session('image3')) }}" alt="Uploaded Image" class="upload_img">
                            </div>
                            <label class="photo_upload_btn">
                                アップロード
                                <input type="file" class="js-droparea" id="upload_file3" name="upload_file">
                            </label>
                            <input type="hidden" id="fileInput3" value="{{ old('image3', session('image3')) }}" class="fileInput" name="image3" accept="image/*">
                            @else
                            <div id="preview3" class="preview">
                            </div>
                            <label class="photo_upload_btn">
                                アップロード
                                <input type="file" class="js-droparea" id="upload_file3" name="upload_file">
                            </label>
                            <input type="hidden" id="fileInput3" value="" class="fileInput" name="image3" accept="image/*">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="item_group">
                    <div class="input_photo">
                        <p class="sub_title sub_group category_sub_title">写真4</p>
                        <div class="upload_group">
                            @if(session('image4'))
                            <div id="preview4" class="preview">
                                <img src="{{ old('image4', session('image4')) }}" alt="Uploaded Image" class="upload_img">
                            </div>
                            <label class="photo_upload_btn">
                                アップロード
                                <input type="file" class="js-droparea" id="upload_file4" name="upload_file">
                            </label>
                            <input type="hidden" id="fileInput4" value="{{ old('image4', session('image4')) }}" class="fileInput" name="image4" accept="image/*">
                            @else
                            <div id="preview4" class="preview">
                            </div>
                            <label class="photo_upload_btn">
                                アップロード
                                <input type="file" class="js-droparea" id="upload_file4" name="upload_file">
                            </label>
                            <input type="hidden" id="fileInput4" value="" class="fileInput" name="image4" accept="image/*">
                            @endif

                        </div>
                    </div>
                </div>

                <div class="item_group">
                    <div class="input_name">
                        <p class="sub_title sub_group category_sub_title">商品説明</p>
                        <textarea name="product_text" id="" cols="30" rows="10">{{ old('product_text', session('product_text')) }}</textarea>
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
                        <input type="submit" name="" value="確認画面へ" class="admin_member_regi_btn">
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script>
        // selectbox選択肢表示
        // =================
        $(document).ready(function() {
            if ($('#category').val() !== '') {
                // #category の値が空でない場合にのみ実行される処理
                $('#subcategory').show();
                $.ajax({
                    url: "{{ route('adminGetSubcategories') }}",
                    method: 'get',
                    data: {
                        category_id: $('#category').val(),
                        subcategory: "{{ old('subcategory') }}"
                    },
                    success: function(response) {
                        $('#subcategory').html(response.options);
                        $('#subcategory').val(response.selected);
                    }
                });
            } else {
                $('#subcategory').hide();
            }

            // #category の値が変更された時の処理
            $('#category').change(function() {
                var categoryId = $(this).val();
                if (categoryId !== '') {
                    $('#subcategory').show();
                    $.ajax({
                        url: "{{ route('adminGetSubcategories') }}",
                        method: 'get',
                        data: {
                            category_id: categoryId
                        },
                        success: function(response) {
                            $('#subcategory').html(response.options);
                            $('#subcategory').val(response.selected);
                        }
                    });
                } else {
                    $('#subcategory').hide();
                }
            });
        });

        // 画像アップロード
        // =============
        $(document).ready(function() {
            // ファイルが選択されたときの処理
            $('.js-droparea').change(function() {
                var uploadGroup = $(this).closest('.upload_group'); // 最も近い.upload_group要素を取得
                var file = this.files[0];

                console.log('ファイルサイズが大きすぎます:', file.size);
                // ファイルサイズが10MB以下かどうかを検証
                const maxSize = 10 * 1024 * 1024; // 10MB
                if (file.size > maxSize) {
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
                    url: '{{ route("adminUpload") }}',
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