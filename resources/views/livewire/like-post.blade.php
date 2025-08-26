{{-- En Livewire siempre se debe retornar un DIV como elemento padre(al igual que en React)--}}
<div>
    {{-- <h1>{{ $mensaje }}</h1> --}}
    <div class="flex gap-2 items-center">
        <button
            wire:click="like"   {{-- Añadimos evento de Livewire que corresponde al método like() 
                                     del componente LikePost --}}
        >
            <svg xmlns="http://www.w3.org/2000/svg" 
                fill="{{ $isLiked ? "red" : "white" }}" 
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
            </svg>
        </button>
        
        <p class="font-bold">
            {{ $likes }} {{-- $likes es un atributo dinámico/reactivo de Livewire --}} 
            <span class="font-normal">Likes</span>
        </p>
    </div>
</div>

{{-- Evitamos tener que usar lo de @csrf ya que Livewire ya tiene todas esas medidas de seguridad --}}