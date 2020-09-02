<select id="{{ $id }}" name="{{ $name }}" class="form-control">
    @foreach($wallets as $wallet)
        @if ($loop->first && $add_empty == true)
            <option></option>
        @endif

        <option value="{{ $wallet->$use_as_value }}"
                @if ($selected == $wallet->id) selected @endif>
            {{ $wallet->name }}
        </option>
    @endforeach
</select>
