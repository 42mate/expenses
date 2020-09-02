<?php

namespace App\Http\Controllers;

use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function create() {
        return view('pages.wallet.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name'=> 'required|max:100',
        ]);

        Wallet::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);

        return redirect('/create')->with('success', 'Category created!');
    }
}
