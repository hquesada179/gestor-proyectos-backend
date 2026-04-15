<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">
                    <a href="{{ route('proyectos.requirements.user-stories.index', [$proyecto, $requirement]) }}" class="hover:text-indigo-600">
                        {{ $proyecto->nombre }} › Requerimientos › {{ $requirement->titulo }} › Historias
                    </a>
                </p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $userStory->titulo }}
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('proyectos.requirements.user-stories.edit', [$proyecto, $requirement, $userStory]) }}">
                    <x-secondary-button>Editar</x-secondary-button>
                </a>
                <form method="POST" action="{{ route('proyectos.requirements.user-stories.destroy', [$proyecto, $requirement, $userStory]) }}">
                    @csrf
                    @method('DELETE')
                    <x-danger-button onclick="return confirm('¿Eliminar esta historia de usuario? Esta acción no se puede deshacer.')">
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
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Prioridad</p>
                        <p class="mt-1 text-sm text-gray-900 capitalize">{{ $userStory->prioridad }}</p>
                    </div>

                    @if ($userStory->como_usuario || $userStory->quiero || $userStory->para_poder)
                        <div class="border border-gray-100 rounded-md p-4 space-y-2 text-sm text-gray-800">
                            @if ($userStory->como_usuario)
                                <p><span class="font-medium">Como</span> {{ $userStory->como_usuario }},</p>
                            @endif
                            @if ($userStory->quiero)
                                <p><span class="font-medium">quiero</span> {{ $userStory->quiero }},</p>
                            @endif
                            @if ($userStory->para_poder)
                                <p><span class="font-medium">para poder</span> {{ $userStory->para_poder }}.</p>
                            @endif
                        </div>
                    @endif

                    @if ($userStory->criterios_aceptacion)
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Criterios de aceptación</p>
                            <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $userStory->criterios_aceptacion }}</p>
                        </div>
                    @endif

                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Registrado</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $userStory->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                </div>
            </div>

            <div class="text-sm">
                <a href="{{ route('proyectos.requirements.user-stories.index', [$proyecto, $requirement]) }}" class="text-indigo-600 hover:underline">
                    ← Volver a las historias
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
