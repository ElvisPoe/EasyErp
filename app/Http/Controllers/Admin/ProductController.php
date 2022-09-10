<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ProductController extends Controller
{

    public function index()
    {
        return Inertia::render('Admin/Products/Index', [
            'filters' => Request::all('search'),
            'products' => Product::query()
                ->filter(Request::only('search'))
                ->paginate(10)
                ->withQueryString()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Products/Create', [
            'categories' => Category::all()
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $fields = Request::validate([
            'title' => ['required', 'max:50'],
            'short_description' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'sale_price' => ['required'],
            'sku' => ['required'],
            'barcode' => ['required'],
            'weight' => ['required'],
            'has_variations' => ['required'],
//            'images' => ['required'],
            'published' => ['required'],
            'category_id' => ['required'],
        ]);

        $fields['organization_id'] = auth()->user()->organization->id;

        Product::create($fields);

        return Redirect::route('products.index')->with('success', 'Product created.');
    }


    public function edit(Product $product)
    {
        return Inertia::render('Admin/Products/Edit', [
            'categories' => Category::all(),
            'product' => $product,
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        dd($request->all());
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return Redirect::back()->with('success', 'Product deleted.');
    }

    public function restore(Product $product)
    {
        $product->restore();

        return Redirect::back()->with('success', 'Product restored.');
    }

}
