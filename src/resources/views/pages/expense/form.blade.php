@extends('theme/master_layout')

@section('content')
    <div class="">
        <h1>
            @if (empty($model->id)) {{ __('Add') }} @else {{ __('Edit') }} @endif  {{ __('Expense') }}
            <button type="button" class="btn btn-info float-end sidebarCollapse btn-sm">
                <span><i class="far fa-calendar-alt"></i>  {{ __('Recurrent') }}</span>
            </button>
        </h1>
        <x-help>
            <div class="mb-2">
                {{ __('Expenses are transactions where you spend money.') }}
            </div>
            <div class="mb-2">
                {{ __('A expense can have a specific category, this helps to have better expense reports.') }}
            </div>
            <div class="mb-2">
                {{ __('A expense can be related to a Wallet, if you select a wallet the expense amount will be discounted from the wallet balance.') }}
            </div>
            <div class="mb-2">
                {{ __('The wallet currency will be applied to the expense, So if the wallets is of US dollars and the expense amount is 100, it will represent 100 US Dolars') }}
            </div>
            <div class="mb-2">
                {{ __('If you do not select a wallet, the default currency will be used.') }}
            </div>
        </x-help>
        <div class="side-wrapper">
            {!! forms()->create('expense', !empty($model) ? $model : null) !!}
            <div class="row">
                <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
                    <div class="form-group">
                        {!! forms()->field(__('Date') . ': *', 'date', 'date', (empty($model->date) ? Carbon\Carbon::now()->format('Y-m-d'): $model->date->format('Y-m-d'))) !!}
                    </div>

                    <div class="form-group">
                        {!! forms()->field(__('Amount') , 'amount', 'number', ($model->amount ?: ''))->attribute('step','0.00000001') !!}
                    </div>

                    <div class="form-group">
                        {!! forms()->field(__('Description') , 'description', 'text', ($model->description ?: '')) !!}
                    </div>

                    <div>
                        {{ forms()->hidden('recurrent_expense_id', ($model->recurrent_expense_id ?: 0)) }}
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <div>
                            <label for="email" class="font-weight-bold"> {{ __('Category') }}: *</label>
                            <span class="mt-1 mb-1 float-end">
                                <a href="{{ route('category.create', ['gt=expense.create']) }}">
                                    <i class="fas fa-plus"></i> {{ __('Add Category') }}
                                </a>
                            </span>
                        </div>
                        <x-categories-drop-down name="category_id"
                            addEmpty="true"
                            use_as_label="category"
                            selected="{{ empty($model) ? 0 : $model->category_id }}"
                        />
                    </div>

                    <div class="form-group mb-3">
                        <div>
                            <label for="email" class="font-weight-bold">
                                {{ __('Wallet') }}:
                            </label>
                            <span class="mt-1 mb-1 float-end">
                                <a href="{{ route('wallet.create', ['gt=expense.create']) }}">
                                    <i class="fas fa-plus"></i> {{ __('Add Wallet') }}
                                </a>
                            </span>
                        </div>

                        <x-wallet-drop-down name="wallet_id"
                            selected="{{ empty($model) ? 0 : $model->wallet_id }}"
                            add_empty="true"
                        />
                    </div>
                    <div class="form-group mb-3">
                        <label class="strong font-weight-bold mb-1" for="receipts">Receipts</label>
                        @if (!empty($model))
                            <div class="receipts">
                                @foreach($model->receipts as $receipt)
                                    <div class="receipt filepond--custom--preview-container">
                                        @if ($receipt->isImage())
                                            <img src="{{ $receipt->url() }}" class="img-fluid mb-3" />
                                        @else
                                            <a href="{{ $receipt->url() }}" target="_blank" class="mb-2 d-block">
                                                <i class="fas fa-download"></i>&nbsp;
                                                {{ basename($receipt->path) }}
                                            </a>
                                        @endif
                                        <div class="filepond--custom-delete" data-delete-url="{{ route('receipt.delete', ['receipt' => $receipt]) }}">
                                            X
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <input type="file" name="receipts[]" class="filepond" multiple data-allow-reorder="true" data-state="{{ json_encode(old('receipts')) }}"/>
                    </div>

                </div>

                <div class="col-12">
                    <div class="form-group">
                        {!! forms()->submit('Save') !!}
                        <a class="btn btn-warning" href="{{ route('expense.index') }}">
                            {{ __('Cancel') }}
                        </a>
                        @if (!empty($model) and !empty($model->id))
                            <a href="{{ route('expense.delete', ['expense' => $model->id]) }}"
                               class="btn btn-danger float-end as-submit" method="DELETE">
                               {{ __('Delete') }}
                            </a>
                        @endif
                    </div>
                </div>
                {!! forms()->end() !!}
            </div>

            <div class="sidepanel" id="fill-from-recurrent">
                <div class="mb-4">
                    <label class="font-weight-bold"> {{ __('Use a recurrent expense.') }}</label>
                    <button type="button"
                            class="btn btn-danger font-weight-bold float-end sidebarCollapse">
                        <span>X</span>
                    </button>
                </div>

                <table width="100%" class="table">
                    <thead>
                        <tr>
                            <th class=""></th>
                            <th class="d-block d-sm-table-cell">{{ __('Description') }}</th>
                            <th class="d-block d-sm-table-cell">{{ __('Last Payment') }}</th>
                            <th class="d-block d-sm-table-cell">{{ __('Amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($recurrent_expenses as $recurrent)
                        <tr @class(['paid' => $recurrent->usedThisMonth()])>
                            <td class="">
                                <span class="btn btn-info fill-expense btn-sm"
                                      data-expense="{{ $recurrent->getJsonData() }}">
                                      {{ __('Use') }}
                                </span>
                            </td>
                            <td class="d-block d-sm-table-cell">
                                {{ $recurrent->description }}
                            </td>
                            <td class="d-block d-sm-table-cell">
                                {{
                                    empty($recurrent->last_use_date)
                                        ? __('Never') :
                                        $recurrent->last_use_date->format('m/d/Y')
                                }}
                            </td>
                            <td class="d-block d-sm-table-cell">
                                <strong>{{ $recurrent->amount_formatted }}</strong>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
