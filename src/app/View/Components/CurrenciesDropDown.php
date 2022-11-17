<?php

namespace App\View\Components;

use App\Models\Currency;

class CurrenciesDropDown extends BaseDropDown
{
    public function getOptions(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Currency::orderBy('name')->get();
    }
}
