<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Orion\Http\Requests\Request;

class CategoryRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function storeRules(): array
    {
        return [
            'category' => 'required|string|unique:categories,category,user_id'.Auth::user()->id.'|max:255',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function updateRules(): array
    {
        return [
            'category' => 'required|string|unique:categories,category,user_id'.Auth::user()->id.'|max:255',
        ];
    }
}
