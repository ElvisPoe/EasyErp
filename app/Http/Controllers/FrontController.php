<?php

namespace App\Http\Controllers;

use App\Models\Treasure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class FrontController extends Controller
{
    public function account() {
        return Inertia::render('Account');
    }
}
