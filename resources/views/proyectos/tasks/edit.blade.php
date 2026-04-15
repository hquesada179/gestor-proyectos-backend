<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs text-gray-500 mb-1">
                <a href="{{ route('proyectos.tasks.show', [$proyecto, $task]) }}" class="hover:text-indigo-600">
                    {{ $proyecto->nombre }} › Tareas › {{ $task->titulo }}
                </a>
            </p>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar tarea
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('proyectos.tasks.update', [$proyecto, $task]) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <x-input-label for="titulo" value="Título" />
                            <x-text-input id="titulo" name="titulo" type="text"
                                class="mt-1 block w-full"
                                value="{{ old('titulo', $task->titulo) }}"
                                required autofocus />
                            <x-input-error :messages="$errors->get('titulo')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="descripcion" value="Descripción" />
                            <textarea id="descripcion" name="descripcion"
                                rows="4"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">{{ old('descripcion', $task->descripcion) }}</textarea>
                            <x-input-error :messages="$errors->get('descripcion')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="task_status_id" value="Estado" />
                            <select id="task_status_id" name="task_status_id"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" {{ old('task_status_id', $task->task_status_id) == $status->id ? 'selected' : '' }}>
                                        {{ $status->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('task_status_id')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="fecha_limite" value="Fecha límite" />
                            <x-text-input id="fecha_limite" name="fecha_limite" type="date"
                                class="mt-1 block w-full"
                                value="{{ old('fecha_limite', $task->fecha_limite?->format('Y-m-d')) }}" />
                            <x-input-error :messages="$errors->get('fecha_limite')" class="mt-1" />
                        </div>

                        @if ($userStories->isNotEmpty())
                            <div class="mb-4">
                                <x-input-label for="user_story_id" value="Historia de usuario (opcional)" />
                                <select id="user_story_id" name="user_story_id"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                    <option value="">— Sin historia asociada —</option>
                                    @foreach ($userStories as $userStory)
                                        <option value="{{ $userStory->id }}" {{ old('user_story_id', $task->user_story_id) == $userStory->id ? 'selected' : '' }}>
                                            {{ $userStory->titulo }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('user_story_id')" class="mt-1" />
                            </div>
                        @endif

                        <div class="flex items-center gap-3 mt-6">
                            <x-primary-button>Actualizar tarea</x-primary-button>
                            <a href="{{ route('proyectos.tasks.show', [$proyecto, $task]) }}">
                                <x-secondary-button type="button">Cancelar</x-secondary-button>
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
