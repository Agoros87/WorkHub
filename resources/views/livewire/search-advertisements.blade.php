<div>
    <div class="min-h-screen bg-gradient-to-r from-blue-50 to-gray-50 pt-20">
        <div class="container mx-auto px-4 py-0">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl font-bold text-gray-800">
                            @svg('heroicon-o-map-pin', 'h-5 w-5 text-gray-500 mr-2')
                            Buscar {{ auth()->check() && auth()->user()->role == 'employer' ? 'Camareros' : 'Trabajo de Camarero' }}
                        </h2>
                        <p class="mt-4 text-lg text-gray-600">
                            Utiliza los filtros para encontrar {{ auth()->check() && auth()->user()->role == 'employer' ? 'el personal de hostelería' : 'el trabajo en hostelería' }} que mejor se ajuste a tus necesidades
                        </p>
                    </div>

                    <!-- Formulario de Búsqueda -->
                    <div class="grid grid-cols-1 gap-8">
                        <!-- Filtro de Palabra Clave -->
                        <div class="group">
                            <div class="border-2 border-gray-100 rounded-xl p-8">
                                <label for="search-keyword" class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                    @svg('heroicon-o-magnifying-glass', 'h-5 w-5 mr-2')
                                    Palabra Clave
                                </label>
                                <input wire:model.debounce.300ms="keyword" id="search-keyword" type="text"
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Ej: Camarero de sala, Barman">
                            </div>
                        </div>

                        <!-- Filtro de Ubicación -->
                        <div>
                            <label for="search-location" class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                @svg('heroicon-o-map-pin', 'h-5 w-5 mr-2')
                                Ubicación
                            </label>
                            <input wire:model="location" list="location-list" id="search-location"
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                   placeholder="Ej: Madrid, Barcelona">
                            <datalist id="location-list" style="max-height: 150px; overflow-y: auto;">
                                @foreach($locations as $city)
                                    <option value="{{ $city }}">{{ $city }}</option>
                                @endforeach
                            </datalist>
                        </div>

                        <!-- Filtro de Categorías -->
                        <div class="group">
                            <div class="border-2 border-gray-100 rounded-xl p-8">
                                <span class="flex items-center text-sm font-medium text-gray-700 mb-4">
                                    @svg('heroicon-o-briefcase', 'h-5 w-5 mr-2')
                                    Tipos de Puesto
                                </span>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <label for="category-barra" class="flex items-center space-x-3 cursor-pointer">
                                        <input type="checkbox" wire:model="selectedCategories" value="camarero_barra"
                                               id="category-barra"
                                               class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="text-gray-700">Camarero de barra</span>
                                    </label>
                                    <label for="category-sala" class="flex items-center space-x-3 cursor-pointer">
                                        <input type="checkbox" wire:model="selectedCategories" value="camarero_sala"
                                               id="category-sala"
                                               class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="text-gray-700">Camarero de sala</span>
                                    </label>
                                    <label for="category-ayudante" class="flex items-center space-x-3 cursor-pointer">
                                        <input type="checkbox" wire:model="selectedCategories" value="ayudante_camarero"
                                               id="category-ayudante"
                                               class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="text-gray-700">Ayudante de camarero</span>
                                    </label>
                                    <label for="category-barman" class="flex items-center space-x-3 cursor-pointer">
                                        <input type="checkbox" wire:model="selectedCategories" value="barman"
                                               id="category-barman"
                                               class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="text-gray-700">Barman / Coctelero</span>
                                    </label>
                                    <label for="category-eventos" class="flex items-center space-x-3 cursor-pointer">
                                        <input type="checkbox" wire:model="selectedCategories" value="camarero_eventos"
                                               id="category-eventos"
                                               class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="text-gray-700">Camarero de eventos</span>
                                    </label>
                                    <label for="category-barista" class="flex items-center space-x-3 cursor-pointer">
                                        <input type="checkbox" wire:model="selectedCategories" value="barista"
                                               id="category-barista"
                                               class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="text-gray-700">Barista</span>
                                    </label>
                                    <label for="category-encargado" class="flex items-center space-x-3 cursor-pointer">
                                        <input type="checkbox" wire:model="selectedCategories" value="encargado_sala"
                                               id="category-encargado"
                                               class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="text-gray-700">Encargado de sala</span>
                                    </label>
                                    <label for="category-catering" class="flex items-center space-x-3 cursor-pointer">
                                        <input type="checkbox" wire:model="selectedCategories" value="personal_catering"
                                               id="category-catering"
                                               class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="text-gray-700">Personal de catering</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resultados de la Búsqueda con Loading States -->
                    <div class="mt-12">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            @svg('heroicon-o-rectangle-stack', 'h-6 w-6 mr-2')
                            Resultados
                        </h3>

                        <div wire:loading class="text-center py-4">
                            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                            <p class="mt-2 text-gray-600">Buscando...</p>
                        </div>

                        <div wire:loading.remove class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @forelse($results as $result)
                                <div class="group transform transition-transform duration-300 hover:scale-105">
                                    <div class="border-2 border-gray-100 rounded-xl p-8">
                                        <h4 class="text-xl font-semibold text-gray-800">{{ $result->title }}</h4>
                                        <p class="mt-2 text-gray-600">{{ Str::limit($result->description, 100) }}</p>
                                        <div class="mt-4 flex items-center text-sm text-gray-500">
                                            @svg('heroicon-o-map-pin', 'h-4 w-4 mr-1')
                                            {{ $result->location }}
                                        </div>
                                        @if($result->skills)
                                            <div class="mt-4 flex flex-wrap gap-2">
                                                @foreach($result->skills as $skill)
                                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                                        {{ $skill }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                        <a href="{{ route('advertisements.show', $result) }}"
                                           class="inline-block mt-4 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transform transition-transform duration-300 hover:scale-105 hover:animate-pulse hover:ring-yellow-400 hover:ring-4">
                                            Ver Detalles
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-2 text-center py-8">
                                    <p class="text-gray-600">No se encontraron resultados para tu búsqueda.</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-8" wire:ignore>
                            {{ $results->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
