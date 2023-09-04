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

        $totals = Expense::aggregateByCurrency($expenses->get());

        return view('pages.expense.index', [
            'expenses' => $expenses->paginate(50),
            'totals' => $totals,
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

                // Save the referer in the session to redirect back to it after saving the expense
                $request->session()->put('back_to', request()->headers->get('referer'));
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

            //Updates balance in balance.
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

            return redirect(route('expense.create'))->with('error', 'Error Saving!');
        }

        $back_to = $request->session()
            ->get('back_to', route('expense.index'));

        $request->session()->forget('back_to');
        return redirect($back_to)->with('success', 'Expense Created!');
    }

    public function edit(Expense $expense)
    {
        return view('pages.expense.form', [
            'model' => $expense,
            'recurrent_expenses' => RecurrentExpense::getAllNotUsedFirst(Auth::id()),
        ]);
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            //Rollbacks the previous operation from the wallet balance
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

            //Sets the movement in the balance of the wallet.
            if (! empty($expense->wallet)) {
                $expense->wallet->newOperation(-($request->amount));
            }

            $expense->save();
            DB::commit();

            return redirect(route('expense.index'))
                ->with('success', 'Expense Updated!');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect(route('expense.edit', ['id' => $expense->id]))
                ->with('error', 'Error Saving!');
        }
    }

    public function delete(Expense $expense)
    {
        $expense->delete();

        return redirect(route('expense.index'))->with('success', 'Expense deleted!');
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

    public function export(Collection $data)
    {
        $date = Carbon::now();
        $name = 'expenses-'.$date.'.xlsx';

        return Excel::download(new ExpenseExport($data), $name);
    }
}
