<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AttributeController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Attributes/Index', [
            'filters' => Request::all('search'),
            'attributes' => Attribute::query()
                ->filter(Request::only('search'))
                ->paginate(10)
                ->withQueryString()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Attributes/Create', [
            'attributes' => Attribute::all(),
        ]);
    }

    public function store(StoreAttributeRequest $request)
    {
        $fields = Request::validate([
            'title' => ['required', 'max:50'],
        ]);

        $fields['slug'] = Str::slug($fields['title']);
        $fields['organization_id'] = auth()->user()->organization->id;

        Attribute::create($fields);

        return Redirect::route('attributes.index')->with('success', 'Attribute created.');
    }

    public function edit(Attribute $attribute)
    {
        return Inertia::render('Admin/Attributes/Edit', [
            'attribute' => $attribute,
            'attributes' => Attribute::all(),
            'attributeValues' => AttributeValue::all(),
        ]);
    }

    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        $fields = Request::validate([
            'title' => ['required', 'max:50'],
        ]);

        $fields['slug'] = Str::slug($fields['title']);

        $attribute->update($fields);

        return Redirect::route('attributes.index')->with('success', 'Attribute updated.');
    }


    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return Redirect::back()->with('success', 'Attribute deleted.');
    }

    public function restore(Attribute $attribute)
    {
        $attribute->restore();

        return Redirect::back()->with('success', 'Attribute restored.');
    }
}
