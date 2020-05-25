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
        return view('pages.expense.create');
    }

    public function store(Request $request) {
        $request->validate([
            'amount'=> 'required|numeric',
            'category_id'=>'required|numeric',
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

    public function view(Expense $expense) {
        return view('pages.expense.view', [
            'expense' => $expense,
        ]);
    }
}
