<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">
                    <a href="{{ route('proyectos.tasks.index', $proyecto) }}" class="hover:text-indigo-600">
                        {{ $proyecto->nombre }} › Tareas
                    </a>
                </p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $task->titulo }}
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('proyectos.tasks.edit', [$proyecto, $task]) }}">
                    <x-secondary-button>Editar</x-secondary-button>
                </a>
                <form method="POST" action="{{ route('proyectos.tasks.destroy', [$proyecto, $task]) }}">
                    @csrf
                    @method('DELETE')
                    <x-danger-button onclick="return confirm('¿Eliminar esta tarea? Esta acción no se puede deshacer.')">
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
                        <p class="mt-1 text-sm text-gray-900">{{ $task->status->nombre ?? '—' }}</p>
                    </div>

                    @if ($task->descripcion)
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Descripción</p>
                            <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $task->descripcion }}</p>
                        </div>
                    @endif

                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Fecha límite</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $task->fecha_limite?->format('d/m/Y') ?? '—' }}</p>
                    </div>

                    @if ($task->userStory)
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Historia de usuario</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $task->userStory->titulo }}</p>
                        </div>
                    @endif

                    @if ($task->sprint)
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Sprint</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $task->sprint->nombre }}</p>
                        </div>
                    @endif

                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Responsable</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $task->assignedTo->name ?? '—' }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Registrada</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $task->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                </div>
            </div>

            <div class="text-sm">
                <a href="{{ route('proyectos.tasks.index', $proyecto) }}" class="text-indigo-600 hover:underline">
                    ← Volver a tareas
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
