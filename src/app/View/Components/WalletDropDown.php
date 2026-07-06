<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;

class WalletDropDown extends BaseDropDown
{
    protected $currency_id;

    public function __construct(
        $name,
        $selected = 0,
        $id = '',
        $useAsValue = 'id',
        $useAsLabel = 'name',
        $addEmpty = false,
        $addDefault = false,
        $currencyId = null
    ) {
        // When set, restrict the wallet options to a single currency (e.g. when
        // paying a recurrent expense, only wallets of its currency are allowed).
        $this->currency_id = !empty($currencyId) ? $currencyId : null;
        parent::__construct($name, $selected, $id, $useAsValue, $useAsLabel, $addEmpty, $addDefault);
    }

    protected function getOptions(): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Auth::user()->wallets()->orderBy('name');

        if (!empty($this->currency_id)) {
            $query->where('currency_id', $this->currency_id);
        }

        return $query->get();
    }
}
