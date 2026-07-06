@php
    $__items = [];
    foreach ($totals as $__t) {
        $__items[] = ['code' => $__t['currency']->code, 'amount' => $__t['sum']];
    }
    $__sum = $currencyConverter->sumToDisplay($__items);
@endphp
<div class="spacer"></div>
<div class="d-flex flex-row-reverse">
    <div class="d-table mt-3 mb-3">
        <div class="small font-weight-bold text-end d-table-row">
            <span class="text-end d-table-cell">
                {{ $displayCurrency->symbol }} {{ number_format($__sum['total'], 2) }}
                <span class="text-muted">{{ $displayCurrency->code }}</span>
            </span>
        </div>
        @if(!empty($__sum['skipped']))
            <div class="small text-muted text-end d-table-row">
                <span class="text-end d-table-cell">
                    {{ __('Excludes') }}: {{ implode(', ', $__sum['skipped']) }}
                </span>
            </div>
        @endif
    </div>
</div>
