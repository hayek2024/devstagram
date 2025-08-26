<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function index() 
    {
        return view('auth.register');   // El punto "." hace la función de la diagonal para indicar entrada a directorios
    }

    public function store(Request $request)
    { 
        // dd($request); // función de Laravel 'dumb and die' dd() imprime lo que le pongas y detiene la ejecución, es para debuggear. 
        // dd($request->get('username')); // Se pueden acceder a los valores del objeto de la petición/request que es una clase de Symfony/Laravel
        
        // Validación en Laravel
        // Paquete de idoma Español en Laravel - https://github.com/MarcoGomesr/laravel-validation-en-espanol  
        // Ojo: para poner en español los mensajes, editar archivo config/app.php donde dice lang a 'es'
        
        // Modificar el request - En general hay que tratar de evitar modificarlo
        $request->request->add(['username' => Str::slug($request->username)]);
                                                // slug(convierte a URL-friendly(minúsculas y guiones en lugar de espacios))
            // Este slug() lo aplicamos antes de validar para que la validación pueda reconocer si es que el 'username' está duplicado
        $this->validate($request, [ 
            'name' => 'required|max:30',    // 'name' => ['required', 'min:5']  -> También funciona con la sintaxis de arreglo
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6'
        ]);
    
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Autenticar un usuario
        // auth()->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ]);

        // Otra forma de autenticar
        auth()->attempt($request->only('email', 'password'));

        // Redireccionar
        return redirect()->route('posts.index');
    
    }

    /* Laravel es un framework enfocado en la seguridad, y te protege de ataques XSRF, Cross-site request forgery */
}
