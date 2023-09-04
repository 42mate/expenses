<table class="table display responsive">
    <thead>
        <tr>
            <th class="d-block d-sm-table-cell">{{ __('Category') }}</th>
            <th class="d-block d-sm-table-cell">{{ __('Description') }}</th>
            <th class="d-block d-sm-table-cell">{{ __('Periodicity') }}</th>
            <th class="d-block d-sm-table-cell">{{ __('Last Payment') }}</th>
            <th class="d-block d-sm-table-cell">{{ __('Past Due') }}</th>
            <th class="d-block d-sm-table-cell text-right">{{ __('Last amount') }}</th>
            <th class=""></th>
        </tr>
    </thead>
    <tbody>
    @foreach($recurrent_expenses as $recurrent)
        <tr @if ($recurrent->usedThisMonth()) style="background-color: rgb(247 247 247 / 22%)"
            @endif>

            <td class="d-block d-sm-table-cell">
                {{ $recurrent->category->category }}
            </td>
            <td class="d-block d-sm-table-cell">
                {{ $recurrent->description }}
            </td>
            <td class="d-block d-sm-table-cell">
                @switch($recurrent->period)
                    @case(1) {{ __('Monthly') }} @break
                    @case(2) {{ __('Bimonthly') }} @break
                    @case(3) {{ __('Trimonthly') }} @break
                    @case(6) {{ __('Bianual') }} @break
                    @case(12) {{ __('Anual') }}@break
                @endswitch
            </td>
            <td class="d-block d-sm-table-cell">
                @if (empty($recurrent->last_use_date))
                    <a href="{{ route('recurrent_expense.update', ['recurrent_expense' => $recurrent->id ]) }}">
                       {{ __('Never') }}
                    </a>
                @else
                    {{ $recurrent->last_use_date->format('Y-m-d') }}
                @endif
            </td>
            <td class="d-block d-sm-table-cell">
                {{ $recurrent->past_due }}
            </td>
            <td class="d-block d-sm-table-cell text-right">
                <strong>{{ $recurrent->amount_formatted }}</strong>
            </td>
            <td class="text-right">
                @if ($use_pay_button)
                    <a class="btn-primary btn pay btn-sm"
                        href="{{ route('expense.create', ['recurrent_expense' => $recurrent->id]) }}">
                        {{ __('Pay') }}
                    </a>
                    <a class="btn @if ($recurrent->paused) btn-success @else btn-danger @endif pay btn-sm"
                       href="{{ route('recurrent_expense.state_toggle', ['recurrent_expense' => $recurrent->id]) }}">
                        @if ($recurrent->paused) {{ __('Unpause') }} @else {{ __('Pause') }} @endif
                    </a>
                @else
                    <span class="btn btn-info fill-expense"
                        data-expense="{{ $recurrent->getJsonData() }}">
                        {{ __('Use') }}
                    </span>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
