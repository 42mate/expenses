<?php

namespace Tests\Unit;

use App\Support\AmountNormalizer;
use Tests\TestCase;

class AmountNormalizerTest extends TestCase
{
    public static function amounts(): array
    {
        return [
            ['5.088,15', '5088.15'],   // AR/EU: dot thousands, comma decimal
            ['15.000,02', '15000.02'],
            ['1.234.567,89', '1234567.89'],
            ['15000,02', '15000.02'],
            ['15,000.02', '15000.02'], // US: comma thousands, dot decimal
            ['15000.02', '15000.02'],  // already canonical
            ['15.02', '15.02'],
            ['0.00000001', '0.00000001'], // high-precision crypto preserved
            ['0,00000001', '0.00000001'],
            ['0.001', '0.001'],
            ['1.000.000', '1000000'],
            ['1,000,000', '1000000'],
            ['15000', '15000'],
            ['15.', '15'],
            ['$ 5.088,15', '5088.15'],
            ['', ''],
        ];
    }

    /**
     * @dataProvider amounts
     */
    public function test_normalizes_amounts(string $input, string $expected): void
    {
        $this->assertSame($expected, AmountNormalizer::normalize($input));
    }
}
