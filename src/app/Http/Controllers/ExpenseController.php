<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Exports\ExpenseExport;
use App\RecurrentExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Matrix\Exception;
use Yajra\DataTables\Facades\DataTables;

class ExpenseController extends Controller
{
    public function index(Request $request) {
        $expenses = Expense::filter(Auth::id(), $request->all());

        if ($request->get('action') == 'xls') {
            return $this->export($expenses->get());
        }

        $total = $expenses->sum('amount');

        return view('pages.expense.index', [
            'expenses' => $expenses->paginate(50),
            'total' => $total,
        ]);
    }

    public function create(Request $request) {
        $requested_tags = $request->old('tags', null);

        return view('pages.expense.form', [
            'request_tags' => $requested_tags,
            'recurrent_expenses' => RecurrentExpense::getAllNotUsedFirst(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'amount'=> 'required|numeric',
            'category_id'=>'required|numeric',
            'description' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $expense = Expense::create([
                'amount' => $request->amount,
                'date' => ($request->date),
                'description' => $request->description,
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'wallet_id' => $request->wallet_id,
            ]);

            $expense->updateTags(Auth::id(), $request->tags);
            DB::commit();

            //If there is a recurrent expense realted will update the recurrent expense amount and will set the last used date
            if ($request->get('recurrent_expense_id', 0) > 0) {
                $recurrentExpense = RecurrentExpense::find($request->get('recurrent_expense_id'));
                if ($recurrentExpense) {
                    $recurrentExpense->fill([
                        'amount' => $request->amount,
                        'last_use_date' => $request->date,
                    ])->save();
                }
            }

        } catch(Exception $e) {
            DB::rollBack();
            return redirect('/create')->with('error', 'Error Saving!');
        }

        return redirect('/create')->with('success', 'Expense Created!');
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



        try {
            DB::beginTransaction();
            $expense->fill([
                'amount' => $request->amount,
                'date' => ($request->date),
                'description' => $request->description,
                'category_id' => $request->category_id,
            ]);

            $expense->updateTags(Auth::id(), $request->tags);
            $expense->save();
            DB::commit();
            return redirect(route('expense.view', ['expense' => $expense->id]))
                ->with('success', 'Expense Updated!');

        } catch(Exception $e) {
            DB::rollBack();
            return redirect('/expense/' . $expense->id . '/edit')
                ->with('error', 'Error Saving!');
        }
    }

    public function view(Expense $expense) {
        if ($expense->user_id !== Auth::id()) {
            return redirect(route('home'))
                ->with('warning', 'Not allowed!');
        }

        return view('pages.expense.view', [
            'expense' => $expense,
        ]);
    }

    /**
     * Returns the total by month of the expenses.
     *
     * @return array
     */
    public function apiGetTotalByMonth() {
        $data = Expense::getTotalByMonth(Auth::id());

        $return = new \stdClass();

        $return->labels = [];
        $return->datasets = [];

        $dataset = new \stdClass();
        $dataset->label = 'Total by month';
        $dataset->data = [];
        $dataset->borderColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));

        foreach ($data as $model) {
            $return->labels[] = $model->month;
            $dataset->data[] = $model->total;
        }

        $return->datasets[] = $dataset;

        return response()->json([
            'data' => $return
        ]);
    }

    public function apiGetExpenseTable(Request $request) {
        if ($request->get('month', null) === null) {
            $expenses = Expense::byUser(Auth::id());
        }
        else {
            $expenses = Expense::byUserCurrentMonth(Auth::id());
        }

        return DataTables::collection($expenses)
            ->toJson();
    }

    public function export(Collection $data)
    {
        $date = Carbon::now();
        $name = 'expenses-' . $date . '.xlsx';
        return Excel::download(new ExpenseExport($data), $name);
    }

}


