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
                @auth
                    @if(auth()->user()->type === 'worker')
                        <a href="{{ url('/buscar') }}" class="hover:text-blue-300">Buscar Trabajo</a>
                    @elseif(auth()->user()->type === 'employer')
                        <a href="{{ url('/buscar') }}" class="hover:text-blue-300">Buscar Empleados</a>
                    @endif
                    <a href="{{ route('advertisements.create') }}" class="hover:text-blue-300">Publicar Oferta</a>
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
                <a href="{{ route('select-role') }}" class="hover:text-blue-300">Registrarse</a>
            </nav>
        @endguest

        <!-- Dropdown Menu for Authenticated Users -->
        @auth
            <x-dropdown-menu />
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
            @auth
                @if(auth()->user()->type === 'worker')
                    <a href="{{ url('/buscar') }}" class="hover:text-blue-300">Buscar Trabajo</a>
                @elseif(auth()->user()->type === 'employer')
                    <a href="{{ url('/buscar') }}" class="hover:text-blue-300">Buscar Empleados</a>
                @endif
                <a href="{{ route('advertisements.create') }}" class="hover:text-blue-300">Publicar Oferta</a>
            @endauth
            <a href="{{ url('/contacto') }}" class="hover:text-blue-300">Contacto</a>
            <!-- Login y Register para invitados -->
            @guest
                <a href="{{ route('login') }}" class="hover:text-blue-300">Inicio Sesión</a>
                <a href="{{ route('select-role') }}" class="hover:text-blue-300">Registrarse</a>
            @endguest
        </nav>
    </div>
</header>

@push('scripts')
    <script>
        // Menú móvil toggle
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
@endpush
