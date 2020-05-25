<?php

namespace App\Http\Controllers;

use App\DemoEntity;
use App\Http\Requests\DemoEntityRequest;
use Illuminate\Http\Request;

class DemoCrud extends Controller
{
    public function index() {
        $models = DemoEntity::all();
        return view('theme/demo/index', ['models' => $models]);
    }

    public function create() {
        return view('theme/demo/form');
    }

    public function show(DemoEntity $model) {
        return view('theme/demo/view', ['model' => $model]);
    }

    public function edit(DemoEntity $model) {
        return view('theme/demo/form', ['model' => $model]);
    }

    public function store(DemoEntityRequest $request) {
        DemoEntity::create($request->all());

        return redirect()->route('demo.model.index')
            ->with('success','Created');
    }

    public function update(DemoEntityRequest $request, DemoEntity $model) {
        $model->update($request->all());

        return redirect()->route('demo.model.index')
            ->with('success','Updated');
    }
}
