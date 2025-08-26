@extends('layouts.app')

@section('titulo')
    Editar Perfil: {{ auth()->user()->username }}
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            <form method="POST" action="{{ route('perfil.store') }}" 
                class="mt-10 md:mt-0" enctype="multipart/form-data">
                @csrf   {{-- agregamos el token, protegiendo para este tipo de ataques --}}

                @if(session('mensaje'))
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ session('mensaje') }}
                    </p>
                @endif
                
                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
                        Username
                    </label>
                    <input 
                        id="username"
                        name="username"
                        type="text"
                        placeholder="Tu nombre de usuario"
                        class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror"
                        value="{{ auth()->user()->username }}"
                    >   {{-- @error es una directiva de Laravel --}}

                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="imagen" class="mb-2 block uppercase text-gray-500 font-bold">
                        Imagen Perfil
                    </label>
                    <input 
                        id="imagen"
                        name="imagen"
                        type="file" {{-- Aquí ya no usaremos Dropzone --}}
                        class="border p-3 w-full rounded-lg"
                        accept=".jpg, .jpeg, .png, .webp, .avif"
                    >   {{-- @error es una directiva de Laravel --}}
                </div>

                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                        Email
                    </label>
                    <input 
                        id="email"
                        name="email"
                        type="text"
                        placeholder="Tu email"
                        class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror"
                        value="{{ auth()->user()->email }}"
                    >   {{-- @error es una directiva de Laravel --}}

                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                        <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                            Password Actual
                        </label>
                        <input 
                            id="password"
                            name="password"
                            type="password"
                            placeholder="Tu password actual"
                            class="border p-3 w-full rounded-lg @error('p') border-red-500 @enderror"
                            {{-- La password no se debe rellenar con el valor anterior old() por seguridad - Lección 69 --}}
                        >
                        @error('password')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                                {{ $message }}</p>
                        @enderror
                    </div>

                <div class="lg:flex lg:justify-around">

                    <div class="mb-5">
                        <label for="password_nueva" class="mb-2 block uppercase text-gray-500 font-bold">
                            Nueva Password
                        </label>
                        <input 
                            id="password_nueva"
                            name="password_nueva"
                            type="password"
                            placeholder="Tu nueva password"
                            class="border p-3 w-full rounded-lg @error('p') border-red-500 @enderror"
                            {{-- La password no se debe rellenar con el valor anterior old() por seguridad - Lección 69 --}}
                        >
                        @error('password_nueva')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                                {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="password_nueva_confirmation" class="mb-2 block uppercase text-gray-500 font-bold">
                            Confirma Nueva Password
                        </label>
                        <input 
                            id="password_nueva_confirmation"
                            name="password_nueva_confirmation"
                            type="password"
                            placeholder="Confirmación nueva password"
                            class="border p-3 w-full rounded-lg @error('p') border-red-500 @enderror"
                            {{-- La password no se debe rellenar con el valor anterior old() por seguridad - Lección 69 --}}
                        >
                        @error('password_nueva_confirmation')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                                {{ $message }}</p>
                        @enderror
                    </div>
                </div>
                

                <input 
                    type="submit" 
                    value="Guardar cambios"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold
                    w-full p-3 text-white rounded-lg"    
                >
            </form>
        </div>
    </div>
@endsection