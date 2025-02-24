<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-r from-blue-50 to-gray-50 pt-20">
        <div class="container mx-auto px-4 py-0">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl bg-clip-text font-bold text-transparent bg-gradient-to-r from-blue-600 to-purple-600">
                            Selecciona tu tipo de cuenta
                        </h2>
                        <p class="mt-4 text-lg text-gray-600">
                            Elige cómo quieres registrarte en WorkHub
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Opción Empleador -->
                        <div class="group transform transition-transform duration-300 hover:scale-105">
                            <div class="border-2 border-gray-100 rounded-xl p-8 transition-all duration-500 group-hover:bg-gradient-to-r group-hover:from-blue-50 group-hover:to-blue-400">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-blue-600 transform transition-transform duration-300 group-hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <h3 class="mt-6 text-2xl font-semibold text-gray-800">Empresa</h3>
                                    <p class="mt-4 text-gray-600 text-lg">
                                        Registra tu empresa y publica ofertas de trabajo para encontrar los mejores camareros
                                    </p>
                                    <div class="mt-6">
                                        <a href="{{ route('register.employer') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transform transition-transform duration-300 hover:scale-105 hover:animate-pulse hover:ring-yellow-400 hover:ring-4">
                                            Registrarse como empresa
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Opción Trabajador -->
                        <div class="group transform transition-transform duration-300 hover:scale-105">
                            <div class="border-2 border-gray-100 rounded-xl p-8 transition-all duration-500 group-hover:bg-gradient-to-r group-hover:from-blue-50 group-hover:to-blue-400">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-blue-600 transform transition-transform duration-300 group-hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <h3 class="mt-6 text-2xl font-semibold text-gray-800">Trabajador</h3>
                                    <p class="mt-4 text-gray-600 text-lg">
                                        Crea tu perfil profesional y encuentra las mejores ofertas de trabajo como camarero
                                    </p>
                                    <div class="mt-6">
                                        <a href="{{ route('register.worker') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transform transition-transform duration-300 hover:scale-105 hover:animate-pulse hover:ring-yellow-400 hover:ring-4">
                                            Registrarse como trabajador
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 text-center">
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
