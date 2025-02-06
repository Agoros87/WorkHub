<x-guest-layout>
    <!-- Contenido principal -->
    <div class="min-h-screen bg-gradient-to-r from-blue-50 to-gray-50 pt-8"> <!-- Cambiado pt-12 a pt-8 -->
        <div class="container mx-auto px-4 py-8"> <!-- Cambiado py-12 a py-8 -->
            <div class="max-w-4xl mx-auto">
                <!-- Encabezado del formulario -->
                <div class="text-center mb-8"> <!-- Cambiado mb-12 a mb-8 -->
                    <h2 class="mt-0 text-4xl font-bold text-gray-800"> <!-- mt-0 para eliminar margen superior -->
                        Registro del Trabajador
                    </h2>
                    <p class="mt-2 text-lg text-gray-600"> <!-- Reducido mt-4 a mt-2 -->
                        Completa el formulario para crear tu perfil profesional en WorkHub
                    </p>
                </div>

                <!-- Mensaje de error personalizado -->
                @session('error')
                <div class="bg-red-600 p-4 text-xl text-red-50 dark:bg-red-800 mb-6 rounded-lg">
                    {{ $value }}
                </div>
                @endsession

                <!-- Formulario de registro -->
                <div class="bg-white rounded-xl shadow-lg p-6"> <!-- Cambiado p-8 a p-6 -->
                    <form class="space-y-6" action="{{ route('register') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="worker">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                                <input id="name" name="name" type="text" autocomplete="name" required
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Nombre"
                                       value="{{ old('name') }}">
                                <x-input-error for="name" class="mt-2" />
                            </div>
                            <!-- Apellidos -->
                            <div>
                                <label for="lastname" class="block text-sm font-medium text-gray-700">Apellidos</label>
                                <input id="lastname" name="lastname" type="text" autocomplete="lastname" required
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Apellidos"
                                       value="{{ old('lastname') }}">
                                <x-input-error for="lastname" class="mt-2" />
                            </div>
                            <!-- Fecha de Nacimiento -->
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
                                <input id="date_of_birth" name="date_of_birth" type="date" autocomplete="date_of_birth" required
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       value="{{ old('date_of_birth') }}">
                                <x-input-error for="date_of_birth" class="mt-2" />
                            </div>
                            <!-- Género -->
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700">Género</label>
                                <select id="gender" name="gender" required
                                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                                    <option value="" disabled selected>Selecciona tu género</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Masculino</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Femenino</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Otro</option>
                                </select>
                                <x-input-error for="gender" class="mt-2" />
                            </div>
                            <!-- Teléfono -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                                <input id="phone" name="phone" type="tel" autocomplete="phone" required
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Teléfono"
                                       value="{{ old('phone') }}">
                                <x-input-error for="phone" class="mt-2" />
                            </div>
                            <!-- Población -->
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">Población</label>
                                <input id="city" name="city" type="text" autocomplete="city" required
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Población"
                                       value="{{ old('city') }}">
                                <x-input-error for="city" class="mt-2" />
                            </div>
                            <!-- Email -->
                            <div class="md:col-span-2">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input id="email" name="email" type="email" autocomplete="email" required
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Email"
                                       value="{{ old('email') }}">
                                <x-input-error for="email" class="mt-2" />
                            </div>
                            <!-- Contraseña -->
                            <div class="md:col-span-2">
                                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                                <input id="password" name="password" type="password" autocomplete="new-password" required
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Contraseña">
                                <x-input-error for="password" class="mt-2" />
                            </div>
                            <!-- Confirmar Contraseña -->
                            <div class="md:col-span-2">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" required
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Confirmar Contraseña">
                                <x-input-error for="password_confirmation" class="mt-2" />
                            </div>
                        </div>

                        <!-- Términos y condiciones -->
                        <div class="mt-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="terms" class="form-checkbox h-4 w-4 text-blue-600" required {{ old('terms') ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">
                                    Acepto los <a href="{{ route('terms.show') }}" class="text-blue-600 hover:text-blue-500">términos y condiciones</a>
                                    y la <a href="{{ route('policy.show') }}" class="text-blue-600 hover:text-blue-500">política de privacidad</a>
                                </span>
                            </label>
                            <x-input-error for="terms" class="mt-2" />
                        </div>

                        <!-- Botón de registro -->
                        <div class="mt-8">
                            <button type="submit"
                                    class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transform transition-transform duration-300 hover:scale-105 hover:animate-pulse hover:ring-yellow-400 hover:ring-4">
                                Registrarse
                            </button>
                        </div>
                    </form>

                    <!-- Enlace para iniciar sesión -->
                    <div class="mt-6 text-center">
                        <p class="text-gray-600">
                            ¿Ya tienes una cuenta?
                            <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                                Inicia sesión
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
