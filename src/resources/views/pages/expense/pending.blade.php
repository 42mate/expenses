@extends('theme/master_layout')

@section('content')
    <div class="">
        <h1 class="mb-4 "><i class="fa-solid fa-bell"></i> {{ __('Pending Payments') }}</h1>

        <x-help>
            {{ __('Here you can see the payments agenda of this month. The idea is that you do not forget to pay anything else.') }}<br />
            {{ __('The list is created from your recurrent expenses, we show here the ones that you has not paid yet') }}<br />
        </x-help>

        <div class="">
            @if (count($recurrent_expense_pending_payment) == 0)
                <div class="text-center">
                    {{ __("You don't have any pending payments :)") }}
                </div>
            @else
                @include('includes._recurrent_expense_table', [
                    'recurrent_expenses' => $recurrent_expense_pending_payment,
                    'use_pay_button' => true
                ])
            @endif
        </div>
        <div class="mt-4 mb-3 text-end">
            @if (count($recurrent_expense_pending_payment) > 0)
                <strong>
                    {{ __('Pending Payments:') }} ({{ count($recurrent_expense_pending_payment) }})
                    @foreach($recurrent_expense_pending_payment->groupBy('currency_id') as $e)
                        {{ $e[0]->currency->symbol }}
                        {{ number_format($e->sum('amount'), 2) }}
                    @endforeach
                </strong>
            @endif
        </div>
        <div class="">
            @if (count($recurrent_expenses_paused) > 0)
                <h1 class="mb-4 "><i class="fa-solid fa-bell"></i> {{ __('Paused Pending Payments') }}</h1>

                @include('includes._recurrent_expense_table',
                    ['recurrent_expenses' => $recurrent_expenses_paused,
                    'use_pay_button' => true])
            @endif
        </div>
        <div class="mt-4 mb-3 text-end">
            @if (count($recurrent_expenses_paused) > 0)
                <strong>
                    {{ __('Pending Payments Paused:') }} ({{ count($recurrent_expenses_paused) }}) -
                    @foreach($recurrent_expenses_paused->groupBy('currency_id') as $e)
                        {{ $e[0]->currency->symbol }}
                        {{ number_format($e->sum('amount'), 2) }}
                    @endforeach
                </strong>
            @endif
        </div>
    </div>

@endsection
