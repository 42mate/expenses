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
                        <div class="mb-2 text-muted small">
                            {{ __('Amounts are shown in your display currency') }}: {{ $displayCurrency->code }}
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
