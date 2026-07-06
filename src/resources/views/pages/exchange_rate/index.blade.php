@extends('theme/master_layout')

@section('content')
    @php
        $fmt = function ($v) {
            if ($v === null) {
                return null;
            }
            if (abs($v) >= 1) {
                return number_format($v, 2);
            }
            return rtrim(rtrim(number_format($v, 8), '0'), '.');
        };
    @endphp

    <div class="">
        <h1>
            <i class="fa-solid fa-right-left"></i> {{ __('Exchange Rates') }}
            <div class="add_control">
                <form method="POST" action="{{ route('exchange_rates.refresh') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 border-0">
                        <i class="fas fa-arrows-rotate"></i> {{ __('Refresh now') }}
                    </button>
                </form>
            </div>
        </h1>

        <p class="text-muted">
            {{ __('All amounts across the app are converted to your display currency') }}:
            <strong>{{ $displayCurrency->code }} ({{ $displayCurrency->symbol }})</strong>.
            @if ($last_updated)
                — {{ __('Rates last updated') }}: {{ \Illuminate\Support\Carbon::parse($last_updated)->format('Y-m-d H:i') }}
            @endif
        </p>

        <div class="">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('Currency') }}</th>
                        <th>{{ __('Type') }}</th>
                        <th class="text-end">1 {{ $displayCurrency->code }} =</th>
                        <th class="text-end">{{ __('Value in') }} {{ $displayCurrency->code }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($currencies as $currency)
                        @php
                            $toDisplay = $currencyConverter->convert(1, $currency->code, $displayCurrency->code);
                            $fromDisplay = $currencyConverter->convert(1, $displayCurrency->code, $currency->code);
                            $source = $sources[strtoupper($currency->code)] ?? null;
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $currency->code }}</strong>
                                <span class="text-muted">{{ $currency->name }}</span>
                            </td>
                            <td>
                                @if ($source === 'crypto')
                                    <span class="badge bg-info">{{ __('Crypto') }}</span>
                                @elseif ($source === 'fiat')
                                    <span class="badge bg-secondary">{{ __('Fiat') }}</span>
                                @else
                                    <span class="badge bg-warning">{{ __('No rate') }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if ($fromDisplay !== null)
                                    {{ $fmt($fromDisplay) }} {{ $currency->code }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="text-end">
                                @if ($toDisplay !== null)
                                    {{ $displayCurrency->symbol }} {{ $fmt($toDisplay) }}
                                @else
                                    <span class="text-muted">{{ __('Not available') }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
