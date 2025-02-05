<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: url('/images/backgrounds/mifoto.svg');
            background-repeat: no-repeat;
            background-position: center 20%;
            background-size: 350px 250px;
        }
        .highlight-section {
            background: linear-gradient(90deg, #A5B4FC, #818CF8);
            padding: 8rem 2rem;
        }
        .footer {
            background-color: #1E293B;
            color: white;
            padding: 2rem 0;
        }
        .title {
            font-family: 'Poppins', sans-serif;
            font-size: 4.5rem;
            font-weight: 700;
            background: linear-gradient(90deg, #FF6B6B, #FFE66D);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="relative">

<x-main-navigation />

<section class="highlight-section">
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-center">
        <div class="text-center md:text-left mb-6 md:mb-0">
            <h1 class="title mb-6">WorkHub</h1>
            <p class="slogan mt-4 text-white text-2xl leading-snug">
                La unión perfecta <br>
                <span class="text-yellow-300 font-bold italic">entre la búsqueda de talento</span> <br>
                hostelero y oportunidades de trabajo.
            </p>
        </div>
        <div class="mt-10 md:mt-0 md:ml-64"> <!-- Aumenté el margen izquierdo a 16rem (256px) -->
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
                        <h2 class="text-2xl font-extrabold text-gray-900">{{ $advertisement->title }}</h2>
                        <p class="text-gray-700 mt-2">{{ $advertisement->description }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</main>

<footer class="footer">
    <div class="container mx-auto text-center">
        <div class="flex justify-center space-x-6 mb-4">
            <!-- SVG 1 -->
            <a href="#" class="text-white hover:text-gray-400">
                <svg width='40' height='40' viewBox='0 0 100 100' class="rounded hover:bg-white hover:*:fill-black hover:[&_path:last-child]:fill-white">
                <path d="M10 90 h10 L90 10 h-10 L10 90" fill="white" />
                    <path d="M10 10 h30 L90 90 h-30 L10 10" fill="white" />
                    <path d="M25 20 h10 L75 80 h-10 L25 20" fill="black" />
                </svg>
            </a>

            <!-- SVG 2 -->
            <a href="#" class="text-white hover:text-gray-400">
                <svg width="40" height="40" viewBox="0 0 100 100" class="hover:bg-gradient-to-b from-violet-500 via-pink-500 to-yellow-500 rounded-lg">
                    <path d="M35 15 h30 Q85 15, 85 35 v30 Q85 85, 65 85 h-30 Q15 85, 15 65 v-30 Q15 15, 35 15" fill="none" stroke="white" stroke-width="10" />
                    <circle cx="50" cy="50" r="18" fill="none" stroke="white" stroke-width="9" />
                    <circle cx="71" cy="29" r="5" fill="white" />
                </svg>
            </a>

            <!-- SVG 3 -->
            <a href="#" class="text-white hover:text-gray-400">
                <svg width="40" height="40" viewBox="0 0 50 50" class="rounded hover:bg-green-500 hover:[&_#punta]:fill-green-500">
                    <defs>
                        <path id="telefono" d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.11-.22 11.36 11.36 0 003.57 1.1 1 1 0 01.86 1v3.3a1 1 0 01-1 1A17 17 0 013 5a1 1 0 011-1h3.3a1 1 0 011 .86 11.36 11.36 0 001.1 3.57 1 1 0 01-.21 1.09l-2.2 2.2z" />
                    </defs>
                    <circle cx="25" cy="25" r="17" fill="none" stroke="white" stroke-width="4" />
                    <use href="#telefono" x="13" y="13" fill="white" />
                    <path d="M9 32 L7 43 L18 41" fill="white" />
                    <path id="punta" d="M13 32 L11 39 L18 37" class="fill-[#1E293B]" /> <!-- Cambiado fill-slate-900 por fill-[#1E293B] -->
                </svg>
            </a>

            <!-- Iconos de redes sociales existentes -->
            <a href="#" class="text-white hover:text-gray-400"><i class="fab fa-facebook"></i></a>
            <a href="#" class="text-white hover:text-gray-400"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white hover:text-gray-400"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-white hover:text-gray-400"><i class="fab fa-linkedin"></i></a>
        </div>
        <p class="text-sm text-gray-400">&copy; 2023 WorkHub. Todos los derechos reservados.</p>
    </div>
</footer>

@push('social-meta')
    <meta name="description" content="WorkHub es la plataforma líder para conectar talento hostelero con oportunidades de trabajo.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('welcome') }}">
    <meta property="og:title" content="WorkHub">
    <meta property="og:description" content="WorkHub es la plataforma líder para conectar talento hostelero con oportunidades de trabajo.">
    <meta name="twitter:card" content="summary_large_image">
@endpush

@stack('scripts')

</body>
</html>
