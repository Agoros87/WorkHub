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
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $advertisement->title }}</h1>
                        <p class="text-gray-600">
                            Publicado por
                            {{ $advertisement->user->company_name ?? $advertisement->user->name }} -
                            {{ $advertisement->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <h2 class="text-xl font-semibold text-gray-700 mb-2">Descripción</h2>
                            <p class="text-gray-600 whitespace-pre-line">{{ $advertisement->description }}</p>
                        </div>

                        <div class="col-span-2">
                            <h2 class="text-xl font-semibold text-gray-700 mb-2">Ubicación</h2>
                            <p class="text-gray-600">{{ $advertisement->location }}</p>
                        </div>

                        @if($advertisement->skills)
                            <div class="col-span-2">
                                <h2 class="text-xl font-semibold text-gray-700 mb-2">Habilidades</h2>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(is_array($advertisement->skills) ? $advertisement->skills : explode(',', $advertisement->skills) as $skill)
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                    {{ trim($skill) }}
                </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($advertisement->experience)
                            <div class="col-span-2">
                                <h2 class="text-xl font-semibold text-gray-700 mb-2">Experiencia</h2>
                                <p class="text-gray-600">{{ $advertisement->experience }}</p>
                            </div>
                        @endif

                        @if($advertisement->type === 'employer')
                            @if($advertisement->schedule)
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Horario</h2>
                                    <p class="text-gray-600">{{ $advertisement->schedule }}</p>
                                </div>
                            @endif

                            @if($advertisement->contract_type)
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Tipo de Contrato</h2>
                                    <p class="text-gray-600">{{ $advertisement->contract_type }}</p>
                                </div>
                            @endif

                            @if($advertisement->salary)
                                <div class="col-span-2">
                                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Salario</h2>
                                    <p class="text-gray-600">{{ number_format($advertisement->salary, 2, ',', '.') }} €/año</p>
                                </div>
                            @endif
                        @else
                            @if($advertisement->availability)
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Disponibilidad</h2>
                                    <p class="text-gray-600">{{ $advertisement->availability }}</p>
                                </div>
                            @endif

                            @if($advertisement->salary_expectation)
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Expectativa Salarial</h2>
                                    <p class="text-gray-600">{{ number_format($advertisement->salary_expectation, 2, ',', '.') }} €/año</p>
                                </div>
                            @endif
                        @endif
                    </div>

                    @if(auth()->id() === $advertisement->user_id)
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
