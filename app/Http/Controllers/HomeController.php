<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }

    // Cuando tengas un controlador que solo va a tener 1 método, puedes usar '__invoke' en lugar
    // de 'index', creando un método invocable, al estilo de un constructor, lo que te permite en
    // el archivo de rutas web.php solo tener la siguiente sintaxis:
    // Route::get('/', HomeController::class)->name('home');     o sea, sin corchetes o nombre de método
    // y se invocará automáticamente apenas se visite esa ruta. Es más limpio que usar closures
    // especialmente cuando son muchos.
    public function __invoke()
    {
        // Obtener a quiénes seguimos
        $ids = auth()->user()->following->pluck('id')->toArray();
        // pluck extrae solo cierto campo del objeto, toArray los convierte a un arreglo
        //dd('$ids');
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);
        // where() solo filtra o busca un valor, pero como aquí le estamos pasando un arreglo de ids
        // usamos whereIn()

        return view('home', [
            'posts' => $posts
        ]);
    }
}
