<?php

namespace App\View\Components;

use App\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class CategoriesDropDown extends Component
{

    public $selected;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $selected)
    {
        $this->name = $name;
        $this->selected = $selected;
        $this->categories = Category::where('user_id', Auth::id())->get();
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
            ]
        );
    }
}
