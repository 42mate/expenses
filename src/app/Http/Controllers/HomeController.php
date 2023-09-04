<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Income;
use App\Models\IncomeSource;
use App\Models\RecurrentExpense;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function public_home()
    {
        if (! empty(Auth::user())) {
            return redirect('/dashboard');
        }

        return view('pages.public.home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        if (Auth::user()->isANewUser()) {
            $status = [
                'category' => Category::isEmpty(),
                'source' => IncomeSource::isEmpty(),
                'wallet' => Wallet::isEmpty(),
                'expense' => Expense::isEmpty(),
                'income' => Income::isEmpty(),
            ];
            return view('welcome', ['status' => $status]);
        }

        return view('home');
    }

    public function pending()
    {
        $recurrentExpensePendingPayment = RecurrentExpense::getPendingToPayThisMonth(Auth::id());
        $recurrentExpensesPaused = RecurrentExpense::getPendingPausedToPayThisMonth(Auth::id());

        return view('pages/expense/pending', [
            'recurrent_expense_pending_payment' => $recurrentExpensePendingPayment,
            'recurrent_expenses_paused' => $recurrentExpensesPaused,
        ]);
    }
}
