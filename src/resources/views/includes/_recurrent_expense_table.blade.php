<table class="table display responsive">
    <thead>
    <tr>
        <th class="d-block d-sm-table-cell">Category</th>
        <th class="d-block d-sm-table-cell">Description</th>
        <th class="d-block d-sm-table-cell">Last Payment</th>
        <th class="d-block d-sm-table-cell text-right">Amount</th>
        <th class=""></th>
    </tr>
    </thead>
    <tbody>
    @foreach($recurrent_expenses as $recurrent)
        <tr @if ($recurrent->usedThisMonth())
            style="background-color: rgb(247 247 247 / 22%)"
            @endif>

            <td class="d-block d-sm-table-cell">
                {{ $recurrent->category->category }}
            </td>
            <td class="d-block d-sm-table-cell">
                {{ $recurrent->description }}
            </td>
            <td class="d-block d-sm-table-cell">
                @if (empty($recurrent->last_use_date))
                    <a href="{{ route('recurrent_expense.update', ['recurrent_expense' => $recurrent->id ]) }}">
                        Never
                    </a>
                @else
                    {{ $recurrent->last_use_date->format('Y-m-d') }}
                @endif
            </td>
            <td class="d-block d-sm-table-cell">
                <strong>{{ $recurrent->amount_formatted }}</strong>
            </td>
            <td class="text-right">
                @if ($use_pay_button)
                    <a class="btn btn-success pay btn-sm" href="{{ route('expense.create', ['recurrent_expense' => $recurrent->id]) }}">Pay</a>
                @else
                    <span class="btn btn-info fill-expense" data-expense="{{ $recurrent->getJsonData() }}">Use</span>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
