<div class="col-lg-3">
    <div @class(['card']) >
        <div class="card-header">
                {{ __('Wallets') }}
        </div>
        <div class="card-body">
            @if (empty($totals))
                <div>
                    <div class="mb-2">
                        <p>
                            {{ __('Wallets are where you have the money, a bank account, a digital wallet, a crypto wallet, or a box with money in your house.') }}
                        </p>
                        <p>
                            <a href="" class="small">{{ __('Learn more') }}</a>
                        </p>
                    </div>
                </div>
            @endif

            @foreach($wallets as $wallet)
                <div class="mb-2">
                        <span class="text-primary text-uppercase font-weight-bold text-xs">
                            <a href="{{ route('wallet.edit', ['wallet' => $wallet->id]) }}">
                                {{ $wallet->name }} ({{ $wallet->currency->code }})
                            </a>
                        </span>
                    <span class="font-weight-bold text-right float-right small">{{ $wallet->currency->symbol }} {{ floatval($wallet->balance) }}</span>
                </div>
            @endforeach

            @include('includes._totals_transactions_index', ['totals' => $totals])
        </div>
    </div>
</div>

