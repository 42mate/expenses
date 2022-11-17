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
            'currency_id' => 'required',
            'name' => 'required|max:100',
        ]);

        Wallet::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
            'currency_id' => $request->currency_id,
            'balance' => $request->balance ?? 0,
        ]);

        return redirect(route('wallet.index'))->with('success', 'Wallet created!');
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
            'currency_id' => 'required',
            'name' => 'required|max:100',
            'balance' => 'required'
        ]);

        $wallet->fill([
            'name' => $request->name,
            'balance' => $request->balance,
            'currency_id' => $request->currency_id,
        ]);

        $wallet->save();

        return redirect(route('wallet.index'))->with('success', 'Wallet updated!');
    }

    public function delete(Wallet $wallet)
    {
        if ($wallet->expenses()->count() > 0) {
            return redirect('/wallet')
                ->with('warning',
                    'This wallet has related expenses, it can\'t be deleted!');
        }

        $wallet->delete();

        return redirect(route('wallet.index'))->with('success', 'Wallet Deleted!');
    }

    public function index()
    {
        $wallets = Auth::user()->wallets()->orderBy('name')->get();

        return view('pages.wallet.index', [
            'wallets' => $wallets,
        ]);
    }
}
