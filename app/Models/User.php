<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {   // Relación ONE TO MANY - Así se crea la relación, 
        // donde un USER puede tener múltiples POSTS
        return $this->hasMany(Post::class);
        // En caso de que no hayas usado la convención de Laravel de nombrar al foreign key que relaciona los posts al usuario (modelo de User) que los creó 
        // como 'user_id', tendrías que especificarla como segundo argumento en hasMany(), [ejemplo: que fuera 'autor_id' en lugar de 'user_id']
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
        // Esta función/relación la creamos justo al momento de escribir el método destroy()  
        // dentro del controlador Post para eliminar likes.
    }
    
    // Almacena los seguidores de un usuario
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    } // El método belongsToMany() retorna un OBJETO DE RELACIÓN de tipo BelongsToMany

    public function following()
    {                        // Cambiamos al orden inverso de estas dos columnas, comparado con el método followers
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }   // Dice el prof la relación es de muchos:muchos

    // Comprobar si un usuario ya sigue a otro
    public function siguiendo(User $user) // El parámetro recibido es del usuario autenticado, NO del 
    // usuario cuyo perfil está siendo visitado(que es el de la instancia/objeto desde el 
    // cual estamos llamando este método y se obtiene por Route Model Binding)
    {
        return $this->followers->contains( $user->id );
    }   // Sirve para condicionalmente mostrar los botones de SEGUIR o DEJAR DE SEGUIR dependiendo
        // Si el usuario autenticado sigue o no al del perfil que está visitando

}
