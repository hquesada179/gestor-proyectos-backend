<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">
                    <a href="{{ route('proyectos.sprints.index', $proyecto) }}" class="hover:text-indigo-600">
                        {{ $proyecto->nombre }} › Sprints
                    </a>
                </p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $sprint->nombre }}
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('proyectos.sprints.edit', [$proyecto, $sprint]) }}">
                    <x-secondary-button>Editar</x-secondary-button>
                </a>
                <form method="POST" action="{{ route('proyectos.sprints.destroy', [$proyecto, $sprint]) }}">
                    @csrf
                    @method('DELETE')
                    <x-danger-button onclick="return confirm('¿Eliminar este sprint? Esta acción no se puede deshacer.')">
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
                        <p class="mt-1 text-sm text-gray-900 capitalize">{{ str_replace('_', ' ', $sprint->estado) }}</p>
                    </div>

                    @if ($sprint->objetivo)
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Objetivo</p>
                            <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $sprint->objetivo }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Fecha de inicio</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $sprint->fecha_inicio?->format('d/m/Y') ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Fecha de fin</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $sprint->fecha_fin?->format('d/m/Y') ?? '—' }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Registrado</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $sprint->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                </div>
            </div>

            <div class="text-sm">
                <a href="{{ route('proyectos.sprints.index', $proyecto) }}" class="text-indigo-600 hover:underline">
                    ← Volver a sprints
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
