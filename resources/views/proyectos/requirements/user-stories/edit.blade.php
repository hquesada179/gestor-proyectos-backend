<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs text-gray-500 mb-1">
                <a href="{{ route('proyectos.requirements.user-stories.show', [$proyecto, $requirement, $userStory]) }}" class="hover:text-indigo-600">
                    {{ $proyecto->nombre }} › Requerimientos › {{ $requirement->titulo }} › {{ $userStory->titulo }}
                </a>
            </p>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar historia de usuario
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('proyectos.requirements.user-stories.update', [$proyecto, $requirement, $userStory]) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <x-input-label for="titulo" value="Título" />
                            <x-text-input id="titulo" name="titulo" type="text"
                                class="mt-1 block w-full"
                                value="{{ old('titulo', $userStory->titulo) }}"
                                required autofocus />
                            <x-input-error :messages="$errors->get('titulo')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="como_usuario" value="Como usuario..." />
                            <x-text-input id="como_usuario" name="como_usuario" type="text"
                                class="mt-1 block w-full"
                                value="{{ old('como_usuario', $userStory->como_usuario) }}" />
                            <x-input-error :messages="$errors->get('como_usuario')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="quiero" value="Quiero..." />
                            <x-text-input id="quiero" name="quiero" type="text"
                                class="mt-1 block w-full"
                                value="{{ old('quiero', $userStory->quiero) }}" />
                            <x-input-error :messages="$errors->get('quiero')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="para_poder" value="Para poder..." />
                            <x-text-input id="para_poder" name="para_poder" type="text"
                                class="mt-1 block w-full"
                                value="{{ old('para_poder', $userStory->para_poder) }}" />
                            <x-input-error :messages="$errors->get('para_poder')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="criterios_aceptacion" value="Criterios de aceptación" />
                            <textarea id="criterios_aceptacion" name="criterios_aceptacion"
                                rows="4"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">{{ old('criterios_aceptacion', $userStory->criterios_aceptacion) }}</textarea>
                            <x-input-error :messages="$errors->get('criterios_aceptacion')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="prioridad" value="Prioridad" />
                            <select id="prioridad" name="prioridad"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                @foreach (['alta', 'media', 'baja'] as $opcion)
                                    <option value="{{ $opcion }}" {{ old('prioridad', $userStory->prioridad) === $opcion ? 'selected' : '' }}>
                                        {{ ucfirst($opcion) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('prioridad')" class="mt-1" />
                        </div>

                        <div class="flex items-center gap-3 mt-6">
                            <x-primary-button>Actualizar historia</x-primary-button>
                            <a href="{{ route('proyectos.requirements.user-stories.show', [$proyecto, $requirement, $userStory]) }}">
                                <x-secondary-button type="button">Cancelar</x-secondary-button>
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
