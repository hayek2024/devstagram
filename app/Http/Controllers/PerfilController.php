<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }   // Este método con ese middleware es para proteger todos los métodos de este controlador para
        // que solo los usuarios autenticados puedan acceder a ellos. Asegura que todas las rutas del
        // controlador exijan autenticación. Esto no limita el acceso al dueño expecífico de la ruta
        // en cuestión.

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request) // A un store siempre se le pasa el Request
    {
        // Modificar el request - En general se debe evitar modificar el request
        $request->request->add(['username' => Str::slug($request->username), // slug(convierte a URL-friendly(minúsculas y guiones en lugar de espacios))
                                'email' => strtolower($request->email)
                               ]);
        // Este slug() lo aplicamos antes de validar para que la validación pueda reconocer si es que el 'username' está duplicado


        $this->validate($request, [
            'username' => [
                'required',
                'unique:users,username,'.auth()->user()->id, 
                'min:3', 
                'max:20', 
                'not_in:devstagram,editar-perfil'
            ],
            // En la doc de Laravel recomiendan que si son más de 3 reglas es mejor colocarlas como arreglo
            
            // not_in es una especie de lista negra cuyos elementos no pueden ser utilizados como username, en el caso de editar-perfil es para evitar conflicto con la ruta editar-perfil
            
            // La sintaxis: "'unique:users,username,'.auth()->user()->id" en esta regla impide que se
            // muestre error de validación si el usuario deja su username idéntico a como lo tenía
            // previamente, por ejemplo, en el caso de que solo quiera cambiar su imagen de perfil,
            // daría el error "El usuario ya existe" de manera equivocada.
            'email' => [
                'required',
                'unique:users,email,'.auth()->user()->id,
                'email',
                'max:60',
                'regex:/^[a-zA-Z0-9._%+-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z]{2,}$/'   // para que no pongan correos como cocol@correo, sin la extensión TLD, y hace otras validaciones, preguntar a la IA para saber bien cuáles más
            ],
            'password' => 'required', // Agregamos validación para verificar que proporcionó su password actual
            'password_nueva' => 'nullable|confirmed|min:6'
        ]);

        // Verificar que la contraseña actual coincida usando Hash::check()
        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->with('mensaje', 'Tu contraseña actual no es correcta.'); // Aquí podrías mostrar un mensaje en la sesión
        } // El maestro había dicho usáramos algo como "!auth()->attempt($request->only('email', 'password')"
          // Pero ChatGPT me propuso el método check(), que se me hizo más adecuado porque el usuario
          // a esas alturas ya está autenticado.
        
        if($request->imagen) {
            $imagen = $request->file('imagen');  // Este es el archivo de imagen recibido en la petición

            $nombreImagen = Str::uuid() . "." . $imagen->extension();
                //        Genera id único
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000,1000);    // Cortamos la imagen en forma de cuadrado de 1000 px
            // Por defecto corta tomando el centro como referencia, pero en argumentos se puede cambiar, en callback puede ir 'null'
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen; // La ruta 
            // La carpeta /perfiles la creamos manualmente, si no, en ciertos OS se necesitan dar
            // permisos para que se creen la carpetas(creo es el caso de Linux). Podrías modificar el
            // permiso a 777 pero eso es MUY MUY INSEGURO! 
            $imagenServidor->save($imagenPath);
        } 

        // Guardar cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->email = $request->email;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null; // nullish coalescing
        // Si no subió una imagen toma el nombre de imagen anterior desde el usuario autenticado
        // Si tampoco la hay, pone null.
        
        // Si el usuario proporcionó una nueva contraseña, actualízala
        if ($request->password_nueva) {
            $usuario->password = Hash::make($request->password_nueva);
        }

        $usuario->save();
        
        // Redireccionar
        // Puede ser que el usuario haya cambiado su username por lo que en la redirección usamos la
        // instancia en memoria(la última copia)
        return redirect()->route('posts.index', $usuario->username);
        // El 'return' siempre se necesita para dar finalización a la ejecución del script
        // El redirect() le regresa la instrucción al navegador del cliente de que vuelva a generar
        // otra consulta HTTP hacia otro endpoint, a diferencia de view() que solo presenta cierta
        // info recuperada y la pasa a una plantilla Blade para que sea mostrada al navegador del cliente
    }
}
