<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function create()
    {
        return view('pages.wallet.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
        ]);

        Wallet::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
            'balance' => $request->balance,
        ]);

        return back()->with('success', 'Wallet created!');
    }

    public function edit(Wallet $wallet)
    {
        return view('pages.wallet.form', [
            'model' => $wallet,
        ]);
    }

    public function update(Request $request, Wallet $wallet)
    {
        $request->validate([
            'name' => 'required|max:100',
        ]);

        $wallet->fill([
            'name' => $request->name,
            'balance' => $request->balance,
        ]);

        $wallet->save();

        return redirect('/wallet')->with('success', 'Wallet updated!');
    }

    public function delete(Wallet $wallet)
    {
        if ($wallet->expenses()->count() > 0) {
            return redirect('/wallet')
                ->with('warning',
                    'This wallet has related expenses, it can\'t be deleted!');
        }

        $wallet->delete();

        return redirect('/wallet')->with('success', 'Wallet Deleted!');
    }

    public function index()
    {
        $wallets = Auth::user()->wallets()->orderBy('name')->get();

        return view('pages.wallet.index', [
            'wallets' => $wallets,
        ]);
    }
}
