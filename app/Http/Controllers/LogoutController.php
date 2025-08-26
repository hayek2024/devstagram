<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function store()
    {
        auth()->logout();   // Cerramos sesión

        return redirect()->route('login');
    }
}
