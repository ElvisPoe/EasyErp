<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class FrontController extends Controller
{
    public function account() {
        return Inertia::render('Account');
    }
}
