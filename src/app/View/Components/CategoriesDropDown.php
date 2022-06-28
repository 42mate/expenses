<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class CategoriesDropDown extends BaseDropDown
{
    public function getOptions(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Category::allForUser()->get();
    }
}
