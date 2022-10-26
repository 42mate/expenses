<?php

namespace App\View\Components;

use App\Models\IncomeSource;

class IncomeSourceDropDown extends BaseDropDown
{
    public function getOptions(): \Illuminate\Database\Eloquent\Collection|array
    {
        return IncomeSource::allForUser()->get();
    }
}
