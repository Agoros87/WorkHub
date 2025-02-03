<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        @auth
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>
        @endauth

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            @auth
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                        {{ Auth::user()->name ? Auth::user()->name : (Auth::user()->company_name ?? '') }}
                    </div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
            @endauth

            <div class="mt-3 space-y-1">
                @auth
                    <!-- Account Management -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        Gestionar Cuenta
                    </div>

                    <x-responsive-nav-link href="{{ route('dashboard') }}">
                        Dashboard
                    </x-responsive-nav-link>

                    <x-responsive-nav-link href="{{ route('profile.show') }}">
                        Perfil
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <x-responsive-nav-link href="{{ route('logout') }}"
                                       @click.prevent="$root.submit();">
                            Cerrar Sesión
                        </x-responsive-nav-link>
                    </form>
                @endauth

                <!-- Team Management -->
                @auth
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <div class="border-t border-gray-200 dark:border-gray-600"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Team') }}
                        </div>

                        <!-- Team Settings -->
                        <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                            {{ __('Team Settings') }}
                        </x-responsive-nav-link>

                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                                {{ __('Create New Team') }}
                            </x-responsive-nav-link>
                        @endcan

                        <!-- Team Switcher -->
                        @if (Auth::user()->allTeams()->count() > 1)
                            <div class="border-t border-gray-200 dark:border-gray-600"></div>

                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Switch Teams') }}
                            </div>

                            @foreach (Auth::user()->allTeams() as $team)
                                <x-switchable-team :team="$team" component="responsive-nav-link" />
                            @endforeach
                        @endif
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>
