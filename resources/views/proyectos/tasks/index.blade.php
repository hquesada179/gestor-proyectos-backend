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
                    Tareas
                </h2>
            </div>
            <a href="{{ route('proyectos.tasks.create', $proyecto) }}">
                <x-primary-button>Nueva tarea</x-primary-button>
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

            @if ($statuses->isNotEmpty() || $sprints->isNotEmpty())
                <div class="mb-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <form method="GET" action="{{ route('proyectos.tasks.index', $proyecto) }}" class="flex flex-wrap items-end gap-3">

                            @if ($statuses->isNotEmpty())
                                <div>
                                    <label for="estado" class="block text-xs font-medium text-gray-500 mb-1">Estado</label>
                                    <select id="estado" name="estado"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                        <option value="">Todos</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}" {{ request('estado') == $status->id ? 'selected' : '' }}>
                                                {{ $status->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            @if ($sprints->isNotEmpty())
                                <div>
                                    <label for="sprint" class="block text-xs font-medium text-gray-500 mb-1">Sprint</label>
                                    <select id="sprint" name="sprint"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                        <option value="">Todos</option>
                                        <option value="sin_sprint" {{ request('sprint') === 'sin_sprint' ? 'selected' : '' }}>Sin sprint</option>
                                        @foreach ($sprints as $sprint)
                                            <option value="{{ $sprint->id }}" {{ request('sprint') == $sprint->id ? 'selected' : '' }}>
                                                {{ $sprint->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <x-primary-button type="submit">Filtrar</x-primary-button>

                            @if (request()->hasAny(['estado', 'sprint']))
                                <a href="{{ route('proyectos.tasks.index', $proyecto) }}"
                                    class="text-sm text-gray-500 hover:text-gray-700 hover:underline">
                                    Limpiar filtros
                                </a>
                            @endif

                        </form>
                    </div>
                </div>
            @endif

            @if ($tasks->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-500 text-sm">
                        @if (request()->hasAny(['estado', 'sprint']))
                            No hay tareas que coincidan con los filtros seleccionados.
                            <a href="{{ route('proyectos.tasks.index', $proyecto) }}" class="text-indigo-600 hover:underline ml-1">Ver todas</a>.
                        @else
                            Este proyecto no tiene tareas todavía.
                            <a href="{{ route('proyectos.tasks.create', $proyecto) }}" class="text-indigo-600 hover:underline ml-1">Agregar la primera</a>.
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Fecha límite</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Registrada</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        <a href="{{ route('proyectos.tasks.show', [$proyecto, $task]) }}" class="hover:text-indigo-600">
                                            {{ $task->titulo }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ $task->status->nombre ?? '—' }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $task->fecha_limite?->format('d/m/Y') ?? '—' }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $task->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('proyectos.tasks.edit', [$proyecto, $task]) }}" class="text-indigo-600 hover:underline text-xs mr-3">Editar</a>
                                        <form method="POST" action="{{ route('proyectos.tasks.destroy', [$proyecto, $task]) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:underline text-xs"
                                                onclick="return confirm('¿Eliminar esta tarea?')">
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
                <a href="{{ route('proyectos.show', $proyecto) }}" class="text-indigo-600 hover:underline">
                    ← Volver al proyecto
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
