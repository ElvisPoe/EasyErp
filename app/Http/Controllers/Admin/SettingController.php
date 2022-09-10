<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use Inertia\Inertia;

class SettingController extends Controller
{

    public function index()
    {
        return Inertia::render('Admin/Settings/Index');
    }

    public function create()
    {
        //
    }

    public function store(StoreSettingRequest $request)
    {
        //
    }

    public function show(Setting $setting)
    {
        //
    }

    public function edit(Setting $setting)
    {
        //
    }

    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        //
    }

}
