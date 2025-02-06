<x-app-layout>
    <!-- Contenido principal -->
    <div class="min-h-screen bg-gradient-to-r from-blue-50 to-gray-50 pt-8">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                <!-- Encabezado del formulario -->
                <div class="text-center mb-8">
                    <h2 class="mt-0 text-4xl font-bold text-gray-800">
                        @if(auth()->user()->hasRole('admin'))
                            {{ $advertisement->type === 'employer' ? 'Editar Oferta de Trabajo' : 'Editar Búsqueda de Empleo' }}
                        @else
                            {{ auth()->user()->type === 'employer' ? 'Editar Oferta de Trabajo' : 'Editar Búsqueda de Empleo' }}
                        @endif
                    </h2>
                    <p class="mt-2 text-lg text-gray-600">Modifica los campos que desees actualizar</p>
                </div>

                <!-- Mensaje de error personalizado -->
                @if ($errors->any())
                    <div class="bg-red-600 p-4 text-xl text-red-50 dark:bg-red-800 mb-6 rounded-lg">
                        Por favor, corrige los errores en el formulario.
                    </div>
                @endif

                <!-- Formulario de edición -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <form class="space-y-6" action="{{ route('advertisements.update', $advertisement->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="type" value="{{ auth()->user()->hasRole('admin') ? $advertisement->type : auth()->user()->type }}">

                        <!-- Formulario -->
                        <x-advertisement-form :advertisement="$advertisement" />
                        <!-- Botón de actualización -->
                            <x-custom-button>Actualizar Anuncio</x-custom-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
