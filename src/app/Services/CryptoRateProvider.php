<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Fetches crypto rates from the free CoinGecko endpoint. CoinGecko returns the
 * USD price per coin; we invert it to "units of the coin per 1 USD" so it is
 * stored on the same USD base as the fiat rates.
 */
class CryptoRateProvider
{
    /**
     * App currency code => CoinGecko id.
     */
    public const MAP = [
        'XBT' => 'bitcoin',
        'BTC' => 'bitcoin',
        'ETH' => 'ethereum',
        'USDT' => 'tether',
        'USDC' => 'usd-coin',
        'DAI' => 'dai',
    ];

    /**
     * @return array<string, float> code => units per USD
     */
    public function fetch(): array
    {
        try {
            $ids = implode(',', array_unique(array_values(self::MAP)));
            $url = config('services.exchange.crypto_url');

            $response = Http::timeout(15)->get($url, [
                'ids' => $ids,
                'vs_currencies' => 'usd',
            ]);

            if (!$response->successful()) {
                Log::warning('CryptoRateProvider: non-ok response', ['status' => $response->status()]);
                return [];
            }

            $prices = $response->json();
            if (!is_array($prices)) {
                Log::warning('CryptoRateProvider: unexpected payload');
                return [];
            }

            $out = [];
            foreach (self::MAP as $code => $id) {
                $usd = $prices[$id]['usd'] ?? null;
                if (is_numeric($usd) && $usd > 0) {
                    // units of the coin per 1 USD
                    $out[$code] = 1 / (float) $usd;
                }
            }

            return $out;
        } catch (\Throwable $e) {
            Log::error('CryptoRateProvider failed: ' . $e->getMessage());
            return [];
        }
    }
}
