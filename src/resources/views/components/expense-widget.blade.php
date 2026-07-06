@php
    $isIncome = ($title === 'Incomes');
    $__items = [];
    foreach ($data as $__t) {
        $__items[] = ['code' => $__t->code, 'amount' => $__t->total];
    }
    $__sum = $currencyConverter->sumToDisplay($__items);
@endphp
<div class="col-12 col-sm-6">
    <div class="card dashboard-card kpi-card h-100">
        <div class="kpi-top">
            <span class="dc-title">
                <span class="dc-icon {{ $isIncome ? 'is-income' : 'is-expense' }}">
                    <i class="fas {{ $isIncome ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}"></i>
                </span>
                {{ __($title) }}
            </span>
            <a href="{{ $create_route }}" class="dc-add" title="{{ __('Add') }} {{ __($title) }}">
                <i class="fas fa-plus"></i>
            </a>
        </div>
        <div class="kpi-body">
            <div class="kpi-value {{ $isIncome ? 'is-income' : 'is-expense' }}">
                {{ $displayCurrency->symbol }} {{ number_format($__sum['total'], 2) }}
            </div>
            <div class="kpi-sub">{{ __('This month') }} · {{ $displayCurrency->code }}</div>
            @if (!empty($__sum['skipped']))
                <div class="kpi-sub">{{ __('Excludes') }}: {{ implode(', ', $__sum['skipped']) }}</div>
            @endif
        </div>
        @if ($index_route)
            <a class="kpi-link" href="{{ $index_route }}">
                {{ __('View all') }} <i class="fas fa-arrow-right ms-1"></i>
            </a>
        @endif
    </div>
</div>
