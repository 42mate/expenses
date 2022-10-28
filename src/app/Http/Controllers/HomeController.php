<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
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
        $expenses = Expense::getTotals(Auth::id());
        $incomes = Income::getTotals(Auth::id());
        $balances = Wallet::getBalance(Auth::id());

        return view('home', [
            'expenses' => $expenses,
            'incomes' => $incomes,
            'balances' => $balances,
        ]);
    }

    public function pending()
    {
        $recurrentExpensePendingPayment = RecurrentExpense::getPendingToPayThisMonth(Auth::id());

        return view('pages/expense/pending', [
            'recurrent_expense_pending_payment' => $recurrentExpensePendingPayment,
        ]);
    }

    /**
     * Returns data for the chart of expenses by category
     */
    public function getChartByCategory()
    {
        $models = Expense::getExpensesByCategory();

        $return = new \stdClass();

        $return->labels = [];
        $return->datasets = [];

        $dataset = new \stdClass();
        $dataset->label = 'Total by category';
        $dataset->data = [];

        foreach ($models as $model) {
            $return->labels[] = $model->category;
            $dataset->data[] = $model->total;
        }

        $return->datasets[] = $dataset;

        return response()->json([
            'data' => $return,
        ]);
    }
}
