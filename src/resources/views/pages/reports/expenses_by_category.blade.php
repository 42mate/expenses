@extends('theme/master_layout')

@section('content')
    <div class="categoryPie">
        <div class="row">
            <div class="col-12">

            </div>
        </div>
        <div class="row">
            <div class="card-body col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        {{ __('Expenses by Cateogry') }}
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <label for="category"> {{ __('Select a currency') }}:</label>

                            <x-currencies-drop-down name="currency_id"
                                                    use_as_label="name"
                                                    onlyInUse="yes"
                                                    selected="{{ (empty(request()->get('currency_id', null)) ? '' : request()->get('currency_id'))}}"
                            />
                        </div>
                        <div class="badge-warning result-message mb-2 p-2 rounded text-center" style="display: none;"></div>
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
