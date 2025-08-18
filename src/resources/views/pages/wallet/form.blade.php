@extends('theme/master_layout')

@section('content')
    <h1>
        @if (empty($model)) {{ __('Add') }}
        @else {{ _('Edit') }}
        @endif {{ _('Wallet') }}
    </h1>

    <x-help>
        {{ __('Wallets are where you have the money, a bank account, a digital wallet, a crypto wallet, or a box with money in your house.') }}<br />
        {{ __('Each wallet have a given currency') }}<br />
        {{ __('When you create a wallet, you have to set how many money you have on that wallet') }}<br />
        {{ __('Every time you add an Expense and you select a wallet, the money will be discounted from the wallet') }}<br />
        {{ __('Every time you add an Income and you select a wallet, the money will be added from the wallet') }}<br />
        {{ __('This will help you the have the wallet balance') }}<br />
        {{ __('On a Expense or an Income, if you set a wallet on the transaction, the currency of the wallet will be set to the transaction.') }}
    </x-help>

    <div class="row">
        <div class="col-md-8">
            {!! forms()->create('wallet', !empty($model) ? $model : null) !!}

            {!! forms()->field( __('Name'), 'name') !!}

            <div class="form-group mb-3">
                <label for="name">{{ __('Currency') }}:</label>
                <x-currencies-drop-down name="currency_id"
                                        addEmpty="true"
                                        use_as_label="name"
                                        errors="{{ $errors->has('currency_id') }}"
                                        selected="{{ empty($model) ? 0 : $model->currency_id }}"
                />
            </div>

            {!! forms()->field(__('Balance'), 'balance', 'number')->attributes(['step' => '.00000001']) !!}

            @if (!empty($model))
                {!! forms()->field(__('Update related transactions to the new currency?'), 'update_transactions', 'checkbox', null) !!}
            @endif

            <div class="form-group mb-3">
                {!! forms()->submit(__('Save'), ['class' => 'btn btn-primary']) !!}
                <a class="btn btn-warning" href="{{ route('wallet.index') }}">{{ __('Cancel') }}</a>
            </div>
            
            {!! forms()->end() !!}
        </div>
    </div>
@endsection
