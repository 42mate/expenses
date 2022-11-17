<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::create([
            'name' => 'Peso Argentino',
            'code' => 'ARS',
            'symbol' => '$'
        ]);

        Currency::create([
            'name' => 'American Dolar',
            'code' => 'USD',
            'symbol' => 'u$d'
        ]);

        Currency::create([
            'name' => 'Euro',
            'code' => 'EU',
            'symbol' => '€'
        ]);

        Currency::create([
            'name' => 'Bitcoin',
            'code' => 'BTC',
            'symbol' => 'B$C'
        ]);

        Currency::create([
            'name' => 'DAI',
            'code' => 'DAI',
            'symbol' => 'D$I'
        ]);

        Currency::create([
            'name' => 'USDT',
            'code' => 'USDT',
            'symbol' => 'U$DT'
        ]);
    }
}


