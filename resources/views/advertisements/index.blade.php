<x-app-layout>
    <div class="min-h-screen bg-gradient-to-r from-blue-50 to-gray-50 pt-20">
        <div class="container mx-auto px-4 py-0">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6">
                        @svg('heroicon-s-arrow-left', 'h-5 w-5 mr-2') <!-- Icono de flecha -->
                        <span class="text-sm font-medium">Volver al Panel de Control</span>
                    </a>
                    <div class="text-center mb-12">
                        <h2 class="text-4xl bg-clip-text font-bold text-transparent bg-gradient-to-r from-blue-600 to-purple-600">
                            @svg('heroicon-o-document-text', 'h-5 w-5 text-gray-500 mr-2')
                            Mis Anuncios
                        </h2>
                        <p class="mt-4 text-lg text-gray-600">
                            Gestiona tus anuncios publicados
                        </p>
                    </div>

                    <!-- Botón Crear Nuevo -->
                    <div class="mb-8 text-center">
                        <a href="{{ route('advertisements.create') }}"
                           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-colors">
                            @svg('heroicon-o-plus', 'h-5 w-5 mr-2')
                            Crear Nuevo Anuncio
                        </a>
                    </div>

                    <!-- Lista de Anuncios -->
                    <div class="grid grid-cols-1 gap-6">
                        @forelse($advertisements as $advertisement)
                            <div class="border-2 border-gray-100 rounded-xl p-6 hover:border-blue-200 transition-colors">
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800">{{ $advertisement->title }}</h3>
                                        <p class="mt-2 text-gray-600">{{ Str::limit($advertisement->description, 100) }}</p>
                                        <div class="mt-2 flex items-center text-sm text-gray-500">
                                            @svg('heroicon-o-map-pin', 'h-4 w-4 mr-1')
                                            {{ $advertisement->location }}
                                        </div>
                                        @if($advertisement->skills)
                                            <div class="mt-3 flex flex-wrap gap-2">
                                                @foreach($advertisement->skills as $skill)
                                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                                        {{ $skill }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <!-- Botón Ver -->
                                        <a href="{{ route('advertisements.show', $advertisement) }}"
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                            @svg('heroicon-o-eye', 'h-4 w-4 mr-1')
                                            Ver
                                        </a>
                                        <!-- Botón Editar -->
                                        <a href="{{ route('advertisements.edit', $advertisement) }}"
                                           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                                            @svg('heroicon-o-pencil', 'h-4 w-4 mr-1')
                                            Editar
                                        </a>
                                        <!-- Botón Borrar -->
                                        <form action="{{ route('advertisements.destroy', $advertisement) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors w-full"
                                                    onclick="return confirm('¿Estás seguro de que quieres eliminar este anuncio?')">
                                                @svg('heroicon-o-trash', 'h-4 w-4 mr-1')
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-600">No tienes anuncios publicados.</p>
                                <p class="mt-2 text-gray-500">¡Comienza creando tu primer anuncio!</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Paginación -->
                    <div class="mt-8">
                        {{ $advertisements->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
