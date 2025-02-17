<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6">
                    @svg('heroicon-s-arrow-left', 'h-5 w-5 mr-2') <!-- Icono de flecha -->
                    <span class="text-sm font-medium">Volver al Panel de Control</span>
                </a>
                <h2 class="text-2xl font-bold mb-4 text-black">Mis Favoritos</h2>

                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @error('notes')
                <p class="mt-4 text-sm text-red-700 border border-red-400 bg-red-200 px-4 py-3 rounded relative">{{ $message }}</p>
                @enderror

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($favorites as $favorite)
                        <div class="border rounded-lg p-4">
                            <h3 class="text-xl font-semibold mb-2 text-black">
                                <a href="{{ route('advertisements.show', $favorite->slug) }}"
                                   class="text-black hover:text-gray-800 transform hover:scale-105 transition-transform duration-300 hover:animate-pulse">
                                    {{ $favorite->title }}
                                </a>
                            </h3>

                            <!-- Formulario de Actualizar -->
                            <form action="{{ route('favorites.update', $favorite->slug) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Notas</label>
                                    <textarea name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $favorite->pivot->notes }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Prioridad</label>
                                    <select name="priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="high" {{ $favorite->pivot->priority === 'high' ? 'selected' : '' }}>Alta</option>
                                        <option value="medium" {{ $favorite->pivot->priority === 'medium' ? 'selected' : '' }}>Media</option>
                                        <option value="low" {{ $favorite->pivot->priority === 'low' ? 'selected' : '' }}>Baja</option>
                                    </select>
                                </div>

                                <!-- Botón de Actualizar -->
                                <div class="flex justify-start">
                                    <x-button type="submit">
                                        Actualizar
                                    </x-button>
                                </div>
                            </form>

                            <!-- Formulario de Eliminar -->
                            <form action="{{ route('favorites.destroy', $favorite->slug) }}" method="POST" class="mt-4">
                                @csrf
                                @method('DELETE')
                                <div class="flex justify-start">
                                    <button type="submit" class="px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Eliminar
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación al final del contenedor de favoritos -->
                <div class="mt-8">
                    {{ $favorites->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
