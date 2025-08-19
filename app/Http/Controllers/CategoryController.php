<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index() {
        abort_if(!auth()->user()->can('category.view'), 403);

        $categories = Category::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create() {
        abort_if(!auth()->user()->can('category.add'), 403);

        return view('categories.create');
    }

    public function store(Request $request) {
        abort_if(!auth()->user()->can('category.add'), 403);

        $request->validate([
            'name' => 'required|unique:categories',
            'image' => 'nullable|image',
            'status' => 'required|string|in:active,inactive',
        ]);

        $data = $request->only(['name', 'status']);
        // $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category) {
        abort_if(!auth()->user()->can('category.update'), 403);

        return view('categories.create', compact('category'));
    }

    public function update(Request $request, Category $category) {
        abort_if(!auth()->user()->can('category.update'), 403);

        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'image' => 'nullable|image',
            'status' => 'required|string|in:active,inactive',
        ]);

        $data = $request->only(['name', 'status']);

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category) {
        abort_if(!auth()->user()->can('category.delete'), 403);

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
