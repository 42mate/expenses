<?php

namespace App\Http\Controllers;

use App\Models\RecurrentExpense;
use App\Support\AmountNormalizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecurrentExpenseController extends Controller
{
    public function index(Request $request)
    {
        $recurrent_expense = RecurrentExpense::where('user_id', Auth::id());

        return view('pages.recurrent_expense.index', [
            'recurrent_expenses' => $recurrent_expense->paginate(50),
        ]);
    }

    public function create(Request $request)
    {
        return view('pages.recurrent_expense.form');
    }

    public function store(Request $request)
    {
        $request->merge(['amount' => AmountNormalizer::normalize($request->input('amount'))]);

        $request->validate([
            'amount' => 'required|numeric',
            'category_id' => 'required|numeric',
            'description' => 'required',
            'period' => 'required|numeric',
            'currency_id' => 'nullable|exists:currencies,id',
        ]);

        $redirect = redirect('/recurrent_expense/create');

        RecurrentExpense::create([
            'amount' => $request->amount,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'period' => $request->period,
            'last_use_date' => $request->get('last_use_date', null),
            'paused' => $request->boolean('paused', false),
            'currency_id' => $request->get('currency_id') ?: Auth::user()->default_currency_id,
        ]);

        return $redirect->with('success', 'Expense Created!');
    }

    public function edit(RecurrentExpense $recurrentexpense)
    {
        return view('pages.recurrent_expense.form', [
            'model' => $recurrentexpense,
        ]);
    }

    public function update(Request $request, RecurrentExpense $recurrentexpense)
    {
        $request->merge(['amount' => AmountNormalizer::normalize($request->input('amount'))]);

        $request->validate([
            'amount' => 'required|regex:/^\d*(\.\d{2})?$/',
            'category_id' => 'required|numeric',
            'description' => 'required',
            'period' => 'required|numeric',
            'currency_id' => 'nullable|exists:currencies,id',
        ]);

        $recurrentexpense->fill([
            'amount' => $request->amount,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'period' => $request->period,
            'last_use_date' => $request->get('last_use_date', $recurrentexpense->last_use_date),
            'paused' => $request->has('paused'),
            'currency_id' => $request->get('currency_id') ?: $recurrentexpense->currency_id,
        ]);

        $recurrentexpense->save();

        return redirect(route('recurrent_expense.edit', ['recurrentexpense' => $recurrentexpense->id]))
            ->with('success', 'Recurrent Expense Updated!');
    }

    public function delete(RecurrentExpense $recurrentexpense)
    {
        $recurrentexpense->delete();

        return redirect(route('recurrent_expense.index'))
            ->with('success', 'Expense deleted!');
    }

    public function stateToggle(RecurrentExpense $recurrentexpense) {
        $recurrentexpense->paused = !$recurrentexpense->paused;
        $recurrentexpense->save();
        return back()->with('success', 'Recurrent Expense Updated!');
    }
}
