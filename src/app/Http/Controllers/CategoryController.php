<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::allForUser();

        if ($request->filled('name')) {
            $categories->where('category', 'LIKE', '%' . $request->name . '%');
        }

        return view('pages.category.index', [
            'categories' => $categories->get(),
            'name' => $request->name,
        ]);
    }

    public function create()
    {
        return view('pages.category.form');
    }

    public function edit(Category $category)
    {
        return view('pages.category.form', [
            'model' => $category,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => ['required', 'max:100', Rule::unique('categories', 'category')->where('user_id', Auth::id())],
        ]);

        Category::create([
            'category' => $request->category,
            'user_id' => Auth::id(),
        ]);

        return redirect('/category')->with('success', 'Category created!');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category' => ['required', 'max:100', Rule::unique('categories', 'category')->where('user_id', Auth::id())->ignore($category->id)],
        ]);

        $category->fill([
            'category' => $request->category,
        ]);

        $category->save();

        return redirect('/category')->with('success', 'Category Updated!');
    }

    public function ajaxStore(Request $request)
    {
        $request->validate([
            'category' => ['required', 'max:100', Rule::unique('categories', 'category')->where('user_id', Auth::id())],
        ]);

        $category = Category::create([
            'category' => $request->category,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['id' => $category->id, 'name' => $category->category]);
    }

    public function delete(Category $category)
    {
        if ($category->expenses()->count() > 0) {
            return redirect('/category')
                ->with('warning', 'This category has related expenses, it can\'t be deleted!');
        }

        $category->delete();

        return redirect('/category')->with('success', 'Category Deleted!');
    }
}
