<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListarPost extends Component
{
    public $posts;  // Tenemos que definir aquí la variable

    public function __construct($posts)
    {   
        // Lo que pongas en el constructor, es la info que se le va a pasar al componente(variables)
        $this->posts = $posts;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.listar-post');
    }
}
