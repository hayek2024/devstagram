<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    // Laravel tiene una propiedad llamada "fillable" que es info que se va a llenar en
    // la base de datos. Es una forma de proteger tu base de datos. Sirve para que Laravel
    // sepa qué info se debe leer y procesar antes de enviarla hacia la base de datos.
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select(['name', 'username']);
        // Así creamos la relación BELONGS TO que es necesaria en este caso 
        // como complemento/contraparte a la HAS MANY que le declaramos a User
        
        // Es necesario llamarle a este método 'user()' debido a las convenciones y reglas
        // de Laravel, ya que el foreign key en la migración/tabla de posts llamado user_id
        // se mappea con el método 'user()' del modelo Post. Laravel automáticamente 
        // ASUME que la relación es entre 'user'_id y 'user'() 
        // Si uno quisiera nombrar el método, por ejemplo como 'autor()' habría que añadirle
        // ", 'user_id'" después de "User::class", y ya funcionaría correctamente. Pero mejor
        // usar las convenciones de Laravel para un código más limpio y estandarizado.
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
        // Al crear esta relación hacia Comentario ya no tenemos que escribir nada de
        // lógica de consulta de BD como un where() o post_id, nada de eso. Laravel
        // automáticamente lo hace por nosotros.
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function checkLike(User $user)   // Le pasamos el usuario porque 'obviamente este modelo
    // de Post no sabe qué usuario es el que le está dando click. Entonces al mandar llamar el método
    // se lo pasaremos.
    {
        return $this->likes->contains('user_id', $user->id);
    }       // Usamos likes sin los '()' para acceder a la información directamente. Si le pusiéramos
            // los paréntesis nos estaríamos refiriendo a LA RELACIÓN. No sé qué nos retornaría pero
            // eso mencionó el prof

}