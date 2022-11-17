@extends('theme/master_layout')

@section('content')
    <div class="">
        <h1 class="mb-5">
            <i class="fas fa-money-bill-wave"></i> {{ __('Expenses') }}
            <div class="add_control">
                <a href="{{ route('expense.create') }}">
                    <i class="fas fa-plus"></i> {{ __("Add expense") }}
                </a>
            </div>
        </h1>
        <div class="">
            @include('includes._form_transactions_filter', ['type' => 'expense', 'errors' => $errors])
            <div>
                @forelse ($expenses as $expense)
                    @if ($loop->first)
                        <table class="table"
                               width="100%"
                               cellspacing="0">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th class="d-block d-sm-table-cell">{{ __('Category') }}</th>
                                <th class="d-block d-sm-table-cell">{{ __('Wallet') }}</th>
                                <th class="d-block d-sm-table-cell">{{ __('Description') }}</th>
                                <th class="d-block d-sm-table-cell">{{ __('Currency') }}</th>
                                <th class="d-block d-sm-table-cell text-right">{{ __('Total') }}</th>
                                <th class="d-block d-sm-table-cell text-right"></th>
                            </tr>
                            </thead>
                    @endif
                        <tr>
                            <td>
                                <span class="font-weight-bold">
                                    {{ $expense->date->format('Y-m-d') }}
                                </span>
                            </td>
                            <td class="d-block d-sm-table-cell">
                                <a href="{{ route('expense.index',
                                    ['category_id' => $expense->category_idx]) }}">
                                    {{ $expense->category_name }}
                                </a>
                            </td>
                            <td class="d-block d-sm-table-cell">
                                <a href="{{ route('expense.index',
                                    ['wallet_id' => $expense->wallet_idx]) }}">
                                    {{ $expense->wallet_name }}
                                </a>
                            </td>
                            <td class="d-block d-sm-table-cell">
                                {{ $expense->description }}
                            </td>
                            <td class="d-block d-sm-table-cell ">
                                {{ $expense->currency->code }}
                            </td>
                            <td class="d-block d-sm-table-cell font-weight-bold text-right">
                                {{ $expense->amount_formatted }}
                            </td>
                            <td class="text-right">
                                <a href="{{ route('expense.edit', [$expense->id]) }}"
                                    class="btn btn-primary btn-sm">
                                   {{ __('Edit') }}
                                </a>
                            </td>
                        </tr>
                    @if ($loop->last)
                        </table>

                        @include('includes._totals_transactions_index', ['totals' => $totals])

                        <div class="center">
                            {{ $expenses->withQueryString()->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
                @empty
                    <p class="text-center">{{ __("Good, you don't have any expense in this month.") }}</p>
                    <div class="text-center">
                        <a href="{{ route('expense.create') }}" class="btn btn-primary">
                            {{ __("Add your first expense") }}
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
