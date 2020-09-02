<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\Support\Str;


class WalletDropDown extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $selected = 0, $id = '', $addEmpty = false, $useAsValue = 'id')
    {
        $this->name = $name;
        $this->selected = $selected;
        $this->id = empty($id) ? 'rid_' . Str::random(10) : $id;
        $this->addEmpty = $addEmpty;
        $this->use_as_value = $useAsValue;
        $this->wallets = Auth::user()->wallets()->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.wallet-drop-down',
            [
                'selected' => $this->selected,
                'wallets' => $this->wallets,
                'name' => $this->name,
                'add_empty'     => $this->addEmpty,
                'id' => $this->id,
                'use_as_value' => $this->use_as_value,
            ]
        );
    }
}
