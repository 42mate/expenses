<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all()
            ->sortBy('category');

        return view('pages.category.index',[
            'categories' => $categories
        ]);
    }

    public function create() {
        return view('pages.category.create');
    }

    public function store(Request $request) {
        $request->validate([
            'category'=> 'required|unique:App\Category,category|max:100',
        ]);

        Category::create([
            'category' => $request->category,
            'user_id' => Auth::id(),
        ]);

        return redirect('/category')->with('success', 'Category created!');
    }
}
