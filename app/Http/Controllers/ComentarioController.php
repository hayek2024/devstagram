<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request, User $user, Post $post)
    {           // el User solo lo importamos y ponemos como parámetro para tener uniformidad en la URL aunque no se usa en el método store()
        // Validar
        $this->validate($request, [
            'comentario' => 'required|max:255'
        ]);
        
        // Almacenar
        Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]);
        
        // Imprimir resultado
        return back()->with('mensaje', 'Comentario realizado exitosamente');
        // Redireccionamos de REGRESO a la misma URL al usuario CON una variable de
        // sesión llamada 'mensaje'. Esos with() se imprimen con una session() en la vista
        // A esta funcionalidad de Laravel se le llama "flashear datos a la sesión" y sirve
        // para guardar información temporalmente en la sesión), que luego pueden ser leídos 
        // en la siguiente solicitud HTTP. Flashear datos significa que estos estarán 
        // disponibles solo hasta la próxima respuesta, después de lo cual serán eliminados 
        // automáticamente.
    }
}
