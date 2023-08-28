<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPostRequest;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit()
    {
        return view('pages.user.form', [
            'model' => Auth::user(),
        ]);
    }

    public function update(UserPostRequest $request)
    {
        $user = Auth::user();

        $user->fill([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'default_currency_id' => $request->input('default_currency_id'),
        ]);

        if (!empty($request->input('password', null))) {
            $this->validate($request, [
                'password' => 'required|confirmed|min:6',
            ]);

            $user->password = Hash::make($request->input('password'));
        }

        if ($user->isDirty('default_currency_id')) {
            Expense::updateCurrencyOfNoWallets($user->default_currency_id);
            Income::updateCurrencyOfNoWallets($user->default_currency_id);
        }

        $user->save();

        return redirect(route('user.edit'))
            ->with('success', 'User Updated');
    }
}
