<select id="{{ $id }}" name="{{ $name }}" class="form-control">
    @if ($add_empty == true)
        <option></option>
    @endif

    @if ($add_default == true)
        <option value="0" @if ($selected == 0) selected @endif>
            {{ __(\App\Models\Expense::DEFAULT_LABEL) }}
        </option>
    @endif

    @foreach($options as $option)
        <option value="{{ $option->$use_as_value }}"
            @if ($selected == $option->id) selected @endif>
            {{ $option->$use_as_label }}
        </option>
    @endforeach
</select>
