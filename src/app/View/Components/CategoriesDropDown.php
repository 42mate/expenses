<?php

namespace App\View\Components;

use App\Models\Category;

class CategoriesDropDown extends BaseDropDown
{
    public function getOptions(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Category::allForUser()->get();
    }
}
