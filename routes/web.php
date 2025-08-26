<?php

use App\Models\Comentario;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PerfilController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// En Blade existen directivas, básicamente un if(), un foreach(), por ejemplo, pero con una sintaxis especial
// @extends('')     -> Esa directiva siempre apunta hacia la carpeta Views directamente.
// @extends('layouts.') - En Laravel se usa un punto '.' en lugar de la diagonal para indicar que está dentro de un directorio
// el .blade.php se omite
// En BLADE no es necesario terminar cada sentencia con punto y coma ';'

// A esta sintaxis que inicia con "function()..." se le llama routing de tipo CLOSURE pero usaremos mejor Model View Controller( usando controladores y sus métodos)
// Route::get('/', function () {
//     return view('principal');   
// });

Route::get('/', HomeController::class)->name('home');

Route::get('/register', [RegisterController::class, 'index'])->name('register'); /* La función name de Laravel sirve
para que cuando quieras hacer un cambio en la ruta de alguna vista, solo tengas que hacer el cambio 1 vez aquí,
en el router, en lugar de ir a buscar y cambiar cada instancia/vínculo donde la usaste */
Route::post('/register', [RegisterController::class, 'store']); /* No es necesario poner el name en el post, ya lo toma desde el get */

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']); // 'store' es para almacenar info(convención de Laravel)

Route::post('/logout', [LogoutController::class, 'store'])->name('logout'); // INSEGURO usar get
// Utilizar un get con un request a una base de datos es inseguro por CSRF
// Lección 84 - Se debe usar post() para poder acceder a la directiva @csrf y a su protección
// Se debe usar un form en la vista para poder enviar la petición como method="POST"

// Rutas para el perfil
Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');

// {} convierte la ruta en una variable
// Al colocar dentro de llaves {} el nombre de un modelo estás aplicando Route-Model Binding
// Al utilizar este tipo de binding, el método index() ya esperará un modelo como parámetro
// Al usar : después de user, Laravel resuelve las URLs consultando el campo que uno guste de la
// tabla de usuarios
Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');
        // Aquí no seguimos la convención en el nombre de las rutas con el objetivo de que las urls
        // del muro de cada usuario sean sus usernames únicos
Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('posts', [PostController::class, 'store'])->name('posts.store');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
// Por default {variable} siempre va a apuntar al id del objeto/instancia que le estemos pasando como segundo argumento a la función route(). Al ser un objeto, se mappea y toma el id del mismo.
// No tienes que poner por fuerza el mismo nombre de la variable que se está recibiendo como argumento. Lo que viene dentro de {} funciona como un parámetro de función
Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');

// Siguiendo a usuarios
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');

Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

// Like a las fotos
Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('posts.likes.store');
Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy');

