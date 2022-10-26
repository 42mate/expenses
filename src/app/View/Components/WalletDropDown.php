<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;

class WalletDropDown extends BaseDropDown
{
    protected function getOptions(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Auth::user()->wallets()->orderBy('name')->get();
    }
}
