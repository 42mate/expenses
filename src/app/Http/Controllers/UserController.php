<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit() {
        return view('pages.user.form', [
            'model' => Auth::user(),
        ]);
    }

    public function update(UserPostRequest $request) {
        $user = Auth::user();


        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        return redirect(route('user.edit'))
            ->with('success', 'User Updated');
    }
}
