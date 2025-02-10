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
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Subir CV</h3>
            <div class="space-y-4">
                <div
                    x-data="{
                        isDropping: false,
                        handleDrop(e) {
                            e.preventDefault();
                            const file = e.dataTransfer.files[0];
                            if (file) {
                                const input = this.$refs.fileInput;
                                const dataTransfer = new DataTransfer();
                                dataTransfer.items.add(file);
                                input.files = dataTransfer.files;
                                input.dispatchEvent(new Event('change'));
                            }
                            this.isDropping = false;
                        }
                    }"
                    x-on:dragover.prevent="isDropping = true"
                    x-on:dragleave.prevent="isDropping = false"
                    x-on:drop.prevent="handleDrop($event)"
                    :class="{ 'border-indigo-500 bg-indigo-50': isDropping }"
                    class="transition-colors duration-200 border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer"
                >
                    <div class="space-y-2">
                        <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex justify-center text-sm text-gray-600">
                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>Sube un archivo</span>
                                <input type="file" class="sr-only" wire:model="cv" x-ref="fileInput">
                            </label>
                            <p class="pl-1">o arrastra y suelta</p>
                        </div>
                        <p class="text-xs text-gray-500">PDF, DOC hasta 2MB</p>
                    </div>
                </div>
                @error('cv') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                @if($temporaryCv)
                    <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                        <span class="text-sm text-gray-600">Archivo seleccionado: {{ $temporaryCv->getClientOriginalName() }}</span>
                        <button
                            wire:click="uploadCV"
                            class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Subir CV
                        </button>
                    </div>
                @endif

                @if($jobApplication->cv_path)
                    <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-600">
                            CV actual:
                            <a href="{{ Storage::url($jobApplication->cv_path) }}" class="text-indigo-600 hover:text-indigo-900" target="_blank">
                                Ver CV
                            </a>
                        </div>
                        <button
                            wire:click="deleteCV"
                            class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        >
                            Eliminar CV
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Sección del Chat -->
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4">Chat</h3>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <!-- Área de Mensajes -->
            <div
                class="h-96 overflow-y-auto space-y-4 pr-2"
                id="chat-messages"
                x-data="{
                    scrollToBottom() {
                        this.$el.scrollTop = this.$el.scrollHeight;
                    }
                }"
                x-init="scrollToBottom"
                @messages-updated.window="scrollToBottom"
            >
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
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition"
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
