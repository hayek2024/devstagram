@extends('layouts.app')

@section('titulo')
    Página principal
@endsection

@section('contenido')
    {{-- x- indica es un componente de Laravel. Con '/' = no slots, sin / y con cierre = slot --}}
    <x-listar-post :posts="$posts" />
    {{-- Con esta sintaxis ':posts="$posts"' pasamos la variable que recibimos del método __invoke
        de HomeController.php hacia el componente listar-post.blade.php . Adicionalmente requiere
        que en el ListarPost.php, en el constructor incluyamos  --}}


{{-- EJEMPLOS de cómo se usan los componentes    

    <x-listar-post>
        <x-slot:titulo>
            <header>Esto es un header</header>
        </x-slot:titulo>

        <h1>Mostrando posts desde slots</h1>
    </x-listar-post> --}}

@endsection