<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index() {
        $categories = Auth::user()
            ->categories()
            ->get()
            ->sortBy('category');

        return view('pages.category.index',[
            'categories' => $categories
        ]);
    }

    public function create() {
        return view('pages.category.form');
    }

    public function edit(Category $category) {
        return view('pages.category.form', [
            'model' => $category
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'category'=> 'required|max:100',
        ]);

        Category::create([
            'category' => $request->category,
            'user_id' => Auth::id(),
        ]);

        return redirect('/category')->with('success', 'Category created!');
    }

    public function update(Request $request, Category $category) {
        $request->validate([
            'category'=> 'required|max:100',
        ]);

        $category->fill([
            'category' => $request->category,
        ]);

        $category->save();

        return redirect('/category')->with('success', 'Category Updated!');
    }

    public function delete(Category $category) {
        if ($category->expenses()->count() > 0) {
            return redirect('/category')
                ->with('warning', 'This category has related expenses, it can\'t be deleted!');

        }

        $category->delete();

        return redirect('/category')->with('success', 'Category Deleted!');

    }
}
