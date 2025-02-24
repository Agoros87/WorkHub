<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<x-main-navigation />

@if (session('success'))
    <div class="w-full bg-green-100 border border-green-400 text-green-700 px-4 py-3 mt-16" role="alert">
        <div class="container mx-auto">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    </div>
@endif

<section class="bg-gradient-to-r from-[#A5B4FC] to-[#818CF8] py-32 px-8">
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-center">
        <div class="text-center md:text-left mb-6 md:mb-0">
            <h1 class="font-poppins text-7xl font-bold bg-gradient-to-r from-[#FF6B6B] to-[#FFE66D] bg-clip-text text-transparent shadow-[2px_2px_4px_rgba(0,0,0,0.2)] mb-6">
                WorkHub
            </h1>
            <p class="text-white text-2xl leading-snug mt-4">
                La unión perfecta <br>
                <span class="text-yellow-300 font-bold italic">entre la búsqueda de talento</span> <br>
                hostelero y oportunidades de trabajo.
            </p>
        </div>
        <div class="mt-10 md:mt-0 md:ml-64">
            <x-main-photo />
        </div>
    </div>
</section>

<main class="main-content">
    <div class="container mx-auto py-12 px-6">
        <!-- Encabezado con animación de transformación y movimiento -->
        <h1 class="text-4xl font-extrabold text-gray-800 mb-10 text-center transform transition-all duration-500 hover:scale-110 hover:text-indigo-600 hover:translate-x-4">
            Anuncios más recientes
        </h1>

        <!-- Contenedor de dos columnas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Columna de Trabajadores -->
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center transform transition-all duration-500 hover:text-indigo-600 hover:translate-y-2 hover:scale-105">
                    Anuncios para empresas
                </h2>
                @foreach($workerAdvertisements as $advertisement)
                    <a href="{{ route('advertisements.show', $advertisement) }}" class="block w-full mb-6">
                        <div class="bg-gradient-to-r from-purple-100 to-indigo-200 p-6 rounded-lg shadow-lg hover:shadow-2xl transform hover:scale-105 transition-transform duration-300 w-full max-w-sm mx-auto h-full flex flex-col">
                            <h3 class="text-xl font-extrabold text-gray-900 break-words flex-grow transform transition-transform duration-500 hover:translate-y-2">
                                {{ $advertisement->title }}
                            </h3>
                            <p class="text-gray-700 mt-2 break-words flex-grow transform transition-transform duration-300 hover:translate-x-2">
                                {{ $advertisement->description }}
                            </p>
                            <p class="text-sm text-gray-500 mt-2">Publicado el: {{ $advertisement->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Columna de Empleadores -->
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center transform transition-all duration-500 hover:text-indigo-600 hover:translate-y-2 hover:scale-105">
                    Anuncios de trabajo
                </h2>
                @foreach($employerAdvertisements as $advertisement)
                    <a href="{{ route('advertisements.show', $advertisement) }}" class="block w-full mb-6">
                        <div class="bg-gradient-to-r from-purple-100 to-indigo-200 p-6 rounded-lg shadow-lg hover:shadow-2xl transform hover:scale-105 transition-transform duration-300 w-full max-w-sm mx-auto h-full flex flex-col">
                            <h3 class="text-xl font-extrabold text-gray-900 break-words flex-grow transform transition-transform duration-500 hover:translate-y-2">
                                {{ $advertisement->title }}
                            </h3>
                            <p class="text-gray-700 mt-2 break-words flex-grow transform transition-transform duration-300 hover:translate-x-2">
                                {{ $advertisement->description }}
                            </p>
                            <p class="text-sm text-gray-500 mt-2">Publicado el: {{ $advertisement->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Paginación de anuncios -->
        <div class="mt-6">
            <div class="flex justify-between">
                <div>
                    {{ $workerAdvertisements->links() }}
                </div>
            </div>
        </div>
    </div>
</main>
<x-footer />

</body>
</html>
