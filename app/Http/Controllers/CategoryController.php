<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // withCount('items') akan otomatis menghitung jumlah barang dan menyimpannya di variabel items_count
        $categories = Category::withCount('items')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'division_pj' => 'required|string',
        ]);

        Category::create([
            'name' => $request->name,
            'division_pj' => $request->division_pj,
        ]);

        return redirect()->route('categories.index');
    }
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'division_pj' => 'required|string',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'division_pj' => $request->division_pj,
        ]);

        return redirect()->route('categories.index');
    }
}
