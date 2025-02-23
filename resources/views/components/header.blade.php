<header class="bg-blue-600 py-2 shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <!-- Enlace con la imagen a la izquierda -->
            <a href="{{ route('welcome') }}" class="flex items-center">
                <img src="{{ asset('images/iconoWH.png') }}" alt="WorkHub Icon" class="h-20 w-20">
            </a>
            <!-- Contenedor para centrar el texto WorkHub y el icono WH -->
            <div class="flex items-center justify-center flex-grow">
                <!-- Texto WorkHub -->
                <h1 class="text-4xl font-bold text-white">
                    WorkHub
                </h1>
                <!-- Icono WH con animación bounce -->
                <div class="ml-4 animate-bounce">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" viewBox="0 0 100 100">
                        <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" font-size="48" font-weight="bold" fill="white">WH</text>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</header>
