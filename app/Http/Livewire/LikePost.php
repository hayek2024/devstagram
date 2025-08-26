<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    public $mensaje = "Hola desde atributo de la clase LikePost(Component) de Livewire";
    // Al registrar la variable como public en esta parte no es necesario pasarla en el 
    // return view() como arreglo(como hacíamos antes) 
    // sino que automáticamente ya está disponible en la vista. (usando Livewire)

    public $post;   // Este $post lo recibimos de la template show al escribir ' :post="$post" '
    public $isLiked;
    public $likes;

    // public $mensajeVar;  - Ejemplo para recibir variables desde la template padre
    
    // esta función se le puede conocer como "del ciclo de vida" de Livewire
    // Es igual que un constructor en PHP pero aquí se llama mount
    public function mount($post)
    {   // Este mount se ejecuta automáticamente cuando se instancia esta clase en la template show
        $this->isLiked = $post->checkLike(auth()->user());
        $this->likes = $post->likes()->count();
    }

    public function like()
    {
        if( $this->post->checkLike( auth()->user() ) ) {
            $this->post->likes()->where('post_id', $this->post->id)->delete();
            // En Livewire NO está disponible el Request $request, antes sin Livewire eliminábamos así:
            // $request->user()->likes()->where('post_id', $post->id)->delete();
            // Eliminamos el return back(); y nos deshacemos del salto producto de recargar página completa
            $this->isLiked = false;
            $this->likes--; // Solo actualiza el atributo likes montado al instanciarse el componente
        } else {
            $this->post->likes()->create([
                'user_id' => auth()->user()->id 
            ]);
            $this->isLiked = true;
            $this->likes++; // Solo actualiza el atributo likes montado al instanciarse el componente
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
