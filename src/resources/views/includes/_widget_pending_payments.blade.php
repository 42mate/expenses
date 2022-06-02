<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 ">Pending Payments
            <strong>({{ count($recurrent_expense_pending_payment) }}) -
                $ {{$recurrent_expense_pending_payment->sum('amount')}}</strong></h6>
    </div>
    <div class="card-body">
        @include('includes._recurrent_expense_table', ['recurrent_expenses' => $recurrent_expense_pending_payment, 'use_pay_button' => true])
    </div>
</div>
