<x-app-layout>
    <!-- Complemento header con fondo azul y texto centrado -->
    <x-main-navigation />
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
                        <input type="hidden" name="type" value="{{ auth()->user()->type }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Título -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700">Título del Anuncio</label>
                                <input id="title" name="title" type="text" required
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Ej: Desarrollador Web Frontend"
                                       value="{{ old('title') }}">
                                <x-input-error for="title" class="mt-2" />
                            </div>

                            <!-- Descripción -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                                <textarea id="description" name="description" rows="4" required
                                          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                          placeholder="Describe detalladamente el puesto o tus habilidades">{{ old('description') }}</textarea>
                                <x-input-error for="description" class="mt-2" />
                            </div>

                            <!-- Ubicación -->
                            <div class="md:col-span-2">
                                <label for="location" class="block text-sm font-medium text-gray-700">Ubicación</label>
                                <input id="location" name="location" type="text" required
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Ej: Madrid, España"
                                       value="{{ old('location') }}">
                                <x-input-error for="location" class="mt-2" />
                            </div>

                            <!-- Habilidades -->
                            <div class="md:col-span-2">
                                <label for="skills" class="block text-sm font-medium text-gray-700">Habilidades (separadas por comas)</label>
                                <input id="skills" name="skills" type="text"
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Ej: HTML, CSS, JavaScript"
                                       value="{{ old('skills') }}">
                                <x-input-error for="skills" class="mt-2" />
                            </div>

                            <!-- Experiencia -->
                            <div class="md:col-span-2">
                                <label for="experience" class="block text-sm font-medium text-gray-700">Experiencia Requerida</label>
                                <input id="experience" name="experience" type="text"
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Ej: 2 años de experiencia en desarrollo web"
                                       value="{{ old('experience') }}">
                                <x-input-error for="experience" class="mt-2" />
                            </div>

                            @if(auth()->user()->type === 'employer')
                                <!-- Campos específicos para empleador -->
                                <div>
                                    <label for="schedule" class="block text-sm font-medium text-gray-700">Horario</label>
                                    <input id="schedule" name="schedule" type="text" required
                                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                           placeholder="Ej: Tiempo completo, Media jornada"
                                           value="{{ old('schedule') }}">
                                    <x-input-error for="schedule" class="mt-2" />
                                </div>

                                <div>
                                    <label for="contract_type" class="block text-sm font-medium text-gray-700">Tipo de Contrato</label>
                                    <input id="contract_type" name="contract_type" type="text" required
                                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                           placeholder="Ej: Indefinido, Temporal"
                                           value="{{ old('contract_type') }}">
                                    <x-input-error for="contract_type" class="mt-2" />
                                </div>

                                <div class="md:col-span-2">
                                    <label for="salary" class="block text-sm font-medium text-gray-700">Salario (€/año)</label>
                                    <input id="salary" name="salary" type="number" step="0.01"
                                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                           placeholder="Ej: 30000"
                                           value="{{ old('salary') }}">
                                    <x-input-error for="salary" class="mt-2" />
                                </div>
                            @else
                                <!-- Campos específicos para trabajador -->
                                <div>
                                    <label for="availability" class="block text-sm font-medium text-gray-700">Disponibilidad</label>
                                    <input id="availability" name="availability" type="text" required
                                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                           placeholder="Ej: Inmediata, En 2 semanas"
                                           value="{{ old('availability') }}">
                                    <x-input-error for="availability" class="mt-2" />
                                </div>

                                <div>
                                    <label for="salary_expectation" class="block text-sm font-medium text-gray-700">Expectativa Salarial (€/año)</label>
                                    <input id="salary_expectation" name="salary_expectation" type="number" step="0.01"
                                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                           placeholder="Ej: 25000"
                                           value="{{ old('salary_expectation') }}">
                                    <x-input-error for="salary_expectation" class="mt-2" />
                                </div>
                            @endif
                        </div>

                        <!-- Botón de publicación -->
                        <div class="mt-8">
                            <button type="submit"
                                    class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transform transition-transform duration-300 hover:scale-105 hover:animate-pulse hover:ring-yellow-400 hover:ring-4">
                                Publicar Anuncio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
