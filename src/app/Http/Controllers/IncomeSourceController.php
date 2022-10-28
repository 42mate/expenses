<?php

namespace App\Http\Controllers;

use App\Models\IncomeSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeSourceController extends Controller
{
    public function index()
    {
        $income_sources = IncomeSource::allForUser();

        return view('pages.income_source.index', [
            'income_sources' => $income_sources->get(),
        ]);
    }

    public function create()
    {
        return view('pages.income_source.form');
    }

    public function edit(IncomeSource $income_source)
    {
        return view('pages.income_source.form', [
            'model' => $income_source,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'source' => 'required|max:100',
        ]);

        IncomeSource::create([
            'source' => $request->source,
            'user_id' => Auth::id(),
        ]);

        return redirect('/income_source')->with('success', 'Income Source created!');
    }

    public function update(Request $request, IncomeSource $income_source)
    {
        $request->validate([
            'source' => 'required|max:100',
        ]);

        $income_source->fill([
            'source' => $request->source,
        ]);

        $income_source->save();

        return redirect('/income_source')->with('success', 'Income Source Updated!');
    }

    public function destroy(IncomeSource $income_source)
    {
        if ($income_source->income()->count() > 0) {
            return redirect('/income_source')
                ->with('warning', 'This income source has related expenses, it can\'t be deleted!');
        }

        $income_source->delete();

        return redirect('/income_source')->with('success', 'Income source Deleted!');
    }
}
