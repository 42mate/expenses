<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * Presentation-layer currency conversion. Stored amounts are never touched;
 * this converts a native amount into the current user's display currency using
 * the locally cached exchange_rates table (base = USD, rate = units per USD).
 *
 * Registered as a singleton so the rate map and the resolved display currency
 * are loaded at most once per request.
 */
class CurrencyConverter
{
    public const CACHE_KEY = 'exchange_rates_map';

    /**
     * App currency codes that don't match the rate-table keys.
     * The Euro row is seeded with code "EU" but rates use ISO "EUR".
     */
    private const ALIASES = [
        'EU' => 'EUR',
    ];

    /** @var array<string, float>|null */
    private ?array $rates = null;

    private ?Currency $resolvedDisplayCurrency = null;

    /**
     * @return array<string, float>
     */
    private function rates(): array
    {
        if ($this->rates === null) {
            $this->rates = Cache::rememberForever(self::CACHE_KEY, function () {
                return ExchangeRate::query()
                    ->get(['code', 'rate'])
                    ->mapWithKeys(fn ($r) => [strtoupper($r->code) => (float) $r->rate])
                    ->toArray();
            });
        }

        return $this->rates;
    }

    public static function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    private function rateFor(string $code): ?float
    {
        $code = strtoupper($code);
        $code = self::ALIASES[$code] ?? $code;

        $rates = $this->rates();

        return isset($rates[$code]) ? (float) $rates[$code] : null;
    }

    public function hasRate(string $code): bool
    {
        return $this->rateFor($code) !== null;
    }

    /**
     * Convert an amount from one currency code to another.
     * Returns null when either side has no known rate.
     */
    public function convert(float $amount, string $from, string $to): ?float
    {
        if (strtoupper($from) === strtoupper($to)) {
            return $amount;
        }

        $rf = $this->rateFor($from);
        $rt = $this->rateFor($to);

        if ($rf === null || $rt === null || $rf == 0.0) {
            return null;
        }

        // amount / rf = USD value; * rt = amount in target currency.
        return $amount * ($rt / $rf);
    }

    public function displayCurrency(): Currency
    {
        if ($this->resolvedDisplayCurrency === null) {
            $user = Auth::user();
            $this->resolvedDisplayCurrency = $user
                ? $user->resolveDisplayCurrency()
                : (Currency::find(1) ?? new Currency(['name' => 'US Dollar', 'code' => 'USD', 'symbol' => '$']));
        }

        return $this->resolvedDisplayCurrency;
    }

    /**
     * Convert an amount from its native code into the current display currency.
     */
    public function toDisplay(float $amount, string $fromCode): ?float
    {
        return $this->convert($amount, $fromCode, $this->displayCurrency()->code);
    }

    public function format(float $amount, ?Currency $currency = null): string
    {
        $currency = $currency ?: $this->displayCurrency();

        return $currency->symbol . ' ' . number_format($amount, 2);
    }

    /**
     * Fold a list of ['code' => string, 'amount' => float] into a single total
     * in the display currency.
     *
     * @return array{total: float, skipped: string[]}
     */
    public function sumToDisplay(array $items): array
    {
        $total = 0.0;
        $skipped = [];

        foreach ($items as $item) {
            $code = $item['code'] ?? null;
            $amount = (float) ($item['amount'] ?? 0);

            if ($code === null) {
                continue;
            }

            $converted = $this->toDisplay($amount, $code);
            if ($converted === null) {
                $skipped[strtoupper($code)] = strtoupper($code);
                continue;
            }

            $total += $converted;
        }

        return ['total' => $total, 'skipped' => array_values($skipped)];
    }
}
