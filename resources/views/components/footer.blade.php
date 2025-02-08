<footer class="footer bg-[#1E293B] text-white py-8 ">
    <div class="container mx-auto text-center">
        <div class="flex justify-center space-x-6 mb-4">
            <!-- SVG 1 -->
            <a href="#" class="text-white hover:text-gray-400">
                <svg width='40' height='40' viewBox='0 0 100 100' class="rounded hover:bg-white *:hover:fill-black [&_path:last-child]:hover:fill-white transition-colors">
                    <path d="M10 90 h10 L90 10 h-10 L10 90" fill="white"/>
                    <path d="M10 10 h30 L90 90 h-30 L10 10" fill="white"/>
                    <path d="M25 20 h10 L75 80 h-10 L25 20" fill="black"/>
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

