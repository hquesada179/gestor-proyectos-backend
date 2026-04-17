<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis tareas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <form method="GET" action="{{ route('mis-tareas') }}" class="flex items-center gap-4 flex-wrap">
                @if ($sprintsDisponibles->isNotEmpty())
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500">Sprint:</span>
                        <select name="sprint" onchange="this.form.submit()"
                            class="text-sm border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-1 pl-2 pr-6">
                            <option value="todos" {{ $sprintFiltro === 'todos' ? 'selected' : '' }}>Todos</option>
                            <option value="sin_sprint" {{ $sprintFiltro === 'sin_sprint' ? 'selected' : '' }}>Sin sprint</option>
                            @foreach ($sprintsDisponibles as $sprint)
                                <option value="{{ $sprint->id }}" {{ (string) $sprintFiltro === (string) $sprint->id ? 'selected' : '' }}>
                                    {{ $sprint->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-500">Estado:</span>
                    <select name="estado" onchange="this.form.submit()"
                        class="text-sm border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-1 pl-2 pr-6">
                        <option value="todos" {{ $estadoFiltro === 'todos' ? 'selected' : '' }}>Todos</option>
                        @foreach ($estadosDisponibles as $status)
                            <option value="{{ $status->id }}" {{ (string) $estadoFiltro === (string) $status->id ? 'selected' : '' }}>
                                {{ $status->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>

            @if ($tasks->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-500 text-sm">
                        @if ($sprintFiltro !== 'todos' || $estadoFiltro !== 'todos')
                            No hay tareas asignadas para este filtro.
                        @else
                            No tienes tareas asignadas en ningún proyecto todavía.
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Tarea</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Proyecto</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Sprint</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Fecha límite</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @php $today = now()->startOfDay(); @endphp
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $task->titulo }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        <a href="{{ route('proyectos.show', $task->proyecto) }}" class="hover:text-indigo-600">
                                            {{ $task->proyecto->nombre }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ $task->status->nombre ?? '—' }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $task->sprint->nombre ?? '—' }}</td>
                                    <td class="px-6 py-4">
                                        @if ($task->fecha_limite)
                                            @php
                                                $isOverdue  = $task->fecha_limite->lt($today);
                                                $isUpcoming = !$isOverdue && $task->fecha_limite->lte($today->copy()->addDays(3));
                                            @endphp
                                            <span class="text-xs font-medium
                                                {{ $isOverdue ? 'text-red-500' : ($isUpcoming ? 'text-amber-500' : 'text-gray-600') }}">
                                                {{ $task->fecha_limite->format('d/m/Y') }}
                                                @if ($isOverdue) · Vencida
                                                @elseif ($isUpcoming) · Próxima
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('proyectos.tasks.show', [$task->proyecto, $task]) }}"
                                            class="text-indigo-600 hover:underline text-xs">
                                            Ver tarea
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($tasks->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100">
                            {{ $tasks->links() }}
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
