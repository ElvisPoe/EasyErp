<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Categories/Index', [
            'filters' => Request::all('search'),
            'categories' => Category::query()
                ->filter(Request::only('search'))
                ->paginate(10)
                ->withQueryString()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Categories/Create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $fields = Request::validate([
            'title' => ['required', 'max:50'],
            'description' => ['required'],
            'parent_category' => ['required'],
            'published' => ['required'],
        ]);

        $fields['organization_id'] = auth()->user()->organization->id;

        Category::create($fields);

        return Redirect::route('categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Admin/Categories/Edit', [
            'category' => $category
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $fields = Request::validate([
            'title' => ['required', 'max:50'],
            'description' => ['required'],
            'parent_category' => ['required'],
            'published' => ['required'],
        ]);

        $category->update($fields);

        return Redirect::route('categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return Redirect::back()->with('success', 'Category deleted.');
    }

    public function restore(Category $category)
    {
        $category->restore();

        return Redirect::back()->with('success', 'Category restored.');
    }
}
