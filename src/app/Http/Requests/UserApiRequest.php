<?php

namespace App\Http\Requests;

use Orion\Http\Requests\Request;

class UserApiRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function storeRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users,email|max:255',
            'password' => 'required|string|max:255',
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
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|unique:users,email|max:255',
            'password' => 'nullable|string|max:255',
        ];
    }
}
