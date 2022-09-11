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
        return Inertia::render('Admin/Categories/Create', [
            'categories' => Category::all(),
            'parentCategory' => request('parentCategory')
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $fields = Request::validate([
            'title' => ['required', 'max:50'],
            'description' => ['required'],
            'published' => ['required'],
        ]);

        $fields['parent_category'] = $request->parent_category;
        $fields['organization_id'] = auth()->user()->organization->id;

        Category::create($fields);

        return Redirect::route('categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Admin/Categories/Edit', [
            'category' => $category,
            'categories' => Category::all(),
            'childrenCategories' => Category::all()->where('parent_category', $category->id)
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $fields = Request::validate([
            'title' => ['required', 'max:50'],
            'description' => ['required'],
            'published' => ['required'],
        ]);

        $category['parent_category'] = $request->parent_category;

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
