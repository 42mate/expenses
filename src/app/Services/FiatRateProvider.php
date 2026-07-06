<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Fetches fiat exchange rates from a free, no-key endpoint (open.er-api.com).
 * The response is based on USD, i.e. each value is already "units of the
 * currency per 1 USD", which is exactly how we store rates.
 */
class FiatRateProvider
{
    /**
     * @return array<string, float> code => units per USD
     */
    public function fetch(): array
    {
        try {
            $url = config('services.exchange.fiat_url');
            $response = Http::timeout(15)->get($url);

            if (!$response->successful()) {
                Log::warning('FiatRateProvider: non-ok response', ['status' => $response->status()]);
                return [];
            }

            $rates = $response->json('rates');
            if (!is_array($rates)) {
                Log::warning('FiatRateProvider: unexpected payload');
                return [];
            }

            $out = [];
            foreach ($rates as $code => $rate) {
                if (is_numeric($rate)) {
                    $out[strtoupper($code)] = (float) $rate;
                }
            }

            return $out;
        } catch (\Throwable $e) {
            Log::error('FiatRateProvider failed: ' . $e->getMessage());
            return [];
        }
    }
}
