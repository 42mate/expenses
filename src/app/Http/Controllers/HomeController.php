<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\RecurrentExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function public_home() {
        if (!empty(Auth::user())) {
            return redirect('/dashboard');
        }
        return view('pages.public.home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard() {
        $expenses = Expense::byUserCurrentMonth(Auth::id());

        $today = Expense::todayTotal(Auth::id());
        $week = Expense::weekTotal(Auth::id());
        $month = Expense::monthTotal(Auth::id());
        $lastMonth = Expense::lastMonthTotal(Auth::id());
        $recurrentExpensePendingPayment = RecurrentExpense::getPendingToPayThisMonth();

        return view('home', [
            'expenses' => $expenses,
            'today' => $today,
            'week' => $week,
            'month' => $month,
            'last_month' => $lastMonth,
            'recurrent_expense_pending_payment' => $recurrentExpensePendingPayment,
        ]);
    }

    /**
     * Returns data for the chart of expenses by category
     */
    public function getChartByCategory() {
        $models = Expense::getExpensesByCategory(Auth::id());

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
            'data' => $return
        ]);

    }
}
