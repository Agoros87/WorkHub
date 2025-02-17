<div>
    <div class="min-h-screen bg-gradient-to-r from-blue-50 to-gray-50 pt-20">
        <div class="container mx-auto px-4 py-0">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl font-bold text-gray-800">
                            @svg('heroicon-o-map-pin', 'h-5 w-5 text-gray-500 mr-2')
                            {{ auth()->check() ? (auth()->user()->type == 'employer' ? 'Buscar Camareros' : 'Buscar Trabajo de Camarero') : 'Buscar Anuncios' }}
                        </h2>
                        <p class="mt-4 text-lg text-gray-600">
                            {{ auth()->check() ? (auth()->user()->type == 'employer' ? 'Utiliza los filtros para encontrar personal de hostelería' : 'Utiliza los filtros para encontrar trabajo en hostelería') : 'Utiliza los filtros para encontrar anuncios de hostelería' }}
                        </p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6">
                        @svg('heroicon-s-arrow-left', 'h-5 w-5 mr-2') <!-- Icono de flecha -->
                        <span class="text-sm font-medium">Volver al Panel de Control</span>
                    </a>
                    <!-- Formulario de Búsqueda -->
                    <div class="grid grid-cols-1 gap-8">
                        <!-- Filtro de Palabra Clave -->
                        <div class="group">
                            <div class="border-2 border-gray-100 rounded-xl p-8">
                                <label for="search-keyword" class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                    @svg('heroicon-o-magnifying-glass', 'h-5 w-5 mr-2')
                                    Palabra Clave
                                </label>
                                <input wire:model.live.debounce.300ms="keyword" id="search-keyword" type="text"
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
                            <select wire:model.live="location" id="search-location" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300" style="max-height: 200px; overflow-y: auto;">
                                <option value="">Selecciona una ubicación</option>
                                @foreach($locations as $city)
                                    <option value="{{ $city }}">{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filtro de Categorías -->
                        <div class="group">
                            <div class="border-2 border-gray-100 rounded-xl p-8">
                                <span class="flex items-center text-sm font-medium text-gray-700 mb-4">
                                    @svg('heroicon-o-briefcase', 'h-5 w-5 mr-2')
                                    Tipos de Puesto
                                </span>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach (config('skills') as $skill)
                                        @php $id = Str::slug($skill); @endphp
                                        <label for="category-{{ $id }}" class="flex items-center space-x-3 cursor-pointer">
                                            <input type="checkbox" wire:model.live="selectedCategories" value="{{ $skill }}"
                                                   id="category-{{ $id }}"
                                                   class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                            <span class="text-gray-700">{{ $skill }}</span>
                                        </label>
                                    @endforeach
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

                        <div class="mt-8">
                            <div class="flex justify-between items-center mb-4">
                                <p class="text-gray-600">
                                    Mostrando {{ $results->firstItem() ?? 0 }} - {{ $results->lastItem() ?? 0 }} de {{ $total }} resultados
                                </p>
                            </div>
                            {{ $results->onEachSide(2)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
