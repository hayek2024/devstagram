<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if(!auth()->attempt($request->only('email', 'password'), $request->remember) ) {
            return back()->with('mensaje', 'Credenciales incorrectas'); // Este mensaje va a ser colocado en la sesión
            // Esta sintaxis lo que hace es regresar(back()) a la página anterior con(with()) ese mensaje. O sea, el usuario al enviar su petición POST desde /login hacia /login se le regresa a /login pero con dicho mensaje.
        }

        return redirect()->route('posts.index', auth()->user()->username);
    }
}
