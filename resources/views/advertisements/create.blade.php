<x-app-layout>
    <!-- Contenido principal -->
    <div class="min-h-screen bg-gradient-to-r from-blue-50 to-gray-50 pt-8">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                <!-- Encabezado del formulario -->
                <div class="text-center mb-8">
                    <h2 class="mt-0 text-4xl font-bold text-gray-800">
                        {{ auth()->user()->type === 'employer' ? 'Publicar Oferta de Trabajo' : 'Publicar Búsqueda de Empleo' }}
                    </h2>
                    <p class="mt-2 text-lg text-gray-600">
                        {{ auth()->user()->type === 'employer' ? 'Completa el formulario para publicar tu oferta de trabajo' : 'Completa el formulario para publicar tu búsqueda de empleo' }}
                    </p>
                </div>

                <!-- Mensaje de error personalizado -->
                @if ($errors->any())
                <div class="bg-red-600 p-4 text-xl text-red-50 dark:bg-red-800 mb-6 rounded-lg">
                    Por favor, corrige los errores en el formulario.
                </div>
                @endif

                <!-- Formulario de publicación -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <form class="space-y-6" action="{{ route('advertisements.store') }}" method="POST">
                        @csrf
                        <!-- Formulario -->
                        <x-advertisement-form/>

                        <!-- Botón de publicación -->
                        <x-custom-button>Publicar Anuncio</x-custom-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
