<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $post->likes()->create([
           'user_id' => $request->user()->id 
        ]);

        return back();  // Que nos regrese al mismo post al dar like
    }
    // El $fillable en Like.php no requiere el post_id debido a que al llamarse
    // el método store() del LikeController al darle click en el corazón de la 
    // vista show de cada post, por el route model binding de Laravel ya 
    // disponemos de la instancia de Post a la que se está haciendo referencia.
    // De esta manera, a través de la relación hasMany definida en el método
    // likes() del PostController, creamos un registro de manera segura
    
    /* No incluir post_id en $fillable es una decisión segura y razonable en este 
    caso. Evitas posibles vulnerabilidades y aseguras que este campo solo puede 
    ser asignado automáticamente por Laravel, no de manera manual a través de 
    arrays de datos suministrados por el usuario. Esto protege contra errores o 
    manipulaciones no deseadas.

    Por ejemplo, si permitieras asignar post_id manualmente (agregándolo 
    a $fillable), un usuario podría intentar modificarlo de forma malintencionada 
    en una solicitud HTTP, asociando likes a posts que no deberían pertenecerles. 
    Al omitirlo de $fillable, previenes este tipo de problemas porque su valor 
    siempre será gestionado por el sistema a partir del contexto de la relación.*/

    public function destroy(Request $request, Post $post) 
    {
        $request->user()->likes()->where('post_id', $post->id)->delete();
        // Del request obtenemos el usuario y con el método likes accedemos a los likes que le 
        // pertenecen, de entre esos likes filtramos el que tenga en la columna post_id de la tabla
        // de likes el id del post al cual le está picando. Ese id viene
        // en el $post que tomamos como parámetro ya que automáticamente Laravel lo aporta como 
        // argumento al haber creado la relación en Post de hasMany Like.

        return back();  // Que nos regrese a la página previa
    }
}
