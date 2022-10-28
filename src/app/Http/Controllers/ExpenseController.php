<?php

namespace App\Http\Controllers;

use App\Exports\ExpenseExport;
use App\Models\Expense;
use App\Models\RecurrentExpense;
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
    public function index(Request $request)
    {
        $expenses = Expense::filter($request->all());

        if ($request->get('action') == 'xls') {
            return $this->export($expenses->get());
        }

        $total = $expenses->sum('amount');

        return view('pages.expense.index', [
            'expenses' => $expenses->paginate(50),
            'total' => $total,
        ]);
    }

    public function create(Request $request)
    {
        $expense = new Expense();
        if ($request->get('recurrent_expense', 0) > 0) {
            $recurrent_expense = RecurrentExpense::find($request->get('recurrent_expense'));
            if ($recurrent_expense) {
                $expense->amount = $recurrent_expense->amount;
                $expense->description = $recurrent_expense->description;
                $expense->category_id = $recurrent_expense->category_id;
                $expense->recurrent_expense_id = $recurrent_expense->id;
            }
        }

        $requested_tags = $request->old('tags', null);

        return view('pages.expense.form', [
            'request_tags' => $requested_tags,
            'recurrent_expenses' => RecurrentExpense::getAllNotUsedFirst(Auth::id()),
            'model' => $expense,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $expense = Expense::create([
                'amount' => $request->amount,
                'date' => $request->date,
                'description' => ! empty($request->description) ? $request->description : '',
                'user_id' => Auth::id(),
                'category_id' => ! empty($request->category_id) ? $request->category_id : null,
                'wallet_id' => $request->wallet_id,
            ]);

            //Updates balance in blance.
            if (! empty($expense->wallet)) {
                $expense->wallet->newOperation(-($request->amount));
            }

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
        } catch (Exception $e) {
            DB::rollBack();

            return redirect('/create')->with('error', 'Error Saving!');
        }

        return redirect('/create')->with('success', 'Expense Created!');
    }

    public function edit(Expense $expense)
    {
        return view('pages.expense.form', [
            'model' => $expense,
            'recurrent_expenses' => RecurrentExpense::getAllNotUsedFirst(Auth::id()),
        ]);
    }

    public function delete(Expense $expense)
    {
        $expense->delete();

        return redirect(route('expense.index'))->with('success', 'Expense deleted!');
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'amount' => 'required|regex:/^\d*(\.\d{2})?$/',
        ]);

        try {
            DB::beginTransaction();

            //Updates balance in blance.
            if (! empty($expense->wallet)) {
                $expense->wallet->updateOperation($expense->amount, -($request->amount));
            }

            $expense->fill([
                'amount' => $request->amount,
                'date' => $request->date,
                'description' => ! empty($request->description) ? $request->description : '',
                'category_id' => ! empty($request->category_id) ? $request->category_id : null,
                'wallet_id' => ! empty($request->wallet_id) ? $request->wallet_id : null,
            ]);

            $expense->save();
            DB::commit();

            return redirect(route('expense.index'))
                ->with('success', 'Expense Updated!');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect('/expense/'.$expense->id.'/edit')
                ->with('error', 'Error Saving!');
        }
    }

    public function view(Expense $expense)
    {
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
    public function apiGetTotalByMonth()
    {
        $data = Expense::getTotalByMonth();

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
            'data' => $return,
        ]);
    }

    public function apiGetExpenseTable(Request $request)
    {
        if ($request->get('month', null) === null) {
            $expenses = Expense::byUser(Auth::id());
        } else {
            $expenses = Expense::byUserCurrentMonth(Auth::id());
        }

        return DataTables::collection($expenses)
            ->toJson();
    }

    public function export(Collection $data)
    {
        $date = Carbon::now();
        $name = 'expenses-'.$date.'.xlsx';

        return Excel::download(new ExpenseExport($data), $name);
    }
}
