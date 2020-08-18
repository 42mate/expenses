<select id="{{ $id }}" name="{{ $name }}" class="form-control">
    @foreach($categories as $category)
        @if ($loop->first && $add_empty == true)
                <option></option>
        @endif

        <option value="{{ $category->$use_as_value }}"
                @if ($selected == $category->id) selected @endif>
            {{ $category->category }}
        </option>
    @endforeach
</select>
