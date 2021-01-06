<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function edit(Tag $model)
    {
        return view('pages.tag.form', [
            'model' => $model
        ]);
    }

    public function update(Request $request, Tag $model) {
        $request->validate([
            'name'=> 'required|max:100',
        ]);

        $model->fill([
            'name' => $request->name,
        ]);

        $model->save();

        return redirect('/tag')->with('success', 'Tag updated!');
    }

    public function delete(Tag $model)
    {
        if ($model->expenses()->count() > 0) {
            return redirect('/tag')
                ->with('warning',
                    'This tag has related expenses, it can\'t be deleted!');

        }

        $model->delete();

        return redirect('/tag')->with('success', 'Tag Deleted!');
    }

    public function index()
    {
        $model = Auth::user()->tags()->get();

        return view('pages.tag.index', [
            'tags' => $model,
        ]);
    }
}
