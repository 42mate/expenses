<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 ">{{ __('Pending Payments') }}
            @if (count($recurrent_expense_pending_payment) > 0)
            <strong>
                ({{ count($recurrent_expense_pending_payment) }}) -
                $ {{ number_format($recurrent_expense_pending_payment->sum('amount'), 2) }}
            </strong>
            @endif
        </h6>
    </div>
    <div class="card-body">
        @if (count($recurrent_expense_pending_payment) == 0)
            <div class="text-center">
                {{ __("You don't have any pending payments :)") }}
            </div>
        @else
            @include('includes._recurrent_expense_table',
                ['recurrent_expenses' => $recurrent_expense_pending_payment,
                'use_pay_button' => true])
        @endif
    </div>
</div>
