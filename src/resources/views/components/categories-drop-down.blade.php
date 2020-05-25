<select name="{{ $name }}">
    @foreach($categories as $category)
        <option value="{{ $category->id }}"
                @if ($selected == $category->id) selected @endif>
            {{ $category->category }}
        </option>
    @endforeach
</select>
