<div class="filter">
    {!! html()->form('GET', route($type . '.index'))->attribute('class', 'row')->open() !!}
    @if ($type == 'incomes')
    <div class="form-group col-md-3">
        <label for="income_source_id">{{ __('Income source') }}:</label>
        <x-income-source-drop-down name="income_source_id"
                                   use_as_label="source"
                                   selected="{{ request()->get('income_source_id', null) }}"
                                   addEmpty="true"
                                   addDefault="true"
        />
        @error('income_source_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    @else
        <div class="form-group col-md-3">
            <label for="category"> {{ __('Category') }}:</label>
            <x-categories-drop-down name="category_id"
                                    use_as_label="category"
                                    selected="{{ request()->get('category_id', null) }}"
                                    addEmpty="true"
                                    addDefault="true"
            />

            @error('category_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    @endif

    <div class="form-group col-md-3">
        <label for="wallet_id">{{ __('Wallet') }}:</label>
        <x-wallet-drop-down name="wallet_id"
                            use_as_label="name"
                            selected="{{ request()->get('wallet_id', null) }}"
                            addDefault="true"
                            addEmpty="true"/>

        @error('wallet_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group col-md-6">
        {!! forms()->field(__('Description'), 'description', 'text',
            request()->get('description', null),
            ['class' => [ 'form-control',  ($errors->has('description') ? 'is-invalid' : '')]]) !!}
        @error('description')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group col-md-3">
        {!! forms()->field(__('Date from'), 'date_from', 'date',
            (empty(request()->get('date_from', null)) ? '' : request()->get('date_from')),
            ['class' => [ 'form-control',  ($errors->has('date') ? 'is-invalid' : '')]]) !!}
        @error('date_from')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group col-md-3">
        {!! forms()->field(__('Date to'), 'date_to', 'date',
            (empty(request()->get('date_to', null)) ? '' : request()->get('date_to')),
            ['class' => [ 'form-control',  ($errors->has('date') ? 'is-invalid' : '')]]) !!}
        @error('date_to')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group col-md-3">
        <label for="category"> {{ __('Currency') }}:</label>

        <x-currencies-drop-down name="currency_id"
                                addEmpty="true"
                                use_as_label="name"
                                selected="{{ (empty(request()->get('currency_id', null)) ? '' : request()->get('currency_id'))}}"
        />

        @error('currency_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group col-12 text-end form-reverse">
        {!! forms()->button('<i class="fas fa-filter"></i> ' . __('Filter'))->attribute('class', 'btn btn-primary') !!}
        <a href="{{ route($type . '.index') }}" class="btn btn-secondary">
            <i class="fas fa-minus-circle"></i>
            {{ __('Reset') }}
        </a>
        {!! forms()->button('<i class="fas fa-file-excel"></i> ' . __('Export'))->attribute('class', 'btn btn-success') !!}
    </div>
    {!! html()->form()->close() !!}
</div>
