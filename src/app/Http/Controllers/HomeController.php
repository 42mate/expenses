<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home() {
        $expenses = Expense::byUserCurrentMonth(Auth::id());

        $today = Expense::todayTotal(Auth::id());
        $week = Expense::weekTotal(Auth::id());
        $month = Expense::monthTotal(Auth::id());
        $lastMonth = Expense::lastMonthTotal(Auth::id());

        return view('home', [
            'expenses' => $expenses,
            'today' => $today,
            'week' => $week,
            'month' => $month,
            'last_month' => $lastMonth,
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
        $dataset->backgroundColor = [];

        foreach ($models as $model) {
            $return->labels[] = $model->category;
            $dataset->data[] = $model->total;
            $dataset->backgroundColor[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }

        $return->datasets[] = $dataset;

        return response()->json([
            'data' => $return
        ]);

    }
}
