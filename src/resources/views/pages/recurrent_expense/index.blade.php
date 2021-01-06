@extends('theme/master_layout')

@section('content')
    <div class="">
        <h1 class="mb-3">
            <i class="far fa-calendar-alt"></i> {{ __('Recurrent Expenses') }}
            <div class="add_control">
                <a href="{{ route('recurrent_expense.create') }}">
                    <i class="fas fa-plus"></i> {{ __("Add a recurrent expense") }}
                </a>
            </div>
        </h1>
        <div class="">
            <div class="table">
                @forelse ($recurrent_expenses as $expense)
                    @if ($loop->first)
                        <table class="table table-bordered"
                               width="100%"
                               cellspacing="0">
                            <thead>
                            <tr>
                                <th class="d-block d-sm-table-cell">Description</th>
                                <th class="d-block d-sm-table-cell">Category</th>
                                <th class="d-block d-sm-table-cell">Last Payment</th>
                                <th class="d-block d-sm-table-cell">Total</th>
                            </tr>
                            </thead>
                            @endif
                            <tr>
                                <td class="d-block d-sm-table-cell">
                                    <a href="{{ route('recurrent_expense.edit', ['recurrent_expense' => $expense->id]) }}"
                                       class="font-weight-bold">
                                        {{ $expense->description }}
                                    </a>
                                </td>
                                <td class="d-block d-sm-table-cell">
                                    {{ $expense->category->category }}
                                </td>
                                <td class="d-block d-sm-table-cell">
                                    {{ empty($expense->last_use_date) ? 'Never' : $expense->last_use_date->format('Y-m-d') }}
                                </td>
                                <td class="d-block d-sm-table-cell font-weight-bold">
                                    {{ $expense->amount_formatted}}
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
                    {{ $recurrent_expenses->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
