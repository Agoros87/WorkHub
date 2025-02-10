<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center space-x-2">
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
        @endif
        <span>{{ Auth::user()->name ? Auth::user()->name : (Auth::user()->company_name ?? '') }}</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20">
        <div class="block px-4 py-2 text-xs text-gray-400">
            Gestionar Cuenta
        </div>

        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">{{ __('Dashboard') }}</a>
        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Perfil</a>

        <div class="border-t border-gray-200"></div>

        <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf
            <a href="{{ route('logout') }}"
               @click.prevent="$root.submit();" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">
                Cerrar Sesión
            </a>
        </form>
    </div>
</div>
