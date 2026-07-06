<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Services\CurrencyConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsData extends Controller
{
    /**
     * Returns the total by month of the expenses, converted into the user's
     * display currency as a single unified dataset. The format is for Chart Js.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function expenseTotalByMonth()
    {
        $data = Expense::getTotalByMonth();
        $converter = app(CurrencyConverter::class);
        $display = $converter->displayCurrency();

        // Accumulate every native per-currency row into one total per month.
        $months = [];
        foreach ($data as $d) {
            if (!isset($months[$d->month])) {
                $months[$d->month] = 0;
            }
            $converted = $converter->toDisplay((float) $d->total, $d->code);
            if ($converted !== null) {
                $months[$d->month] += $converted;
            }
        }

        $dataset = new class{};
        $dataset->label = $display->code;
        $dataset->data = array_values($months);

        $chartData = new class{};
        $chartData->datasets = [$dataset];
        $chartData->labels = array_keys($months);

        return response()->json([
            'data' => $chartData,
        ]);
    }


    /**
     * Returns data for the chart of expenses by category
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function expenseByCategory()
    {
        $models = Expense::getExpensesByCategory();
        $converter = app(CurrencyConverter::class);

        // Convert each native row into the display currency and aggregate by category.
        $byCategory = [];
        foreach ($models as $model) {
            $converted = $converter->toDisplay((float) $model->total, $model->code);
            if ($converted === null) {
                continue;
            }
            $byCategory[$model->category] = ($byCategory[$model->category] ?? 0) + $converted;
        }

        arsort($byCategory);

        $dataset = new \stdClass();
        $dataset->label = 'Total by category';
        $dataset->data = array_values($byCategory);

        $return = new \stdClass();
        $return->labels = array_keys($byCategory);
        $return->datasets = [$dataset];

        return response()->json([
            'data' => $return,
        ]);
    }
}
