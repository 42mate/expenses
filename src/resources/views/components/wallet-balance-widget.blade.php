<div class="col-lg-3">
    <h4 class="mb-5">
        <a href="{{ route('wallet.index') }}">
            {{ __('Wallets') }}
            </a>
        </h4>
        <div @class(['card']) >
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
                    <div class="mb-3">
                        <span class="text-primary text-uppercase font-weight-bold text-xs">
                            <a href="{{ route('wallet.edit', ['wallet' => $wallet->id]) }}">
                                {{ $wallet->name }} ({{ $wallet->currency->symbol }})
                            </a>
                        </span>
                        <span class="font-weight-bold text-right float-right">$ {{ floatval($wallet->balance) }}</span>
                    </div>
                @endforeach

                @include('includes._totals_transactions_index', ['totals' => $totals])
            </div>
        </div>
</div>

