<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $imagen = $request->file('file');  // Este es el archivo de imagen recibido en la petición

        $nombreImagen = Str::uuid() . "." . $imagen->extension();
            //        Genera id único
        $imagenServidor = Image::make($imagen);
        $imagenServidor->fit(1000,1000);    // Cortamos la imagen en forma de cuadrado de 1000 px
        // Por defecto corta tomando el centro como referencia, pero en argumentos se puede cambiar, en callback puede ir 'null'
        $imagenPath = public_path('uploads') . '/' . $nombreImagen; // La ruta 
        $imagenServidor->save($imagenPath);

        return response()->json(['imagen' => $nombreImagen]);
    }
}



// OJO: Composer ya viene instalado en Docker
// En la carpeta Vendor están todas las dependencias que vamos instalando
// En Laravel, Package Discovery es una funcionalidad que detecta paquetes y los añade
//      automáticamente al autoload y archivo composer.json

// Instalamos Intervention Image con "sail composer require intervention/image"
// INTEGRACIÓN EN LARAVEL - 1. En config/app.php buscar arreglo "providers"

