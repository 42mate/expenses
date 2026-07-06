<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 ">{{ __('Pending Payments') }}
            @if (count($recurrent_expense_pending_payment) > 0)
            @php
                $__items = [];
                foreach ($recurrent_expense_pending_payment as $__p) {
                    $__items[] = ['code' => $__p->currency->code, 'amount' => $__p->amount];
                }
                $__sum = $currencyConverter->sumToDisplay($__items);
            @endphp
            <strong>
                ({{ count($recurrent_expense_pending_payment) }}) -
                {{ $displayCurrency->symbol }} {{ number_format($__sum['total'], 2) }}
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
