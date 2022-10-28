<?php

namespace App\Http\Controllers;

use App\Exports\ExpenseExport;
use App\Models\Income;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $incomes = Income::filter($request->all());

        if ($request->get('action') == 'xls') {
            return $this->export($incomes->get());
        }

        $total = $incomes->sum('amount');

        return view('pages.incomes.index', [
            'incomes' => $incomes->paginate(50),
            'total' => $total,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Income();

        return view('pages.incomes.form', [
            'model' => $model,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $income = Income::create([
                'amount' => $request->amount,
                'date' => $request->date,
                'description' => ! empty($request->description) ? $request->description : '',
                'user_id' => Auth::id(),
                'income_source_id' => ! empty($request->income_source_id) ? $request->income_source_id : null,
                'wallet_id' => $request->wallet_id,
            ]);

            //Updates balance in blance.
            if (!empty($income->wallet)) {
                $income->wallet->newOperation($request->amount);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect(route('incomes.create'))->with('error', __('Error Saving!'));
        }

        return redirect(route('incomes.create'))->with('success', __('Income Created!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Income $income)
    {
        return view('pages.incomes.form', [
            'model' => $income,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        $request->validate([
            'amount' => 'required|regex:/^\d*(\.\d{2})?$/',
        ]);

        try {
            DB::beginTransaction();
            
            //Updates balance in blance.
            if (!empty($income->wallet)) {
                $income->wallet->updateOperation($income->amount, -($request->amount));
            }

            $income->fill([
                'amount' => $request->amount,
                'date' => $request->date,
                'description' => ! empty($request->description) ? $request->description : '',
                'income_source_id' => ! empty($request->income_source_id) ? $request->income_source_id : null,
                'wallet_id' => ! empty($request->wallet_id) ? $request->wallet_id : null,
            ]);

            $income->save();
            DB::commit();

            return redirect(route('incomes.index'))
                ->with('success', __('Income Updated!'));
        } catch (\Matrix\Exception $e) {
            DB::rollBack();

            return redirect(route('incomes.edit', ['id' => $income->id]))
                ->with('error', __('Error Saving!'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Income $income)
    {
        $income->delete();

        return redirect(route('incomes.index'))->with('success', __('Income deleted!'));
    }

    public function export(Collection $data)
    {
        $date = Carbon::now();
        $name = 'incomes-'.$date.'.xlsx';

        return Excel::download(new ExpenseExport($data), $name);
    }
}
