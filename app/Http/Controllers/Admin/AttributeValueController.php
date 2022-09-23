<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreAttributeValueRequest;
use App\Http\Requests\UpdateAttributeValueRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AttributeValueController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Attributes/Values/Index', [
            'filters' => Request::all('search'),
            'attributeValues' => AttributeValue::query()
                ->filter(Request::only('search'))
                ->paginate(10)
                ->withQueryString()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Attributes/Values/Create', [
            'attributeValues' => AttributeValue::all(),
        ]);
    }

    public function store(StoreAttributeValueRequest $request)
    {
        $fields = Request::validate([
            'title' => ['required', 'max:50'],
            'published' => ['required'],
            'attribute_id' => ['required'],
        ]);

        $fields['slug'] = Str::slug($fields['title']);

        AttributeValue::create($fields);

        return Redirect::back()->with('success', 'Attribute value created.');
    }

    public function edit(AttributeValue $attributeValue)
    {
        return Inertia::render('Admin/Attributes/Values/Edit', [
            'attributeValue' => $attributeValue,
        ]);
    }

    public function update(UpdateAttributeValueRequest $request, AttributeValue $attributeValue)
    {
        $fields = Request::validate([
            'title' => ['required', 'max:50'],
            'attribute_id' => ['required'],
        ]);

        $fields['slug'] = Str::slug($fields['title']);

        $attributeValue->update($fields);

        return Redirect::back()->with('success', 'Attribute value updated.');
    }


    public function destroy(AttributeValue $attributeValue)
    {
        $attributeValue->delete();

        return Redirect::back()->with('success', 'Attribute value deleted.');
    }

    public function restore(AttributeValue $attributeValue)
    {
        $attributeValue->restore();

        return Redirect::back()->with('success', 'Attribute value restored.');
    }
}
