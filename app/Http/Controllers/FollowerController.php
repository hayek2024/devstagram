<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function store(User $user)
    { // este $user es el del perfil, que se le pasa desde la vista, por Route Model Binding
        $user->followers()->attach( auth()->user()->id ); // Agrega el follower
        
        return back();
    } // Aquí en lugar de usar ->create() como en el método store() del LikeController,
    // usamos attach debido a que en aquel caso, en la estructura de la tabla Likes
    // tenemos definidas las foreign keys/ids con nombres de modelos diferentes entre sí,
    // pero en este caso estamos creando relaciones entre diferentes registros de la misma
    // tabla de users, la relación entre usuarios y seguidores. Es una tabla pivote pero
    // relaciona usuarios de la misma tabla users.


// ---------- IMPORTANTE ------------- Lección 149 //
// Cuando uno escribe '$user->followers', debido a la relación belongsToMany definida en el 
// modelo User, en el método followers(), uno obtiene una colección de datos, o sea, los
// followers de esa instancia de User.
// EN CAMBIO - cuando uno escribe '$user->followers()' con paréntesis, uno puede acceder
// al los métodos del OBJETO DE RELACIÓN producto de esa misma definición de la relación
// belongsToMany. El objeto de tipo BelongsToMany incluye métodos útiles como attach(),
// detach(), o sync(), para gestionar la tabla PIVOTE. 
// Un objeto de relación es un concepto específico de Eloquent, el ORM (Object-Relational 
// Mapper) de Laravel, y no es un concepto general de PHP. Eloquent utiliza objetos de 
// relación para manejar las relaciones entre modelos de tu aplicación y las tablas de tu 
// base de datos. Este mecanismo es una característica esencial que hace que trabajar con 
// relaciones en Laravel sea intuitivo y expresivo.

    public function destroy(User $user)
    { // este $user es el del perfil, que se le pasa desde la vista, por Route Model Binding
        $user->followers()->detach( auth()->user()->id );   // Elimina el follower
        
        return back();
    }
}