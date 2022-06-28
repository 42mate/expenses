<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\Support\Str;


class WalletDropDown extends BaseDropDown
{
    protected function getOptions(): \Illuminate\Database\Eloquent\Collection|array {
        return Auth::user()->wallets()->orderBy('name')->get();
    }
}
