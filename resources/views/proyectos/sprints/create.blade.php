<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs text-gray-500 mb-1">
                <a href="{{ route('proyectos.sprints.index', $proyecto) }}" class="hover:text-indigo-600">
                    {{ $proyecto->nombre }} › Sprints
                </a>
            </p>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nuevo sprint
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('proyectos.sprints.store', $proyecto) }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="nombre" value="Nombre" />
                            <x-text-input id="nombre" name="nombre" type="text"
                                class="mt-1 block w-full"
                                value="{{ old('nombre') }}"
                                placeholder="Ej: Sprint 1"
                                required autofocus />
                            <x-input-error :messages="$errors->get('nombre')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="objetivo" value="Objetivo" />
                            <textarea id="objetivo" name="objetivo"
                                rows="3"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"
                                placeholder="¿Qué se espera lograr en este sprint?">{{ old('objetivo') }}</textarea>
                            <x-input-error :messages="$errors->get('objetivo')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="estado" value="Estado" />
                            <select id="estado" name="estado"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                @foreach (['planificado' => 'Planificado', 'en_progreso' => 'En progreso', 'completado' => 'Completado'] as $value => $label)
                                    <option value="{{ $value }}" {{ old('estado', 'planificado') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('estado')" class="mt-1" />
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="fecha_inicio" value="Fecha de inicio" />
                                <x-text-input id="fecha_inicio" name="fecha_inicio" type="date"
                                    class="mt-1 block w-full"
                                    value="{{ old('fecha_inicio') }}" />
                                <x-input-error :messages="$errors->get('fecha_inicio')" class="mt-1" />
                            </div>
                            <div>
                                <x-input-label for="fecha_fin" value="Fecha de fin" />
                                <x-text-input id="fecha_fin" name="fecha_fin" type="date"
                                    class="mt-1 block w-full"
                                    value="{{ old('fecha_fin') }}" />
                                <x-input-error :messages="$errors->get('fecha_fin')" class="mt-1" />
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-6">
                            <x-primary-button>Guardar sprint</x-primary-button>
                            <a href="{{ route('proyectos.sprints.index', $proyecto) }}">
                                <x-secondary-button type="button">Cancelar</x-secondary-button>
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
