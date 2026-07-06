<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Income;
use App\Models\IncomeSource;
use App\Models\RecurrentExpense;
use App\Models\Wallet;
use App\Services\CurrencyConverter;
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
        if (Auth::user()->isANewUser() && ! session('onboarding_skipped')) {
            $status = [
                'category' => Category::isEmpty(),
                'source' => IncomeSource::isEmpty(),
                'wallet' => Wallet::isEmpty(),
                'expense' => Expense::isEmpty(),
                'income' => Income::isEmpty(),
            ];
            return view('welcome', ['status' => $status]);
        }

        $converter = app(CurrencyConverter::class);

        // Current-month expenses grouped by category, converted to the display
        // currency, sorted from largest to smallest — for the dashboard chart.
        $byCategory = [];
        foreach (Expense::getExpensesByCategory() as $row) {
            $converted = $converter->toDisplay((float) $row->total, $row->code);
            if ($converted === null) {
                continue;
            }
            $byCategory[$row->category] = ($byCategory[$row->category] ?? 0) + $converted;
        }
        arsort($byCategory);

        return view('home', [
            'expenseCategories' => array_keys($byCategory),
            'expenseCategoryTotals' => array_values($byCategory),
        ]);
    }

    /**
     * Skip the onboarding checklist and go straight to the dashboard.
     */
    public function skipOnboarding()
    {
        session(['onboarding_skipped' => true]);

        return redirect()->route('home');
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
