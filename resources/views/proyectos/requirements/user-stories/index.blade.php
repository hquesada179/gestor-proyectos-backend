<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">
                    <a href="{{ route('proyectos.requirements.show', [$proyecto, $requirement]) }}" class="hover:text-indigo-600">
                        {{ $proyecto->nombre }} › Requerimientos › {{ $requirement->titulo }}
                    </a>
                </p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Historias de usuario
                </h2>
            </div>
            <a href="{{ route('proyectos.requirements.user-stories.create', [$proyecto, $requirement]) }}">
                <x-primary-button>Nueva historia</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($userStories->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-500 text-sm">
                        Este requerimiento no tiene historias de usuario todavía.
                        <a href="{{ route('proyectos.requirements.user-stories.create', [$proyecto, $requirement]) }}" class="text-indigo-600 hover:underline ml-1">Agregar la primera</a>.
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Prioridad</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Registrado</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($userStories as $userStory)
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        <a href="{{ route('proyectos.requirements.user-stories.show', [$proyecto, $requirement, $userStory]) }}" class="hover:text-indigo-600">
                                            {{ $userStory->titulo }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 capitalize">{{ $userStory->prioridad }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $userStory->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('proyectos.requirements.user-stories.edit', [$proyecto, $requirement, $userStory]) }}" class="text-indigo-600 hover:underline text-xs mr-3">Editar</a>
                                        <form method="POST" action="{{ route('proyectos.requirements.user-stories.destroy', [$proyecto, $requirement, $userStory]) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:underline text-xs"
                                                onclick="return confirm('¿Eliminar esta historia de usuario?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="mt-4 text-sm">
                <a href="{{ route('proyectos.requirements.show', [$proyecto, $requirement]) }}" class="text-indigo-600 hover:underline">
                    ← Volver al requerimiento
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
