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
            'name' => 'Argentine peso',
            'code' => 'ARS',
            'symbol' => '$'
        ]);

        Currency::create([
            'name' => 'United States dollar',
            'code' => 'USD',
            'symbol' => '$'
        ]);

        Currency::create([
            'name' => 'Euro',
            'code' => 'EU',
            'symbol' => '€'
        ]);

        Currency::create([
            'name' => 'YEN',
            'code' => 'JPY',
            'symbol' => '¥'
        ]);

        Currency::create([
            'name' => 'Brazilian real',
            'code' => 'BRL',
            'symbol' => 'R$'
        ]);

        Currency::create([
            'name' => 'Brazilian real',
            'code' => 'BRL',
            'symbol' => 'R$'
        ]);

        Currency::create([
            'name' => 'Paraguayan guaraní',
            'code' => 'PYG',
            'symbol' => '₲'
        ]);

        Currency::create([
            'name' => 'Renminbi',
            'code' => 'CNY',
            'symbol' => '¥'
        ]);

        Currency::create([
            'name' => 'Renminbi',
            'code' => 'CNY',
            'symbol' => '¥'
        ]);

        Currency::create([
            'name' => 'Uruguayan peso',
            'code' => 'UYU',
            'symbol' => '$'
        ]);

        Currency::create([
            'name' => 'Bitcoin',
            'code' => 'XBT',
            'symbol' => '$'
        ]);

        Currency::create([
            'name' => 'Ethereum',
            'code' => 'ETH',
            'symbol' => '$'
        ]);

        Currency::create([
            'name' => 'DAI',
            'code' => 'DAI',
            'symbol' => '$'
        ]);


        Currency::create([
            'name' => 'USDT',
            'code' => 'USDT',
            'symbol' => '$'
        ]);

        Currency::create([
            'name' => 'USDC',
            'code' => 'USDC',
            'symbol' => '$'
        ]);
    }
}


