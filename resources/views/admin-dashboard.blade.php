<x-app-layout>
    <!-- Contenedor principal -->
    <div class="flex items-center justify-center min-h-[150px] bg-gradient-to-r from-blue-50 to-gray-50">
        <div class="text-center">
            <!-- Título -->
            <h2 class="text-4xl font-bold mb-2 relative inline-block">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">
                    {{ __('Panel de Administración') }}
                </span>
                <span class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 to-purple-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></span>
            </h2>
            <p class="text-lg text-gray-600">Gestiona usuarios y anuncios de manera eficiente</p>
        </div>
    </div>

    <div class="min-h-screen bg-gradient-to-r from-blue-50 to-gray-50"> <!-- Reduje el padding superior a py-8 -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Usuarios -->
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden mb-8 transform transition-transform duration-300 hover:scale-101">
                <div class="p-8 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        @svg('heroicon-o-users', 'h-8 w-8 text-blue-600 mr-2')
                        Usuarios
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->type === 'employer')
                                            <span class="font-semibold text-gray-800">{{ $user->company_name }}</span>
                                        @else
                                            <span class="font-semibold text-gray-800">{{ $user->name }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->type === 'employer')
                                            <span class="px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-800">Empleador</span>
                                        @elseif($user->type === 'worker')
                                            <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-800">Trabajador</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-800">{{ $user->type }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @can('delete', $user)
                                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?')">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>

            <!-- Anuncios -->
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden transform transition-transform duration-300 hover:scale-101">
                <div class="p-8 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        @svg('heroicon-o-newspaper', 'h-8 w-8 text-blue-600 mr-2')
                        Anuncios
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($advertisements as $advertisement)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('advertisements.show', $advertisement) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                            {{ $advertisement->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                        @if($advertisement->user->type === 'employer')
                                            {{ $advertisement->user->company_name }}
                                        @else
                                            {{ $advertisement->user->name }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $advertisement->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @can('delete', $advertisement)
                                            <form action="{{ route('admin.advertisements.delete', $advertisement) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium" onclick="return confirm('¿Estás seguro de que quieres eliminar este anuncio?')">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $advertisements->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
