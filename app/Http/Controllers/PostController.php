<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
        // Este middleware se ejecuta un instante antes del index() para autenticar al usuario
        // Se asegura de que el usuario esté autenticado antes de darle acceso a cualquier otro de los métodos
        // Esto protege las URLs. 
        // Un usuario sí debería poder ver posts pero no comentar, eso se hace con except()
    }

    public function index(User $user)
    {
        //dd(auth()->user());
        // auth() revisa qué usuario está autenticado actualmente
        // lo que en PHP guardábamos en $_SESSION[], en Laravel se va guardando en user()
        
        // $posts = Post::where('user_id', $user->id)->get();  // El get() ejecuta la consulta
        $posts = Post::where('user_id', $user->id)->latest()->paginate(5);
                        // Reemplazamos el get() por paginate()
        
        // $posts = $user->posts; Es otra forma de traer/jalar los registros y funciona porque definimos en el modelo User, la relación hasMany() con Post, 
        // PERO... usando esa sintaxis NO se puede utilizar la PAGINACIÓN de Laravel.

        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create(User $user)
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);


        // Primer sintaxis para crear un registro de Post en la base de datos
        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id
        // ]);

        // Otra sintaxis o forma de hacer el mismo registro en la base de datos,
        //   hacen lo mismo, mismo performance, solo diferente estilo:
        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        // Una 3er sintaxis para guardar un registro en la base de datos ya 
        //   utilizando las relaciones que acabamos de crear
        $request->user()->posts()->create([
            // 1. accedemos al usuario autenticado que viene en el objeto de $request
            // 2. accedemos a la relación que hemos creado en posts()
            // 3. creamos un registro en esa relación, o sea en la forma de Post, en la tabla posts
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('posts.index', auth()->user()->username);
    }

    // Método para mostrar un post específico - al dar click en la imagen
    public function show(User $user, Post $post) // Esto es un resource controller
    { // El route model binding hace que la variable que espera en la ruta de web.php
      // se pase automáticamente hacia el método show() como argumento y al estar asociado 
      // al modelo Post, lo consulta automáticamente y pasa la instancia hacia la vista
        return view('posts.show', [
            'user' => $user,
            'post' => $post
        ]);
    }
                      
    public function destroy(Post $post)
    {                 // Toma el {post} de la ruta como argumento
        // En lugar de escribir un código como el siguiente, en cada método como en PHP sin Laravel
            // ____________________________________________________
            // if($post->user_id === auth()->user()->id){
            //     eliminar();
            // } else {
            //     noPermitirEliminar();
            // } __________________________________________________  
        // Usamos un policy y el método authorize() para validar que el que está eliminando
        // es el dueño del post
    
        // Usamos un policy para autorizar la eliminación de registros
        $this->authorize('delete', $post);  // Con este método se usa PostPolicy.php para autorizar 
        // Si no está autorizado, se detiene la ejecución y se envía a página de error 403 Forbidden.
        $post->delete();

        // Eliminar la imagen
        $imagen_path = public_path('uploads/' . $post->imagen);
        if(File::exists($imagen_path)) {
            unlink($imagen_path);   // El método unlink() de PHP elimina la imagen
        }
        
        return redirect()->route('posts.index', auth()->user()->username);
    }   
}

/* NOTAS sobre el uso de $this dentro de las clases
    No me quedaba claro a qué instancia hacía referencia $this. Por unos momentos pensé
        que hacía referencia al objeto que venía como argumento al ser llamado el método.
    ChatGPT me explicó:

    Laravel crea la instancia del controlador de forma automática cuando se hace una 
    solicitud a una URL que corresponde a una ruta definida en tus archivos de 
    configuración de rutas (routes/web.php)
    
    Ejemplo, en el contexto de la clase-controlador PostController:

    Cuando el usuario navega a la URL /posts, Laravel automáticamente:

        1. Resuelve que la solicitud debe ser manejada por el método index del controlador 
        PostController.

        2. Crea una instancia de PostController y llama al método index.

    Esto sucede de forma automática, sin que tú instancies PostController manualmente 
    en algún lugar del código. Por eso dentro de los métodos de la clase controladora 
    puedes usar $this para referirte a esa instancia activa.

    Por lo tanto, dentro de los métodos store() y destroy(), $this **no hace referencia 
    ni a $request ni a $post**, sino que apunta al controlador (PostController`) para 
    permitirte usar métodos disponibles en esa clase o en clases base heredadas.
 */