<x-app-layout>
    <div class="min-h-screen bg-gradient-to-r from-blue-50 to-gray-50 pt-8">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="mb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-800 mb-2 break-words">{{ $advertisement->title }}</h1>
                                <p class="text-gray-600">
                                    Publicado por
                                    {{ $advertisement->user->company_name ?? $advertisement->user->name }} -
                                    {{ $advertisement->created_at->diffForHumans() }}
                                </p>
                            </div>
                            @auth
                                @if(auth()->id() !== $advertisement->user_id)
                                    <livewire:favorite-button :advertisement="$advertisement" />
                                @endif
                            @endauth
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Descripción -->
                        <div class="col-span-2">
                            <h2 class="text-xl font-semibold text-gray-700 mb-2">Descripción</h2>
                            <p class="text-gray-600 whitespace-pre-line break-words">{{ $advertisement->description }}</p>
                        </div>

                        <!-- Ubicación -->
                        <div class="col-span-2">
                            <h2 class="text-xl font-semibold text-gray-700 mb-2">Ubicación</h2>
                            <p class="text-gray-600 break-words">{{ $advertisement->location }}</p>
                        </div>

                        <!-- Habilidades -->
                        @if($advertisement->skills)
                            <div class="col-span-2">
                                <h2 class="text-xl font-semibold text-gray-700 mb-2">Habilidades</h2>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(is_array($advertisement->skills) ? $advertisement->skills : explode(',', $advertisement->skills) as $skill)
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm break-words">
                                            {{ trim($skill) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Experiencia -->
                        @if($advertisement->experience)
                            <div class="col-span-2">
                                <h2 class="text-xl font-semibold text-gray-700 mb-2">Experiencia</h2>
                                <p class="text-gray-600 break-words">{{ $advertisement->experience }}</p>
                            </div>
                        @endif

                        <!-- Campos específicos para empleador -->
                        @if($advertisement->type === 'employer')
                            @if($advertisement->schedule)
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Horario</h2>
                                    <p class="text-gray-600 break-words">{{ $advertisement->schedule }}</p>
                                </div>
                            @endif

                            @if($advertisement->contract_type)
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Tipo de Contrato</h2>
                                    <p class="text-gray-600 break-words">{{ $advertisement->contract_type }}</p>
                                </div>
                            @endif

                            @if($advertisement->salary)
                                <div class="col-span-2">
                                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Salario</h2>
                                    <p class="text-gray-600 break-words">{{ number_format($advertisement->salary, 2, ',', '.') }} €/año</p>
                                </div>
                            @endif
                        @else
                            <!-- Campos específicos para trabajador -->
                            @if($advertisement->availability)
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Disponibilidad</h2>
                                    <p class="text-gray-600 break-words">{{ $advertisement->availability }}</p>
                                </div>
                            @endif

                            @if($advertisement->salary_expectation)
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Expectativa Salarial</h2>
                                    <p class="text-gray-600 break-words">{{ number_format($advertisement->salary_expectation, 2, ',', '.') }} €/año</p>
                                </div>
                            @endif
                        @endif
                    </div>

                    <!-- Botones de editar y eliminar -->
                    @can('update', $advertisement)
                    <div class="mt-8 flex gap-4">
                            <a href="{{ route('advertisements.edit', $advertisement) }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Editar Anuncio
                            </a>
                            <form action="{{ route('advertisements.destroy', $advertisement) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                        onclick="return confirm('¿Estás seguro de que quieres eliminar este anuncio?')">
                                    Eliminar Anuncio
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>

            @auth
                @can('apply', [$advertisement, $hasApplied])
                    <div class="mt-4 flex justify-end">
                        <form action="{{ route('advertisements.apply', $advertisement) }}" method="POST">
                            @csrf
                            <x-button type="submit">
                                Aplicar a esta oferta
                            </x-button>
                        </form>
                    </div>
                @else
                    @if($hasApplied)
                        <div class="mt-4">
                            <p class="text-green-600">Ya has aplicado a esta oferta</p>
                        </div>
                    @endif
                @endcan
            @else
                <div class="mt-4">
                    <p class="text-gray-600">Debes <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-900">iniciar sesión</a> para aplicar a esta oferta</p>
                </div>
            @endauth
        </div>
    </div>
</x-app-layout>
