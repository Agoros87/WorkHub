<x-app-layout>
    @if (session('success'))
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-20">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif
    <div class="min-h-screen bg-gradient-to-r from-blue-50 to-gray-50 pt-16">
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
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
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

                        <!-- Mis Favoritos -->
                        <div class="group transform transition-transform duration-300 hover:scale-105">
                            <a href="{{ route('favorites.index') }}" class="block">
                                <div class="border-2 border-gray-100 rounded-xl p-8 transition-all duration-500 group-hover:bg-gradient-to-r group-hover:from-blue-50 group-hover:to-blue-400">
                                    <div class="flex items-center justify-center mb-4">
                                        @svg('heroicon-o-heart', 'h-12 w-12 text-blue-600 transform transition-transform duration-300 group-hover:rotate-12')
                                    </div>
                                    <h3 class="text-xl font-semibold text-center text-gray-800">Mis Favoritos</h3>
                                    <p class="mt-2 text-center text-gray-600">Gestiona tus anuncios favoritos</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Aplicaciones Recibidas -->
                    <div class="border-2 border-gray-100 rounded-xl p-8 mt-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            @svg('heroicon-o-inbox-arrow-down', 'h-6 w-6 mr-2')
                            Últimas Aplicaciones Recibidas
                        </h3>

                        @if($receivedApplications->isEmpty())
                            <p class="text-gray-600 text-center py-4">No hay aplicaciones recibidas para mostrar</p>
                        @else
                            <div class="space-y-4">
                                @foreach($receivedApplications as $application)
                                    <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-semibold text-lg text-gray-800">
                                                    {{ $application->user->name ?? $application->user->company_name}}
                                                    <span class="text-sm text-gray-600">
                                                        aplicó a {{ $application->advertisement->title }}
                                                    </span>
                                                </h4>
                                                <p class="text-sm text-gray-600">
                                                    {{ $application->created_at->format('d/m/Y H:i') }}
                                                </p>
                                            </div>
                                            <div class="flex space-x-2">
                                                <span class="px-3 py-1 rounded-full text-xs
                                                    @if($application->status == 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($application->status == 'accepted') bg-green-100 text-green-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ __($application->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mt-2 flex justify-between items-center">
                                            <span class="text-sm text-gray-600">
                                                {{ $application->messages->count() }} mensajes
                                            </span>
                                            <div class="flex flex-col items-end space-y-2">
                                                <a href="{{ route('job-applications.show', $application) }}"
                                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    Ver detalles →
                                                </a>
                                                <form action="{{ route('job-applications.destroy', $application) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta aplicación?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Aplicaciones Enviadas -->
                    <div class="border-2 border-gray-100 rounded-xl p-8 mt-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            @svg('heroicon-o-paper-airplane', 'h-6 w-6 mr-2')
                            Mis Aplicaciones Enviadas
                        </h3>

                        @if($sentApplications->isEmpty())
                            <p class="text-gray-600 text-center py-4">No has enviado ninguna aplicación</p>
                        @else
                            <div class="space-y-4">
                                @foreach($sentApplications as $application)
                                    <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-semibold text-lg text-gray-800">
                                                    {{ $application->advertisement->title }}
                                                    <span class="text-sm text-gray-600">
                                                        de {{ $application->user->name ?? $application->user->company_name}}
                                                    </span>
                                                </h4>
                                                <p class="text-sm text-gray-600">
                                                    {{ $application->created_at->format('d/m/Y H:i') }}
                                                </p>
                                            </div>
                                            <div class="flex space-x-2">
                                                <span class="px-3 py-1 rounded-full text-xs
                                                    @if($application->status == 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($application->status == 'accepted') bg-green-100 text-green-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ __($application->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mt-2 flex justify-between items-center">
                                            <span class="text-sm text-gray-600">
                                                {{ $application->messages->count() }} mensajes
                                            </span>
                                            <div class="flex flex-col items-end space-y-2">
                                                <a href="{{ route('job-applications.show', $application) }}"
                                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    Ver detalles →
                                                </a>
                                                <form action="{{ route('job-applications.destroy', $application) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta aplicación?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Estadísticas -->
                    <div class="border-2 border-gray-100 rounded-xl p-8 mt-8">
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

                            <!-- Total de Aplicaciones Recibidas -->
                            <div class="bg-green-50 rounded-lg p-6">
                                <div class="flex items-center justify-center mb-2">
                                    @svg('heroicon-o-inbox-arrow-down', 'h-8 w-8 text-green-600')
                                </div>
                                <p class="text-center text-2xl font-bold text-gray-800">
                                    {{ $totalReceivedApplications }}
                                </p>
                                <p class="text-center text-gray-600">Aplicaciones Recibidas</p>
                            </div>

                            <!-- Total de Aplicaciones Enviadas -->
                            <div class="bg-purple-50 rounded-lg p-6">
                                <div class="flex items-center justify-center mb-2">
                                    @svg('heroicon-o-paper-airplane', 'h-8 w-8 text-purple-600')
                                </div>
                                <p class="text-center text-2xl font-bold text-gray-800">
                                    {{ $totalSentApplications }}
                                </p>
                                <p class="text-center text-gray-600">Aplicaciones Enviadas</p>
                            </div>

                            <!-- Total de Favoritos -->
                            <div class="bg-red-50 rounded-lg p-6">
                                <div class="flex items-center justify-center mb-2">
                                    @svg('heroicon-o-heart', 'h-8 w-8 text-red-600')
                                </div>
                                <p class="text-center text-2xl font-bold text-gray-800">
                                    {{ $totalFavorites }}
                                </p>
                                <p class="text-center text-gray-600">Anuncios Favoritos</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
