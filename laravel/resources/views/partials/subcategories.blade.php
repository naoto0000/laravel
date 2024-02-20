<select name="subcategory" id="subcategory" class="sub_category_select">
    <option value="">サブカテゴリーを選択してください</option>
    @foreach($subcategories as $subcategory)
        <option value="{{ $subcategory->id }}" {{ old('subcategory') == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
    @endforeach
</select>