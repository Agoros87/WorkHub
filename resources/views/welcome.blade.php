<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <style>
        body {
            background-image: url('/images/backgrounds/foto2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }
        .main-content {
            padding-top: 70px; /* Altura del header para que el contenido no se superponga */
        }
    </style>
</head>
<body class="relative">
<header class="bg-blue-600/80 text-white fixed w-full z-10 top-0">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <!-- Logo y menú izquierdo -->
        <div class="flex items-center space-x-8">
            <!-- Logo -->
            <div class="text-2xl font-bold">
                <a href="{{ url('/') }}" class="hover:text-blue-300">WorkHub</a>
            </div>

            <!-- Navigation -->
            <nav class="hidden md:flex space-x-6">
                <a href="{{ url('/') }}" class="hover:text-blue-300">Inicio</a>
                <a href="{{ url('/buscar') }}" class="hover:text-blue-300">Buscar Trabajo</a>
                @auth
                    <a href="{{ url('/publicar') }}" class="hover:text-blue-300">Publicar Oferta</a>
                    <a href="{{ url('/contacto') }}" class="hover:text-blue-300">Contacto</a>
                @else
                    <a href="{{ url('/contacto') }}" class="hover:text-blue-300">Contacto</a>
                @endauth
            </nav>
        </div>

        <!-- Login y Register para invitados -->
        @guest
            <nav class="hidden md:flex space-x-6">
                <a href="{{ route('login') }}" class="hover:text-blue-300">Inicio de Sesión</a>
                <a href="{{ route('register') }}" class="hover:text-blue-300">Registrarse</a>
            </nav>
        @endguest

        <!-- Dropdown Menu for Authenticated Users -->
        @auth
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2">
                    <span>{{ Auth::user()->name }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20">
                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Perfil</a>
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <a href="{{ route('logout') }}"
                           @click.prevent="$root.submit();" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">
                            Cerrar Sesión
                        </a>
                    </form>
                </div>
            </div>
        @endauth

        <!-- Mobile Menu Button -->
        <div class="md:hidden">
            <button id="menu-btn" class="text-white focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-blue-700">
        <nav class="flex flex-col space-y-2 py-4 px-6">
            <a href="{{ url('/') }}" class="hover:text-blue-300">Inicio</a>
            <a href="{{ url('/buscar') }}" class="hover:text-blue-300">Buscar Trabajo</a>
            @auth
                <a href="{{ url('/publicar') }}" class="hover:text-blue-300">Publicar Oferta</a>
                <a href="{{ url('/contacto') }}" class="hover:text-blue-300">Contacto</a>
            @else
                <a href="{{ url('/contacto') }}" class="hover:text-blue-300">Contacto</a>
            @endauth
            <!-- Login y Register para invitados -->
            @guest
                <a href="{{ route('login') }}" class="hover:text-blue-300">Inicio Sesión</a>
                <a href="{{ route('register') }}" class="hover:text-blue-300">Registrarse</a>
            @endguest
        </nav>
    </div>
</header>

<main class="main-content">
    <!-- Aquí va el contenido principal de tu página -->
    <div class="container mx-auto py-6 px-6">
        <h1 class="text-3xl font-bold text-white">Anuncios</h1>
        @foreach($advertisements as $advertisement)
            <div class="bg-white p-4 rounded shadow mb-4">
                <h2 class="text-xl font-bold">{{ $advertisement->title }}</h2>
                <p>{{ $advertisement->description }}</p>
            </div>
        @endforeach
    </div>
</main>

<script>
    // Menú móvil toggle
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
</body>
</html>










