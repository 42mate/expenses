@extends('theme/master_layout')

@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Today
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">$ {{ $today }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="far fa-calendar-plus fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Week
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">$ {{ $week }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="far fa-calendar-minus fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Month
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">$ {{ $month }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="far fa-calendar-alt fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Last Month
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    $ {{ $last_month }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="far fa-calendar-check fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row row-eq-height">

                            <!-- Content Column -->
                            <div class="col-lg-6 ">

                                <!-- Project Card Example -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 ">Expenses by categories</h6>
                                    </div>
                                    <div class="card-body">
                                        @if (count($expenses) === 0)
                                            <div>Good, you don't have any expense in this month.</div>
                                        @else
                                            <canvas class="chart" type="pie"
                                                    data="/api/v1/charts/categories"
                                                    width="100%"
                                                    height="80px"
                                                    show_legend="0">
                                            </canvas>
                                        @endif
                                    </div>
                                </div>

                                <!-- Project Card Example -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 ">Pending Payments <strong>({{ count($recurrent_expense_pending_payment) }}) - $ {{$recurrent_expense_pending_payment->sum('amount')}}</strong></h6>
                                    </div>
                                    <div class="card-body">
                                        @include('includes._recurrent_expense_table', ['recurrent_expenses' => $recurrent_expense_pending_payment, 'use_pay_button' => true])
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <!-- Illustrations -->
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        This month expenses
                                    </div>
                                    <div class="card-body">
                                        <div class="table">
                                            <table class="table table-bordered  display responsive table-home"
                                                   width="100%" cellspacing="0">

                                                @forelse ($expenses as $expense)
                                                    @if ($loop->first)
                                                        <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th class="d-block d-sm-table-cell">Category</th>
                                                            <th class="d-block d-sm-table-cell font-weight-bold">
                                                                Amount
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                    @endif
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('expense.edit', [$expense->id]) }}" class="font-weight-bold">
                                                                {{ $expense->date }}
                                                            </a>
                                                        </td>
                                                        <td class="d-block d-sm-table-cell">
                                                            <a href="{{ route('expense.index', ['category_id' => $expense->category->id]) }}">
                                                                {{ $expense->category->category }}
                                                            </a>
                                                        </td>
                                                        <td class="d-block d-sm-table-cell font-weight-bold">
                                                            {{ $expense->amount_formatted }}
                                                        </td>
                                                    </tr>
                                                    @if ($loop->last)
                                                    @endif
                                                @empty
                                                    <tr>
                                                        <td>
                                                            <p class="text-center">Good, you don't have any expense in
                                                                this
                                                                month.</p>
                                                            <div class="text-center">
                                                                <a href="{{ route('expense.create') }}"
                                                                   class="btn btn-primary">
                                                                    Add your first expense
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </table>
                                        </div>
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
