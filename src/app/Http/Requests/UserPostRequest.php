<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserPostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $email_rule = 'required|email|unique:users,email';

        if (Auth::user()) {
            $email_rule = $email_rule . ',' . Auth::user()->id;
        }

        return [
            'email' => $email_rule,
            'name' => 'required',
            'default_currency_id' => 'required|exists:currencies,id',
        ];
    }
}
