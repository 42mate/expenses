@extends('theme/master_layout')

@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="">
                    <div class="card-body">
                        <div class="row">
                            <!-- Content Column -->
                            <div class="col-lg-3">
                                <h4 class="mb-5">{{ __('Expenses') }}</h2>
                                @include('includes._widget_month_totals', $expenses)
                                <div class="">
                                    <a href="{{ route('expense.create') }}">
                                        <i class="fas fa-plus"></i> {{ __("Add expense") }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <h4 class="mb-5">{{ __('Incomes') }}</h2>
                                @include('includes._widget_month_totals', $incomes)
                                <div class="">
                                    <a href="{{ route('incomes.create') }}">
                                        <i class="fas fa-plus"></i> {{ __("Add Income") }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <h4 class="mb-5">{{ __('Wallets Balance') }}</h2>
                                    <div @class([
                                            'card', 
                                            'border-left-success' => ($balances['total']['balance'] > 0), 
                                            'border-left-danger' => ($balances['total']['balance'] < 0)]) >
                                        <div class="card-body">
                                            @foreach($balances as $balance) 
                                            <div class="mb-3">
                                                <div class="text-primary text-uppercase font-weight-bold text-xs">{{ $balance['wallet'] }}: </div>
                                                <div class="font-weight-bold text-right">$ {{ $balance['balance'] }}</div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
