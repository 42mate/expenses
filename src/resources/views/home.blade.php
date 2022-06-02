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
                                @include('includes._widget_month_totals', [
                                    'today' => $today,
                                    'week' => $week,
                                    'month' => $month,
                                    'last_month' => $last_month,
                                ])
                            </div>
                            <div class="col-lg-5 ">
                                <div class="mb-4">
                                    @include('includes._widget_pending_payments', ['recurrent_expense_pending_payment' => $recurrent_expense_pending_payment])
                                </div>
                                <div class="mb-4">
                                    @include('includes._widget_this_month_expenses', ['expenses' => $expenses])
                                </div>
                            </div>
                            <div class="col-lg-4 ">
                                @include('includes._widget_chart_by_category', ['expenses' => $expenses])
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
