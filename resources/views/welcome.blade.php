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
<body class="relative bg-[url('/images/backgrounds/mifoto.svg')] bg-no-repeat bg-[length:350px_250px]">

<x-main-navigation />

<!-- Mensaje Flash de Éxito -->
@if(session('success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-16"
        role="alert">
        <strong class="font-bold">Éxito!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
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
            <img src="/images/backgrounds/mifoto.svg" alt="WorkHub" class="w-72 h-72 rounded-lg shadow-lg">
        </div>
    </div>
</section>

<main class="main-content">
    <div class="container mx-auto py-6 px-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Anuncios</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 justify-items-center">
            @foreach($advertisements as $advertisement)
                <a href="{{ route('advertisements.show', $advertisement) }}" class="block w-full max-w-sm">
                    <div class="bg-gradient-to-r from-purple-100 to-indigo-200 p-6 rounded-lg shadow-lg hover:shadow-2xl transform hover:scale-105 transition-transform duration-300">
                        <h2 class="text-2xl font-extrabold text-gray-900 break-words">{{ $advertisement->title }}</h2>
                        <p class="text-gray-700 mt-2 break-words">{{ $advertisement->description }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</main>

<x-footer />

</body>
</html>
