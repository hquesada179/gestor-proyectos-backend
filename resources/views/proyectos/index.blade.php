<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mis proyectos
            </h2>
            <a href="{{ route('proyectos.create') }}">
                <x-primary-button>Nuevo proyecto</x-primary-button>
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

            @if ($proyectos->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-500 text-sm">
                        No tienes proyectos registrados todavía.
                        <a href="{{ route('proyectos.create') }}" class="text-indigo-600 hover:underline ml-1">Crear el primero</a>.
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Resumen</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Fecha inicio</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Fecha estimada</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($proyectos as $proyecto)
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        <a href="{{ route('proyectos.show', $proyecto) }}" class="hover:text-indigo-600">
                                            {{ $proyecto->nombre }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 capitalize">{{ $proyecto->estado }}</td>
                                    <td class="px-6 py-4 text-gray-500 text-xs">
                                        <span title="Tareas">{{ $proyecto->tasks_count }} tareas</span>
                                        <span class="mx-1 text-gray-300">·</span>
                                        <span title="Sprints">{{ $proyecto->sprints_count }} sprints</span>
                                        <span class="mx-1 text-gray-300">·</span>
                                        <span title="Requerimientos">{{ $proyecto->requirements_count }} req.</span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ $proyecto->fecha_inicio?->format('d/m/Y') ?? '—' }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $proyecto->fecha_fin_estimada?->format('d/m/Y') ?? '—' }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('proyectos.edit', $proyecto) }}" class="text-indigo-600 hover:underline text-xs mr-3">Editar</a>
                                        <form method="POST" action="{{ route('proyectos.destroy', $proyecto) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:underline text-xs"
                                                onclick="return confirm('¿Eliminar este proyecto?')">
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

        </div>
    </div>
</x-app-layout>
