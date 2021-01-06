<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class CategoriesDropDown extends Component
{

    public $selected;
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

        $this->categories = Category::allForUser()->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.categories-drop-down',
            [
                'selected' => $this->selected,
                'categories' => $this->categories,
                'name' => $this->name,
                'add_empty'     => $this->addEmpty,
                'id' => $this->id,
                'use_as_value' => $this->use_as_value,
            ]
        );
    }
}
