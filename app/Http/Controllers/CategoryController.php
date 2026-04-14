<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        'division' => 'required|string',
        'name' => [
            'required',
            'string',
            Rule::unique('categories')->where(function ($query) use ($request) {
                return $query->where('name', $request->name)
                             ->where('division', $request->division);
            }),
        ],
    ], [
        'name.unique' => 'Kategori dengan nama dan divisi ini sudah ada!',
    ]);

    \App\Models\Category::create($request->all());

    return redirect()->route('categories.index')->with('success', 'Success add category!');
}
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'division' => 'required|string',
        'name' => [
            'required',
            'string',
            Rule::unique('categories')->where(function ($query) use ($request) {
                return $query->where('name', $request->name)
                             ->where('division', $request->division);
            })->ignore($id), // Abaikan ID ini biar bisa save data yang sama
        ],
    ], [
        'name.unique' => 'Kategori dengan nama dan divisi ini sudah ada!',
    ]);

    $category = \App\Models\Category::findOrFail($id);
    $category->update($request->all());

   return redirect()->route('categories.index')->with('success', 'Success update category!');
}
}
