<?php

namespace Tests\Unit;

use App\Models\ExchangeRate;
use App\Services\CurrencyConverter;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CurrencyConverterTest extends TestCase
{
    use DatabaseTransactions;

    protected function seedRates(): void
    {
        ExchangeRate::whereIn('code', ['USD', 'ARS', 'EUR'])->delete();
        ExchangeRate::insert([
            ['code' => 'USD', 'rate' => 1,    'source' => 'fiat', 'fetched_at' => now()],
            ['code' => 'ARS', 'rate' => 1000, 'source' => 'fiat', 'fetched_at' => now()],
            ['code' => 'EUR', 'rate' => 0.9,  'source' => 'fiat', 'fetched_at' => now()],
        ]);
        CurrencyConverter::flushCache();
    }

    public function test_converts_between_currencies_via_usd_base(): void
    {
        $this->seedRates();
        $c = new CurrencyConverter();

        // 1000 ARS = 1 USD = 0.9 EUR
        $this->assertEqualsWithDelta(0.9, $c->convert(1000, 'ARS', 'EUR'), 0.0001);
        // 1 USD = 1000 ARS
        $this->assertEqualsWithDelta(1000, $c->convert(1, 'USD', 'ARS'), 0.0001);
        // same currency is identity
        $this->assertEquals(50.0, $c->convert(50, 'USD', 'USD'));
    }

    public function test_eu_alias_maps_to_eur(): void
    {
        $this->seedRates();
        $c = new CurrencyConverter();

        // The Euro row is seeded with code "EU"; it must resolve to the "EUR" rate.
        $this->assertEqualsWithDelta(0.9, $c->convert(1, 'USD', 'EU'), 0.0001);
    }

    public function test_missing_rate_returns_null(): void
    {
        $this->seedRates();
        $c = new CurrencyConverter();

        $this->assertNull($c->convert(1, 'USD', 'ZZZ'));
        $this->assertFalse($c->hasRate('ZZZ'));
        $this->assertTrue($c->hasRate('ARS'));
    }
}
