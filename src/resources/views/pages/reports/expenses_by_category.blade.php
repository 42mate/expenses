@extends('theme/master_layout')

@section('content')
    <h1>{{ __('Expenses by Cateogry') }}</h1>
    <div class="categoryPie">
        <div class="row">
            <div class="col-4">
                <label for="category"> {{ __('Currency') }}:</label>

                <x-currencies-drop-down name="currency_id"
                                        addEmpty="true"
                                        use_as_label="name"
                                        selected="{{ (empty(request()->get('currency_id', null)) ? '' : request()->get('currency_id'))}}"
                />
            </div>
        </div>
        <div class="row">
            <div class="card-body col-4">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <canvas class="pie"
                                data="{{ route('api.transactions.expense.category') }}"

                                show_legend="0">
                        </canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
