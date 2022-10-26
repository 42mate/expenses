<?php

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

abstract class BaseDropDown extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $name,
        $selected = 0,
        $id = '',
        $useAsValue = 'id',
        $useAsLabel = 'name',
        $addEmpty = false,
        $addDefault = false
    ) {
        $this->name = $name;
        $this->selected = $selected;
        $this->id = empty($id) ? 'rid_'.Str::random(10) : $id;
        $this->addEmpty = $addEmpty;
        $this->addDefault = $addDefault;
        $this->use_as_value = $useAsValue;
        $this->use_as_label = $useAsLabel;
        $this->options = $this->getOptions();
    }

    abstract protected function getOptions(): \Illuminate\Database\Eloquent\Collection|array;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.drop-down',
            [
                'selected' => $this->selected,
                'options' => $this->options,
                'name' => $this->name,
                'add_empty' => $this->addEmpty,
                'add_default' => $this->addDefault,
                'id' => $this->id,
                'use_as_value' => $this->use_as_value,
                'use_as_label' => $this->use_as_label,
            ]
        );
    }
}
