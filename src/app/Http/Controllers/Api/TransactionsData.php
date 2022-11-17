<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsData extends Controller
{
    /**
     * Returns the total by month of the expenses.
     * The return format is for Chart Js.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function expenseTotalByMonth()
    {
        $data = Expense::getTotalByMonth();
        $chartData = new class{};
        $chartData->datasets = [];
        $chartData->labels = [];
        $months = [];
        $currencies = [];

        //We need to extract the currencies and the months in this period.
        foreach ($data as $d) {
            if (empty($chartData->datasets[$d->code])) {
                $dataset = new class{};
                $dataset->label = $d->code;
                $dataset->data = [];
                $chartData->datasets[$d->code] = $dataset;
                $chartData->labels[] = $d->code;
                $currencies[] = $d->code;
            }

            if (empty($months[$d->month])) {
                $months[$d->month] = $d->month;
            }
        }

        //We have to initialize all datasets on all months, all datasets needs
        //to have the same number of entries and these needs to be same as the
        //number of labels.
        foreach ($months as $month) {
            foreach ($currencies as $currency) {
                $chartData->datasets[$currency]->data[$month] = 0;
            }
        }

        //We will set the amounts from the query.
        foreach ($data as $model) {
            $chartData->datasets[$model->code]->data[$model->month] = $model->total;
        }

        //On all datasets, we need to remove the string keys in order to export the dataset
        //as an array, otherwise it will be converted as an object.
        foreach ($chartData->datasets as $key => $data) {
            $chartData->datasets[$key]->data = array_values($chartData->datasets[$key]->data);
        }

        $chartData->datasets = array_values($chartData->datasets);
        $chartData->labels = array_values($months);

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
        $models = Expense::getExpensesByCategory(request()->get('currency_id'));

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
