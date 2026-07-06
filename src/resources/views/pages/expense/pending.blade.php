@extends('theme/master_layout')

@section('content')
    <div class="">
        <h1 class="mb-4 "><i class="fa-solid fa-bell"></i> {{ __('Pending Payments') }}</h1>

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
                @php
                    $__items = [];
                    foreach ($recurrent_expense_pending_payment as $__p) {
                        $__items[] = ['code' => $__p->currency->code, 'amount' => $__p->amount];
                    }
                    $__sum = $currencyConverter->sumToDisplay($__items);
                @endphp
                <strong>
                    {{ __('Pending Payments:') }} ({{ count($recurrent_expense_pending_payment) }})
                    {{ $displayCurrency->symbol }} {{ number_format($__sum['total'], 2) }} {{ $displayCurrency->code }}
                </strong>
                @if(!empty($__sum['skipped']))
                    <div class="small text-muted">{{ __('Excludes') }}: {{ implode(', ', $__sum['skipped']) }}</div>
                @endif
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
                @php
                    $__itemsPaused = [];
                    foreach ($recurrent_expenses_paused as $__p) {
                        $__itemsPaused[] = ['code' => $__p->currency->code, 'amount' => $__p->amount];
                    }
                    $__sumPaused = $currencyConverter->sumToDisplay($__itemsPaused);
                @endphp
                <strong>
                    {{ __('Pending Payments Paused:') }} ({{ count($recurrent_expenses_paused) }}) -
                    {{ $displayCurrency->symbol }} {{ number_format($__sumPaused['total'], 2) }} {{ $displayCurrency->code }}
                </strong>
                @if(!empty($__sumPaused['skipped']))
                    <div class="small text-muted">{{ __('Excludes') }}: {{ implode(', ', $__sumPaused['skipped']) }}</div>
                @endif
            @endif
        </div>
    </div>

@endsection
