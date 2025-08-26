@extends('layouts.app')

@section('titulo')
    Inicia sesión en DevStagram
@endsection

@section('contenido')
    <div class="md:flex md:justify-center md:gap-4 md:items-center">
        <div class="md:w-4/12 p-5">
            <img src="{{ asset('img/login.jpg') }}" alt="Imagen login usuarios">
        </div>  {{-- La función asset() apunta directamente hacia el directorio public --}}
                {{-- Al ver en dev tools en navegadores aparece la ruta completa no solo la relativa, evita problemas de que no encuentre el archivo --}}
        <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-xl">
            <form method="POST" action="{{ route('login') }}" novalidate>
                {{-- novalidate sirve para probar la validación desde el servidor, para que HTML5 no valide e impida el envío del request al servidor --}}
                @csrf   {{-- protegemos para este tipo de ataques --}}
    
                @if(session('mensaje'))
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ session('mensaje') }}
                    </p>
                @endif

                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                        Email
                    </label>
                    <input 
                        id="email"
                        name="email"
                        type="email"
                        placeholder="Tu email de registro"
                        class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Password
                    </label>
                    <input 
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Tu password de registro"
                        class="border p-3 w-full rounded-lg @error('p') border-red-500 @enderror"
                        {{-- La password no se debe rellenar con el valor anterior old() por seguridad - Lección 69 --}}
                    >
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <input id="remember" type="checkbox" name="remember"> <label for="remember" class="text-sm text-gray-500">
                        Mantener mi sesión abierta</label>
                </div>

                <input 
                    type="submit" 
                    value="Iniciar sesión"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold
                    w-full p-3 text-white rounded-lg"    
                >
            </form>
        </div>
    </div>
@endsection

