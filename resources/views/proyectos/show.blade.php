<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $proyecto->nombre }}
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('proyectos.edit', $proyecto) }}">
                    <x-secondary-button>Editar</x-secondary-button>
                </a>
                <form method="POST" action="{{ route('proyectos.destroy', $proyecto) }}">
                    @csrf
                    @method('DELETE')
                    <x-danger-button onclick="return confirm('¿Eliminar este proyecto? Esta acción no se puede deshacer.')">
                        Eliminar
                    </x-danger-button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-md text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4">

                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Estado</p>
                        <p class="mt-1 text-sm text-gray-900 capitalize">{{ $proyecto->estado }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Descripción</p>
                        <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                            {{ $proyecto->descripcion ?? '—' }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Fecha de inicio</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $proyecto->fecha_inicio?->format('d/m/Y') ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Fecha estimada de cierre</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $proyecto->fecha_fin_estimada?->format('d/m/Y') ?? '—' }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Creado</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $proyecto->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-4">Resumen</h3>

                    <div class="grid grid-cols-3 gap-3 mb-4">
                        <a href="{{ route('proyectos.tasks.index', $proyecto) }}"
                            class="text-center p-3 bg-gray-50 rounded-md hover:bg-indigo-50 hover:ring-1 hover:ring-indigo-200 transition group">
                            <p class="text-2xl font-semibold text-gray-800 group-hover:text-indigo-700">{{ $stats['tasks'] }}</p>
                            <p class="text-xs text-gray-500 mt-1 group-hover:text-indigo-600">Tareas</p>
                        </a>
                        <a href="{{ route('proyectos.sprints.index', $proyecto) }}"
                            class="text-center p-3 bg-gray-50 rounded-md hover:bg-indigo-50 hover:ring-1 hover:ring-indigo-200 transition group">
                            <p class="text-2xl font-semibold text-gray-800 group-hover:text-indigo-700">{{ $stats['sprints'] }}</p>
                            <p class="text-xs text-gray-500 mt-1 group-hover:text-indigo-600">Sprints</p>
                        </a>
                        <a href="{{ route('proyectos.requirements.index', $proyecto) }}"
                            class="text-center p-3 bg-gray-50 rounded-md hover:bg-indigo-50 hover:ring-1 hover:ring-indigo-200 transition group">
                            <p class="text-2xl font-semibold text-gray-800 group-hover:text-indigo-700">{{ $stats['requirements'] }}</p>
                            <p class="text-xs text-gray-500 mt-1 group-hover:text-indigo-600">Requerimientos</p>
                        </a>
                        <div class="text-center p-3 bg-gray-50 rounded-md" title="Las historias se gestionan desde cada requerimiento">
                            <p class="text-2xl font-semibold text-gray-800">{{ $stats['userStories'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">Historias</p>
                        </div>
                        <a href="{{ route('proyectos.inputs.index', $proyecto) }}"
                            class="text-center p-3 bg-gray-50 rounded-md hover:bg-indigo-50 hover:ring-1 hover:ring-indigo-200 transition group">
                            <p class="text-2xl font-semibold text-gray-800 group-hover:text-indigo-700">{{ $stats['inputs'] }}</p>
                            <p class="text-xs text-gray-500 mt-1 group-hover:text-indigo-600">Insumos</p>
                        </a>
                    </div>

                    @if ($tasksByStatus->isNotEmpty())
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Tareas por estado</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($tasksByStatus as $item)
                                    <a href="{{ route('proyectos.tasks.index', ['proyecto' => $proyecto, 'estado' => $item->status_id]) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-100 rounded-full text-xs text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition">
                                        <span class="font-semibold text-gray-900">{{ $item->total }}</span>
                                        {{ $item->nombre }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-3">Módulos del proyecto</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('proyectos.inputs.index', $proyecto) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-200 rounded-md text-sm text-gray-700 hover:bg-gray-100 transition">
                            Insumos
                        </a>
                        <a href="{{ route('proyectos.requirements.index', $proyecto) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-200 rounded-md text-sm text-gray-700 hover:bg-gray-100 transition">
                            Requerimientos
                        </a>
                        <a href="{{ route('proyectos.tasks.index', $proyecto) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-200 rounded-md text-sm text-gray-700 hover:bg-gray-100 transition">
                            Tareas
                        </a>
                        <a href="{{ route('proyectos.sprints.index', $proyecto) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-200 rounded-md text-sm text-gray-700 hover:bg-gray-100 transition">
                            Sprints
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-sm">
                <a href="{{ route('proyectos.index') }}" class="text-indigo-600 hover:underline">
                    ← Volver a mis proyectos
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
