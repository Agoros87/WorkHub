@props(['advertisement' => request()->route('advertisement') ?? new App\Models\Advertisement()])
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Título -->
    <div class="md:col-span-2">
        <label for="title" class="block text-sm font-medium text-gray-700">Título del Anuncio</label>
        <input id="title" name="title" type="text" required
               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
               placeholder="Ej: Camarero para restaurante de comida rápida"
               value="{{ old('title', $advertisement->title) }}">
        <x-input-error for="title" class="mt-2" />
    </div>

    <!-- Descripción -->
    <div class="md:col-span-2">
        <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
        <textarea id="description" name="description" rows="4" required
                  class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                  placeholder="Describe detalladamente el puesto o tus habilidades">{{ old('description', $advertisement->description) }}</textarea>
        <x-input-error for="description" class="mt-2" />
    </div>

    <!-- Ubicación -->
    <div class="md:col-span-2">
        <label for="location" class="block text-sm font-medium text-gray-700">Población</label>
        <select id="location" name="location" autocomplete="location" required
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
            <option value="" disabled selected>Selecciona tu población</option>
            @foreach (config('locations') as $location)
                <option value="{{ $location }}" {{ old('location', $advertisement->location) === $location ? 'selected' : '' }}>
                    {{ $location }}
                </option>
            @endforeach
        </select>
        <x-input-error for="location" class="mt-2" />
    </div>

    <!-- Habilidades -->
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Habilidades</label>
        <div class="grid grid-cols-2 gap-2 mt-2">
            @foreach (array_chunk(config('skills'), 4) as $chunk)
                <div class="space-y-2">
                    @foreach ($chunk as $skill)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="skills[]" value="{{ $skill }}"
                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                {{ in_array($skill, (array) old('skills', $advertisement->skills ?? [])) ? 'checked' : '' }}>
                            <span class="text-gray-700">{{ $skill }}</span>
                        </label>
                    @endforeach
                </div>
            @endforeach
        </div>
        <x-input-error for="skills" class="mt-2" />
    </div>


    <!-- Experiencia -->
    <div class="md:col-span-2">
        <label for="experience" class="block text-sm font-medium text-gray-700">Experiencia Requerida</label>
        <input id="experience" name="experience" type="text"
               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
               placeholder="Ej: 2 años de experiencia"
               value="{{ old('experience', $advertisement->experience) }}">
        <x-input-error for="experience" class="mt-2" />
    </div>

    @if(auth()->user()->type === 'employer' || $advertisement->type === 'employer')
        <!-- Campos específicos para empleador -->
        <div>
            <label for="schedule" class="block text-sm font-medium text-gray-700">Horario</label>
            <input id="schedule" name="schedule" type="text"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                   placeholder="Ej: Tiempo completo, Media jornada"
                   value="{{ old('schedule', $advertisement->schedule) }}">
            <x-input-error for="schedule" class="mt-2" />
        </div>

        <div>
            <label for="contract_type" class="block text-sm font-medium text-gray-700">Tipo de Contrato</label>
            <input id="contract_type" name="contract_type" type="text"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                   placeholder="Ej: Indefinido, Temporal"
                   value="{{ old('contract_type', $advertisement->contract_type) }}">
            <x-input-error for="contract_type" class="mt-2" />
        </div>

        <div class="md:col-span-2">
            <label for="salary" class="block text-sm font-medium text-gray-700">Salario (€/año)</label>
            <input id="salary" name="salary" type="number" step="0.01"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                   placeholder="Ej: 30000"
                   value="{{ old('salary', $advertisement->salary) }}">
            <x-input-error for="salary" class="mt-2" />
        </div>
    @endif
    @if(auth()->user()->type === 'worker' || $advertisement->type === 'worker')
        <!-- Campos específicos para trabajador -->
        <div>
            <label for="availability" class="block text-sm font-medium text-gray-700">Disponibilidad</label>
            <input id="availability" name="availability" type="text"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                   placeholder="Ej: Inmediata, En 2 semanas"
                   value="{{ old('availability', $advertisement->availability) }}">
            <x-input-error for="availability" class="mt-2" />
        </div>

        <div>
            <label for="salary_expectation" class="block text-sm font-medium text-gray-700">Expectativa Salarial (€/año)</label>
            <input id="salary_expectation" name="salary_expectation" type="number" step="0.01"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                   placeholder="Ej: 25000"
                   value="{{ old('salary_expectation', $advertisement->salary_expectation) }}">
            <x-input-error for="salary_expectation" class="mt-2" />
        </div>
    @endif
</div>
