<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreAttributeValueRequest;
use App\Http\Requests\StoreProductAttributeRequest;
use App\Http\Requests\UpdateAttributeValueRequest;
use App\Http\Requests\UpdateProductAttributeRequest;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ProductAttributeController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/ProductAttribues/Index', [
            'filters' => Request::all('search'),
            'productAttributes' => ProductAttribute::query()
                ->filter(Request::only('search'))
                ->paginate(10)
                ->withQueryString()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/AttributeValues/Create', [
            'AattributeValues' => AttributeValue::all(),
        ]);
    }

    public function store(StoreProductAttributeRequest $request)
    {
        $fields = Request::validate([

        ]);

        $fields['organization_id'] = auth()->user()->organization->id;

        ProductAttribute::create($fields);

        return Redirect::route('attributesValue.index')->with('success', 'Attribute value created.');
    }

    public function edit(AttributeValue $attributeValue)
    {
        return Inertia::render('Admin/Categories/Edit', [
            'attributeValue' => $attributeValue,
        ]);
    }

    public function update(UpdateProductAttributeRequest $request, ProductAttribute $productAttribute)
    {
        $fields = Request::validate([

        ]);

        $productAttribute->update($fields);

        return Redirect::route('productAttribute.index')->with('success', 'Attribute updated.');
    }


    public function destroy(ProductAttribute $productAttribute)
    {
        $productAttribute->delete();

        return Redirect::back()->with('success', 'Attribute deleted.');
    }

    public function restore(ProductAttribute $productAttribute)
    {
        $productAttribute->restore();

        return Redirect::back()->with('success', 'Attribute value restored.');
    }
}
