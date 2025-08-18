@extends('theme/master_layout')

@section('content')
    <!-- Page Heading -->
    <div class="">
        <h1>
            @if (empty($model->id)) {{ __('Add') }}
            @else {{ __('Edit') }}
            @endif {{ __('Income') }}
        </h1>

        <x-help>
            {{ __('Incomes are transactions where get money.') }} <br />
            {{ __('A income can have a specific source, this helps to have better reports.') }} <br />
            {{ __('A income can be related to a Wallet, if you select a wallet the expense amount will be added the wallet balance.') }} <br />
            {{ __('The wallet currency will be applied to the income, So if the wallets is of US dollars and the income amount is 100, it will represent 100 US Dolars') }} <br />
            {{ __('If you do not select a wallet, the default currency will be used.') }}
        </x-help>

        <div class="side-wrapper">
            {!! forms()->create('incomes', !empty($model) ? $model : null) !!}

            <div class="row">
                <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
                    {!! forms()->field(__('Date'), 'date', 'date', (empty($model->date) ? Carbon\Carbon::now()->format('Y-m-d') : $model->date->format('Y-m-d')),) !!}
                    {!! forms()->field(__('Amount'), 'amount', 'number')->attribute('step', '.01') !!}
                    {!! forms()->field(__('Description'), 'description') !!}
                </div>
                <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <div>
                            <label for="email" class="font-weight-bold">{{ __('Income Source') }}:</label>
                            <span class="mt-1 mb-1 float-end">
                                <a href="{{ route('income_source.create', ['gt=income.create']) }}">
                                    <i class="fas fa-plus"></i> {{ __('Add Income Source') }}
                                </a>
                            </span>
                        </div>
                        <x-income-source-drop-down name="income_source_id"
                            addEmpty="true"
                            use_as_label="source"
                            selected="{{ empty($model) ? 0 : $model->income_source_id }}"
                        />
                    </div>

                    <div class="form-group">
                        <div>
                            <label for="email" class="font-weight-bold">{{ __('Wallet') }}:</label>
                            <span class="mt-1 mb-1 float-end">
                                <a href="{{ route('wallet.create', ['gt=income.create']) }}">
                                    <i class="fas fa-plus"></i> {{ __('Add Wallet') }}
                                </a>
                            </span>
                        </div>

                        <x-wallet-drop-down name="wallet_id"
                            selected="{{ empty($model) ? 0 : $model->wallet_id }}"
                            add_empty="true"
                        />
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        {!! forms()->submit(__('Save')) !!}
                        <a class="btn btn-warning" href="{{ route('incomes.index') }}">
                            {{ __('Cancel') }}
                        </a>
                        @if (!empty($model) and !empty($model->id))
                            <a href="{{ route('incomes.destroy', ['income' => $model->id]) }}"
                               class="btn btn-danger float-end as-submit"
                               method="DELETE">
                                {{ __('Delete') }}
                            </a>
                        @endif
                    </div>
                </div>
                {!! forms()->end() !!}
            </div>
        </div>
    </div>
@endsection
