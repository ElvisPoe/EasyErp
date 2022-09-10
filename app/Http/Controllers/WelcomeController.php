<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function welcome() {
        return Inertia::render('Welcome');
    }
}
