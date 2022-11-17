<?php

namespace App\View\Components;

use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class WalletBalanceWidget extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->wallets = Wallet::getBalance();

        $this->totals = [];
        foreach ($this->wallets as $wallet) {
            if (empty($this->totals[$wallet->currency_id])) {
                $this->totals[$wallet->currency_id] = [
                    'currency' => $wallet->currency,
                    'sum' => 0,
                ];
            }
            $this->totals[$wallet->currency_id]['sum'] += $wallet->balance;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        return view('components.wallet-balance-widget', [
            'wallets' => $this->wallets,
            'totals' => $this->totals,
        ]);
    }
}


