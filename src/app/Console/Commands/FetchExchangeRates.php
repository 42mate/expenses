<?php

namespace App\Console\Commands;

use App\Models\ExchangeRate;
use App\Services\CryptoRateProvider;
use App\Services\CurrencyConverter;
use App\Services\FiatRateProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class FetchExchangeRates extends Command
{
    protected $signature = 'exchange-rates:fetch';

    protected $description = 'Fetch fiat + crypto exchange rates (base USD) and store them locally';

    public function handle(FiatRateProvider $fiat, CryptoRateProvider $crypto): int
    {
        $now = Carbon::now();
        $stored = 0;

        // Fiat: base USD, already units-per-USD.
        $fiatRates = $fiat->fetch();
        foreach ($fiatRates as $code => $rate) {
            $this->store($code, $rate, 'fiat', $now);
            $stored++;
        }

        // Crypto: units-per-USD (inverted from USD price).
        $cryptoRates = $crypto->fetch();
        foreach ($cryptoRates as $code => $rate) {
            $this->store($code, $rate, 'crypto', $now);
            $stored++;
        }

        // Base currency is always 1.
        $this->store('USD', 1, 'fiat', $now);

        if ($stored === 0) {
            $this->warn('No rates fetched (APIs unreachable?). Kept last-known rates.');
            return self::FAILURE;
        }

        // Invalidate the in-memory/cache rate map used by the converter.
        CurrencyConverter::flushCache();

        $this->info("Stored {$stored} exchange rates.");

        return self::SUCCESS;
    }

    private function store(string $code, float $rate, string $source, Carbon $now): void
    {
        ExchangeRate::updateOrCreate(
            ['code' => strtoupper($code)],
            ['rate' => $rate, 'source' => $source, 'fetched_at' => $now]
        );
    }
}
