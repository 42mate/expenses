@extends('theme/master_layout')

@section('content')
    <div class="">
        <h1 class="mb-5">
            <i class="far fa-calendar-alt"></i> {{ __('Recurrent Expenses') }}
            <div class="add_control">
                <a href="{{ route('recurrent_expense.create') }}">
                    <i class="fas fa-plus"></i> {{ __("Add a recurrent expense") }}
                </a>
            </div>
        </h1>
        <div class="">
            @forelse ($recurrent_expenses as $expense)
                @if ($loop->first)
                    <table class="table"
                           width="100%"
                           cellspacing="0">
                        <thead>
                        <tr>
                            <th class="d-block d-sm-table-cell">Description</th>
                            <th class="d-block d-sm-table-cell">Category</th>
                            <th class="d-block d-sm-table-cell">Last Payment</th>
                            <th class="d-block d-sm-table-cell">Periodicity</th>
                            <th class="d-block d-sm-table-cell text-right">Total</th>
                            <th class="d-block d-sm-table-cell"></th>
                        </tr>
                        </thead>
                @endif

                <tr>
                    <td class="d-block d-sm-table-cell">
                        {{ $expense->description }}
                    </td>
                    <td class="d-block d-sm-table-cell">
                        {{ $expense->category->category }}
                    </td>
                    <td class="d-block d-sm-table-cell">
                        @if (empty($expense->last_use_date))
                            <a href="{{ route('recurrent_expense.update', ['recurrent_expense' => $expense->id ]) }}">
                                Never
                            </a>
                        @else
                            {{ $expense->last_use_date->format('Y-m-d') }}
                        @endif
                    </td>
                    <td class="d-block d-sm-table-cell">
                        @switch($expense->period)
                            @case(1) Monthly @break
                            @case(2) Bimonthly @break
                            @case(3) Trimonthly @break
                            @case(6) Bianual @break
                            @case(12) Anual @break
                        @endswitch
                    </td>
                    <td class="d-block d-sm-table-cell font-weight-bold text-right">
                        {{ $expense->amount_formatted}}
                    </td>
                    <td class="text-right">
                        <a href="{{ route('recurrent_expense.edit', ['recurrent_expense' => $expense->id]) }}"
                           class="btn btn-primary btn-sm">
                            Edit
                        </a>
                    </td>
                </tr>

                @if ($loop->last)
                    </table>
                @endif
            @empty
                <div class="text-center">
                    <a href="{{ route('recurrent_expense.create') }}" class="btn btn-primary">
                        Add a recurrent Expense
                    </a>
                </div>
            @endforelse
            <div>
                {{ $recurrent_expenses->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
