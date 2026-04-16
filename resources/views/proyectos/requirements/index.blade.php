<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">
                    <a href="{{ route('proyectos.show', $proyecto) }}" class="hover:text-indigo-600">
                        {{ $proyecto->nombre }}
                    </a>
                </p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Requerimientos
                </h2>
            </div>
            <a href="{{ route('proyectos.requirements.create', $proyecto) }}">
                <x-primary-button>Nuevo requerimiento</x-primary-button>
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

            @if ($requirements->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-500 text-sm">
                        Este proyecto no tiene requerimientos registrados todavía.
                        <a href="{{ route('proyectos.requirements.create', $proyecto) }}" class="text-indigo-600 hover:underline ml-1">Agregar el primero</a>.
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Prioridad</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($requirements as $requirement)
                                <tr>
                                    <td class="px-6 py-4 text-gray-500 font-mono text-xs">
                                        {{ $requirement->codigo ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        <a href="{{ route('proyectos.requirements.show', [$proyecto, $requirement]) }}" class="hover:text-indigo-600">
                                            {{ $requirement->titulo }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $requirement->tipo === 'no_funcional' ? 'No funcional' : 'Funcional' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 capitalize">{{ $requirement->prioridad }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('proyectos.requirements.edit', [$proyecto, $requirement]) }}" class="text-indigo-600 hover:underline text-xs mr-3">Editar</a>
                                        <form method="POST" action="{{ route('proyectos.requirements.destroy', [$proyecto, $requirement]) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:underline text-xs"
                                                onclick="return confirm('¿Eliminar este requerimiento?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($requirements->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100">
                            {{ $requirements->links() }}
                        </div>
                    @endif
                </div>
            @endif

            <div class="mt-4 text-sm">
                <a href="{{ route('proyectos.show', $proyecto) }}" class="text-indigo-600 hover:underline">
                    ← Volver al proyecto
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
