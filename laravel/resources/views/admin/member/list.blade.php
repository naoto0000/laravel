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
            <h2>会員一覧</h2>
        </div>
        <div class="admin_header_contents">
            <a href="{{ route('admin_top') }}" class="admin_logout_btn">トップへ戻る</a>
        </div>
    </header>

    <main>
        <div class="admin_list_container">
            <div class="admin_list_regist">
                <a href="{{ route('admin_member_regist') }}" class="admin_list_regist_btn">会員登録</a>
            </div>
            <div class="member_search">
                <form action="{{ route('admin_member_list_search') }}" method="get">
                    <table class="search_admin_group">
                        <tr class="search_items">
                            <td>
                                <p class="admin_search_item_p">ID</p>
                            </td>
                            <td><input type="text" name="member_search_id" value="{{ session('member_search_id') }}"></td>
                        </tr>
                        <tr class="search_items">
                            <td>
                                <p class="admin_search_item_p">性別</p>
                            </td>
                            <td>
                                <input type="checkbox" name="member_search_gender[]" value="1" {{ in_array(1, session('member_search_gender', [])) ? 'checked' : '' }} />
                                <label for="男性">男性</label>
                                <input type="checkbox" name="member_search_gender[]" value="2" {{ in_array(2, session('member_search_gender', [])) ? 'checked' : '' }} />
                                <label for="女性">女性</label>
                            </td>
                        </tr>
                        <tr class="search_items">
                            <td>
                                <p class="admin_search_item_p">フリーワード</p>
                            </td>
                            <td><input type="text" name="member_search_freeword" value="{{ session('member_search_freeword') }}"></td>
                        </tr>
                    </table>
                    <input type="hidden" name="direction" value="{{ request()->query('direction') }}">
                    <input type="hidden" name="sort" value="{{ request()->query('sort') }}">
                    <div class="admin_search_submit_btn">
                        <input type="submit" value="検索する" class="admin_search_submit">
                    </div>
                </form>
            </div>

            <div class="admin_member_list">
                <table class="admin_member_list_display">
                    <tr class="admin_member_table_line">
                        <th class="admin_member_table_th">ID
                            @if(request()->query('direction') === 'asc' && request()->query('sort') === 'id')
                            @sortablelink('id', '▲')
                            @else
                            @sortablelink('id', '▼')
                            @endif
                        </th>
                        <th class="admin_member_table_th">氏名</th>
                        <th class="admin_member_table_th">メールアドレス</th>
                        <th class="admin_member_table_th">性別</th>
                        <th class="admin_member_table_th">登録日時
                            @if(request()->query('direction') === 'asc' && request()->query('sort') === 'created_at')
                            @sortablelink('created_at', '▲')
                            @else
                            @sortablelink('created_at', '▼')
                            @endif
                        </th>
                        <th class="admin_member_table_th">編集</th>
                        <th class="admin_member_table_th">詳細</th>
                    </tr>
                    @foreach ($members as $member)
                    <tr class="admin_member_table_line">
                        <td class="admin_member_table_td">{{ $member->id }}</td>
                        <td class="admin_member_table_td">
                            <a href="{{ route('admin_member_detail', ['id' => $member->id, 'page' => $members->currentPage()]) }}">
                                {{ $member->name_sei }}{{ $member->name_mei }}
                            </a>
                        </td>
                        <td class="admin_member_table_td">{{ $member->email }}</td>
                        <td class="admin_member_table_td">{{ config('master.genders.' . $member->gender) }}</td>
                        <td class="admin_member_table_td">{{ $member->created_at->format('Y/m/d') }}</td>
                        <td class="admin_member_table_td"><a href="{{ route('admin_member_edit', ['id' => $member->id, 'page' => $members->currentPage()]) }}">編集</a></td>
                        <td class="admin_member_table_td"><a href="{{ route('admin_member_detail', ['id' => $member->id, 'page' => $members->currentPage()]) }}">詳細</a></td>
                    </tr>
                    @endforeach
                </table>
            </div>

            <!-- ページネーションリンクを表示 -->
            {{ $members->appends(request()->query())->onEachSide(0)->links() }}

        </div>
    </main>

</body>

</html>