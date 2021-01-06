<table width="100%" class="table table-bordered" >
    <thead>
    <tr>
        <th class=""></th>
        <th class="d-block d-sm-table-cell">Category</th>
        <th class="d-block d-sm-table-cell">Description</th>
        <th class="d-block d-sm-table-cell">Last Payment</th>
        <th class="d-block d-sm-table-cell">Amount</th>
    </tr>
    </thead>
    <tbody>
    @foreach($recurrent_expenses as $recurrent)
        <tr @if ($recurrent->usedThisMonth())
            style="background-color: rgb(247 247 247 / 22%)"
            @endif>
            <td class="">
                @if ($use_pay_button)
                    <a class="btn btn-info pay" href="{{ route('expense.create', ['recurrent_expense' => $recurrent->id]) }}">Pay</a>
                @else
                    <span class="btn btn-info fill-expense" data-expense="{{ $recurrent->getJsonData() }}">Use</span>
                @endif
            </td>
            <td class="d-block d-sm-table-cell">
                {{ $recurrent->category->category }}
            </td>
            <td class="d-block d-sm-table-cell">
                {{ $recurrent->description }}
            </td>
            <td class="d-block d-sm-table-cell">
                {{ empty($recurrent->last_use_date) ? 'Never' : $recurrent->last_use_date->format('Y-m-d') }}
            </td>
            <td class="d-block d-sm-table-cell">
                <strong>{{ $recurrent->amount_formatted }}</strong>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
