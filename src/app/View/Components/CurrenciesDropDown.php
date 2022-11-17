<?php

namespace App\View\Components;

use App\Models\Currency;

class CurrenciesDropDown extends BaseDropDown
{
    public function __construct($name,
                                $selected = 0,
                                $id = '',
                                $useAsValue = 'id',
                                $useAsLabel = 'name',
                                $addEmpty = false,
                                $addDefault = false,
                                $onlyInUse = 'no')
    {
        $this->only_in_use = strtolower($onlyInUse);
        parent::__construct($name, $selected, $id, $useAsValue, $useAsLabel, $addEmpty, $addDefault);
    }

    public function getOptions(): \Illuminate\Database\Eloquent\Collection|array
    {
        if ($this->only_in_use === 'yes') {
            return Currency::onlyInUse();
        }
        return Currency::orderBy('name')->get();
    }
}
