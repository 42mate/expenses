<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index() {
        $expenses = Expense::byUser(Auth::id());
        return view('pages.expense.index', [
            'expenses' => $expenses,
        ]);
    }

    public function create() {
        return view('pages.expense.form');
    }

    public function store(Request $request) {
        $request->validate([
            'amount'=> 'required|numeric',
            'category_id'=>'required|numeric',
            'description' => 'required',
        ]);

        Expense::create([
            'amount' => $request->amount,
            'date' => ($request->date),
            'description' => $request->description,
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
        ]);

        return redirect('/')->with('success', 'Expense saved!');
    }

    public function edit(Expense $expense) {
        return view('pages.expense.form', [
            'model' => $expense,
        ]);
    }

    public function update(Request $request, Expense $expense) {
        $request->validate([
            'amount'=> 'required|regex:/^\d*(\.\d{2})?$/',
            'category_id'=>'required|numeric',
            'description' => 'required',
        ]);

        $expense->fill([
            'amount' => $request->amount,
            'date' => ($request->date),
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);

        $expense->save();

        return redirect(route('expense.view', ['expense' => $expense->id]))
            ->with('success', 'Expense Updated!');

    }

    public function view(Expense $expense) {
        return view('pages.expense.view', [
            'expense' => $expense,
        ]);
    }
}
