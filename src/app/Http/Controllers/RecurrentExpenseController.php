<?php

namespace App\Http\Controllers;

use App\Models\RecurrentExpense;
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
        $request->validate([
            'amount' => 'required|numeric',
            'category_id' => 'required|numeric',
            'description' => 'required',
            'period' => 'required|numeric',
        ]);

        $redirect = redirect('/recurrent_expense/create');

        RecurrentExpense::create([
            'amount' => $request->amount,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'period' => $request->period,
            'last_use_date' => $request->get('last_use_date', null),
        ]);

        return $redirect->with('success', 'Expense Created!');
    }

    public function edit(RecurrentExpense $recurrent_expense)
    {
        return view('pages.recurrent_expense.form', [
            'model' => $recurrent_expense,
        ]);
    }

    public function update(Request $request, RecurrentExpense $recurrent_expense)
    {
        $request->validate([
            'amount' => 'required|regex:/^\d*(\.\d{2})?$/',
            'category_id' => 'required|numeric',
            'description' => 'required',
            'period' => 'required|numeric',
        ]);

        $recurrent_expense->fill([
            'amount' => $request->amount,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'period' => $request->period,
            'last_use_date' => $request->get('last_use_date', $recurrent_expense->last_use_date),
        ]);

        $recurrent_expense->save();

        return redirect(route('recurrent_expense.edit', ['recurrent_expense' => $recurrent_expense->id]))
            ->with('success', 'Recurrent Expense Updated!');
    }

    public function delete(RecurrentExpense $recurrent_expense)
    {
        $recurrent_expense->delete();

        return redirect(route('recurrent_expense.index'))
            ->with('success', 'Expense deleted!');
    }

    public function stateToggle(RecurrentExpense $recurrent_expense) {
        $recurrent_expense->paused = !$recurrent_expense->paused;
        $recurrent_expense->save();
        return back()->with('success', 'Recurrent Expense Updated!');
    }
}
