<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">
                    <a href="{{ route('proyectos.requirements.index', $proyecto) }}" class="hover:text-indigo-600">
                        {{ $proyecto->nombre }} › Requerimientos
                    </a>
                </p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $requirement->titulo }}
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('proyectos.requirements.edit', [$proyecto, $requirement]) }}">
                    <x-secondary-button>Editar</x-secondary-button>
                </a>
                <form method="POST" action="{{ route('proyectos.requirements.destroy', [$proyecto, $requirement]) }}">
                    @csrf
                    @method('DELETE')
                    <x-danger-button onclick="return confirm('¿Eliminar este requerimiento? Esta acción no se puede deshacer.')">
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

                    @if ($requirement->codigo)
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Código</p>
                            <p class="mt-1 text-sm font-mono text-gray-900">{{ $requirement->codigo }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tipo</p>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $requirement->tipo === 'no_funcional' ? 'No funcional' : 'Funcional' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Prioridad</p>
                            <p class="mt-1 text-sm text-gray-900 capitalize">{{ $requirement->prioridad }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Descripción</p>
                        <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $requirement->descripcion }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Registrado</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $requirement->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-3">Elementos relacionados</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('proyectos.requirements.user-stories.index', [$proyecto, $requirement]) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-200 rounded-md text-sm text-gray-700 hover:bg-gray-100 transition">
                            Historias de usuario
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-sm">
                <a href="{{ route('proyectos.requirements.index', $proyecto) }}" class="text-indigo-600 hover:underline">
                    ← Volver a los requerimientos
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
