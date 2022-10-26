<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function monthFlow()
    {
        return view('pages.reports.month_flow');
    }

    public function expensesByCategory() {
        $expenses = Expense::byUserCurrentMonth(Auth::id());
        return view('pages.reports.expenses_by_category', ['expenses' => $expenses]);
    }
}
