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

            <div class="text-sm">
                <a href="{{ route('proyectos.index') }}" class="text-indigo-600 hover:underline">
                    ← Volver a mis proyectos
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
