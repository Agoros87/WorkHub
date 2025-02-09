<x-app-layout>
    <div class="min-h-screen bg-gradient-to-r from-blue-50 to-gray-50 pt-20">
        <div class="container mx-auto px-4 py-0">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl font-bold text-gray-800">
                            @svg('heroicon-o-home', 'h-5 w-5 text-gray-500 mr-2')
                            Panel de Control
                        </h2>
                        <p class="mt-4 text-lg text-gray-600">
                            Bienvenido a tu espacio personal en WorkHub
                        </p>
                    </div>

                    <!-- Grid de Accesos Rápidos -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                        <!-- Mis Anuncios -->
                        <div class="group transform transition-transform duration-300 hover:scale-105">
                            <a href="{{ route('advertisements.index') }}" class="block">
                                <div class="border-2 border-gray-100 rounded-xl p-8 transition-all duration-500 group-hover:bg-gradient-to-r group-hover:from-blue-50 group-hover:to-blue-400">
                                    <div class="flex items-center justify-center mb-4">
                                        @svg('heroicon-o-document-text', 'h-12 w-12 text-blue-600 transform transition-transform duration-300 group-hover:rotate-12')
                                    </div>
                                    <h3 class="text-xl font-semibold text-center text-gray-800">Mis Anuncios</h3>
                                    <p class="mt-2 text-center text-gray-600">Gestiona tus anuncios publicados</p>
                                </div>
                            </a>
                        </div>

                        <!-- Búsqueda -->
                        <div class="group transform transition-transform duration-300 hover:scale-105">
                            <a href="{{ route('search') }}" class="block">
                                <div class="border-2 border-gray-100 rounded-xl p-8 transition-all duration-500 group-hover:bg-gradient-to-r group-hover:from-blue-50 group-hover:to-blue-400">
                                    <div class="flex items-center justify-center mb-4">
                                        @svg('heroicon-o-magnifying-glass', 'h-12 w-12 text-blue-600 transform transition-transform duration-300 group-hover:rotate-12')
                                    </div>
                                    <h3 class="text-xl font-semibold text-center text-gray-800">Buscar</h3>
                                    <p class="mt-2 text-center text-gray-600">
                                        {{ $dependsOfTypeText }}
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Estadísticas -->
                    <div class="border-2 border-gray-100 rounded-xl p-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            @svg('heroicon-o-chart-bar', 'h-6 w-6 mr-2')
                            Resumen
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Total de Anuncios -->
                            <div class="bg-blue-50 rounded-lg p-6">
                                <div class="flex items-center justify-center mb-2">
                                    @svg('heroicon-o-document-text', 'h-8 w-8 text-blue-600')
                                </div>
                                <p class="text-center text-2xl font-bold text-gray-800">
                                    {{ $totalAds }}
                                </p>
                                <p class="text-center text-gray-600">Anuncios Publicados</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
