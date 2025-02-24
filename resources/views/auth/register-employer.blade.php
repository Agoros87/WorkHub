<x-guest-layout>
    <!-- Contenido principal -->
    <div class="min-h-screen bg-gradient-to-r from-blue-50 to-gray-50 pt-8">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                <!-- Encabezado del formulario -->
                <div class="text-center mb-8">
                    <h2 class="mt-0 text-4xl bg-clip-text font-bold text-transparent bg-gradient-to-r from-blue-600 to-purple-600">
                        Registro del Empleador
                    </h2>
                    <p class="mt-2 text-lg text-gray-600">
                        Completa el formulario para crear tu perfil de empresa en WorkHub
                    </p>
                </div>

                <!-- Mensaje de error personalizado -->
                @session('error')
                <div class="bg-red-600 p-4 text-xl text-red-50 dark:bg-red-800 mb-6 rounded-lg">
                    {{ $value }}
                </div>
                @endsession

                <!-- Formulario de registro -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <form class="space-y-6" action="{{ route('register') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="employer">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre de la empresa -->
                            <div class="md:col-span-2">
                                <label for="company_name" class="block text-sm font-medium text-gray-700">Nombre de la empresa</label>
                                <input id="company_name" name="company_name" type="text" autocomplete="company_name" required
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Nombre de la empresa"
                                       value="{{ old('company_name') }}">
                                <x-input-error for="company_name" class="mt-2" />
                            </div>
                            <!-- Teléfono de contacto -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono de contacto</label>
                                <input id="phone" name="phone" type="tel" autocomplete="phone" required
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Teléfono de contacto"
                                       value="{{ old('phone') }}">
                                <x-input-error for="phone" class="mt-2" />
                            </div>
                            <!-- Identificador fiscal (C.I.F o N.I.F) -->
                            <div>
                                <label for="tax_id" class="block text-sm font-medium text-gray-700">Identificador fiscal (C.I.F o N.I.F)</label>
                                <input id="tax_id" name="tax_id" type="text" autocomplete="tax_id" required
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="C.I.F o N.I.F"
                                       value="{{ old('tax_id') }}">
                                <x-input-error for="tax_id" class="mt-2" />
                            </div>
                            <!-- Población -->
                            <div class="md:col-span-2">
                                <label for="location" class="block text-sm font-medium text-gray-700">Población</label>
                                <select id="location" name="location" autocomplete="location" required
                                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                                    <option value="" disabled selected>Selecciona tu población</option>
                                    @foreach (config('locations') as $location)
                                        <option value="{{ $location }}" {{ old('location') == $location ? 'selected' : '' }}>
                                            {{ $location }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error for="location" class="mt-2" />
                            </div>
                            <!-- Correo electrónico -->
                            <div class="md:col-span-2">
                                <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                                <input id="email" name="email" type="email" autocomplete="email" required
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Correo electrónico"
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
