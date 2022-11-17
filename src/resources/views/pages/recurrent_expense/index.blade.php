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
                            <th class="d-block d-sm-table-cell">{{ __('Description') }}</th>
                            <th class="d-block d-sm-table-cell">{{ __('Category') }}</th>
                            <th class="d-block d-sm-table-cell">{{ __('Last Payment') }}</th>
                            <th class="d-block d-sm-table-cell">{{ __('Periodicity') }}</th>
                            <th class="d-block d-sm-table-cell text-right">{{ __('Total') }}</th>
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
                                {{ __('Never') }}
                            </a>
                        @else
                            {{ $expense->last_use_date->format('Y-m-d') }}
                        @endif
                    </td>
                    <td class="d-block d-sm-table-cell">
                        @switch($expense->period)
                            @case(1) {{ __('Monthly') }} @break
                            @case(2) {{ __('Bimonthly') }} @break
                            @case(3) {{ __('Trimonthly') }} @break
                            @case(6) {{ __('Bianual') }} @break
                            @case(12) {{ __('Anual') }}@break
                        @endswitch
                    </td>
                    <td class="d-block d-sm-table-cell font-weight-bold text-right">
                        {{ $expense->amount_formatted}}
                    </td>
                    <td class="text-right">
                        <a href="{{ route('recurrent_expense.edit', ['recurrent_expense' => $expense->id]) }}"
                           class="btn btn-primary btn-sm">
                           {{ __('Edit') }}
                        </a>
                    </td>
                </tr>

                @if ($loop->last)
                    </table>
                @endif
            @empty
                <div class="text-center">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-2">
                                {{ __('Recurrent expenses are expenses that you do on a given period of time.') }} <br />
                                {{ __('You can preconfigure all the values of the expense so it makes easy to record the expense') }}<br />
                                {{ __('In pending payment you can see the month agenda of pending payment and from there create the expense record') }}
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('recurrent_expense.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> {{ __('Add your first recurrent Expense') }}
                    </a>
                </div>
            @endforelse
            <div>
                {{ $recurrent_expenses->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
