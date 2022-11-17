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
        @if (empty($model))
            {!! Form::open(['url' => route('wallet.store')]) !!}
        @else
            {!! Form::model($model, ['method' => 'put', 'url' => route('wallet.update', ['wallet' => $model->id])]) !!}
        @endif

        <div class="form-group">
            <label for="name">{{ __('Name') }}:</label>
            {!! Form::text('name', null, ['class' => [ 'form-control',  ($errors->has('name') ? 'is-invalid' : '')]]) !!}
            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="name">{{ __('Currency') }}:</label>

            <x-currencies-drop-down name="currency_id"
                                    addEmpty="true"
                                    use_as_label="name"
                                    errors="{{ $errors->has('currency_id') }}"
                                    selected="{{ empty($model) ? 0 : $model->currency_id }}"
            />

        </div>

        <div class="form-group">
            <label for="name">{{ __('Balance') }}:</label>
            {!! Form::number('balance', null, ['step' => '.00000001', 'class' => [ 'form-control',  ($errors->has('balance') ? 'is-invalid' : '')]]) !!}
            @error('balance')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        @if (!empty($model))
            <label for="name">{{ __('Update related transactions to the new currency?') }}:</label>
            {!! Form::checkbox('update_transactions', null, ['class' => [ 'form-control',  ($errors->has('update_transactions') ? 'is-invalid' : '')]]) !!}
            @error('update_transactions')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        @endif

        <div class="form-group mt-5">
            {!! Form::submit(__('Send'), ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-warning" href="{{ route('wallet.index') }}">{{ __('Cancel') }}</a>
        </div>
        {!! Form::close() !!}
    </div>
    </div>
@endsection
