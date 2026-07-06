<div class="col-12">
    <div class="card dashboard-card h-100">
        <div class="card-header dashboard-card-header">
            <span class="dc-title">
                <span class="dc-icon is-wallet"><i class="fas fa-wallet"></i></span>
                {{ __('Wallets') }}
            </span>
            <a href="{{ route('wallet.index') }}" class="dc-add" title="{{ __('Manage wallets') }}">
                <i class="fas fa-plus"></i>
            </a>
        </div>
        <div id="walletList" class="card-body dashboard-card-body dc-scroll">
            @forelse($wallets as $wallet)
                @php
                    $__converted = $currencyConverter->toDisplay(floatval($wallet->balance), $wallet->currency->code);
                @endphp
                <div class="dc-row">
                    <a class="dc-row-label" href="{{ route('wallet.edit', ['wallet' => $wallet->id]) }}">
                        {{ $wallet->name }}
                        <span class="dc-code">{{ $wallet->currency->code }}</span>
                    </a>
                    <span class="dc-row-value"
                          title="{{ $wallet->currency->symbol }} {{ number_format(floatval($wallet->balance), 2) }}">
                        @if($__converted !== null)
                            {{ $displayCurrency->symbol }} {{ number_format($__converted, 2) }}
                        @else
                            {{ $wallet->currency->symbol }} {{ number_format(floatval($wallet->balance), 2) }}
                        @endif
                    </span>
                </div>
            @empty
                <div class="dc-empty">
                    <i class="fas fa-wallet"></i>
                    <p>{{ __('Wallets are where you keep your money — a bank account, a digital or crypto wallet, or cash at home.') }}</p>
                </div>
            @endforelse
        </div>
        @if (count($wallets) > 6)
            <button type="button" class="dc-toggle" data-target="#walletList">
                <span class="dc-toggle-more">{{ __('Show all') }} <i class="fas fa-chevron-down"></i></span>
                <span class="dc-toggle-less">{{ __('View less') }} <i class="fas fa-chevron-up"></i></span>
            </button>
        @endif
        @if (!empty($totals))
            @php
                $__items = [];
                foreach ($totals as $__t) {
                    $__items[] = ['code' => $__t['currency']->code, 'amount' => $__t['sum']];
                }
                $__sum = $currencyConverter->sumToDisplay($__items);
            @endphp
            <div class="card-footer dashboard-card-footer dc-totals">
                <span class="dc-totals-label">{{ __('Total balance') }}</span>
                <div class="dc-total-row">
                    <span class="dc-code">{{ $displayCurrency->code }}</span>
                    <span class="dc-total-value">
                        {{ $displayCurrency->symbol }} {{ number_format($__sum['total'], 2) }}
                    </span>
                </div>
                @if (!empty($__sum['skipped']))
                    <div class="dc-total-row">
                        <span class="dc-code small text-muted">
                            {{ __('Excludes') }}: {{ implode(', ', $__sum['skipped']) }}
                        </span>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
