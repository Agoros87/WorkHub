<div class="p-6">
    <!-- Icono de flecha hacia atrás -->
    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6">
        @svg('heroicon-s-arrow-left', 'h-5 w-5 mr-2') <!-- Icono de flecha -->
        <span class="text-sm font-medium">Volver al Panel de Control</span>
    </a>

    <!-- Botón de descarga de CV (solo para empleadores) -->
    @if(auth()->user()->type == 'employer' && $jobApplication->cv_path)
        <div class="mb-6">
            <a href="{{ Storage::url($jobApplication->cv_path) }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
               target="_blank">
                @svg('heroicon-s-document-arrow-down', 'h-5 w-5 mr-2')
                Ver/Descargar CV
            </a>
        </div>
    @elseif(auth()->user()->type == 'employer' && !$jobApplication->cv_path)
        <div class="text-sm text-gray-500 italic text-center p-4 bg-gray-100 rounded-lg">
            No se ha recibido ningún CV.
        </div>
    @endif

    <!-- Sección de Subir CV (solo para workers) -->
    @if(auth()->user()->type == 'worker')
        <form wire:submit.prevent="uploadCV">
            <div>
                <input type="file" wire:model="cv" class="w-full mt-1 block" accept=".pdf,.doc,.docx">

                @if ($cv)
                    <p class="text-sm text-gray-600">Archivo seleccionado: {{ $cv->getClientOriginalName() }}</p>
                @elseif ($jobApplication->cv_path)
                    <p class="text-sm text-gray-600">
                        CV actual:
                        <a href="{{ asset('storage/' . $jobApplication->cv_path) }}"
                           class="text-indigo-600 hover:underline"
                           target="_blank">
                            Ver CV
                        </a>
                    </p>
                @endif

                @error('cv') <span class="error text-red-500">{{ $message }}</span> @enderror

            @if (session()->has('message'))
                <p class="text-green-500">{{ session('message') }}</p>
            @endif

            @if (session()->has('error'))
                <p class="text-red-500">{{ session('error') }}</p>
            @endif

                <div class="mt-4 flex gap-2">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Subir CV
                    </button>

                    @if ($jobApplication->cv_path)
                        <button type="button"
                                wire:click="deleteCV"
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Eliminar CV
                        </button>
                    @endif
                </div>
            </div>
        </form>

    @endif

    <!-- Sección del Chat -->
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4">Chat</h3>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <!-- Área de Mensajes -->
            <div class="h-96 overflow-y-auto space-y-4 pr-2" id="chat-messages">
                @foreach(collect($messages)->sortBy('created_at') as $message)
                    <div class="flex {{ $message['user_id'] === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="{{ $message['user_id'] === auth()->id() ? 'bg-indigo-100' : 'bg-gray-100' }} rounded-lg px-4 py-2 max-w-sm">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $message['user_id'] === auth()->id() ? 'Tú' : (auth()->user()->type === 'worker' ? $message['user']['company_name'] : $message['user']['name']) }}
                            </p>
                            <p class="text-sm text-gray-700">{{ $message['message'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($message['created_at'])->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
    </div>

            <!-- Formulario de Envío de Mensajes -->
            <div class="mt-4">
                <form wire:submit.prevent="sendMessage">
                    <div class="flex gap-2">
                        <input
                            type="text"
                            wire:model="message"
                            class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Escribe un mensaje..."
                        >
                        <button
                            type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition"
                        >
                            Enviar
                        </button>
                    </div>
                    @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </form>
            </div>
        </div>
    </div>
</div>
