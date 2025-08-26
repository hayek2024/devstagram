<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];

    // Aquí el $fillable no requiere el post_id debido a que al llamarse
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
}
