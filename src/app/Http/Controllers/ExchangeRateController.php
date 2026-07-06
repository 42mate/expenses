<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Artisan;

class ExchangeRateController extends Controller
{
    public function index()
    {
        // Map each app currency code to the source (fiat/crypto) we stored for it.
        $sources = ExchangeRate::pluck('source', 'code')
            ->mapWithKeys(fn ($s, $c) => [strtoupper($c) => $s])
            ->toArray();

        return view('pages.exchange_rate.index', [
            'currencies' => Currency::orderBy('name')->get(),
            'sources' => $sources,
            'last_updated' => ExchangeRate::max('fetched_at'),
        ]);
    }

    public function refresh()
    {
        $code = Artisan::call('exchange-rates:fetch');

        if ($code === 0) {
            return redirect()->route('exchange_rates.index')
                ->with('success', 'Exchange rates updated.');
        }

        return redirect()->route('exchange_rates.index')
            ->with('warning', 'Could not fetch new rates (the rate providers may be unreachable). Kept the last-known rates.');
    }
}
