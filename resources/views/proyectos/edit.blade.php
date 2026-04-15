<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar proyecto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('proyectos.update', $proyecto) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <x-input-label for="nombre" value="Nombre del proyecto" />
                            <x-text-input id="nombre" name="nombre" type="text"
                                class="mt-1 block w-full"
                                value="{{ old('nombre', $proyecto->nombre) }}"
                                required autofocus />
                            <x-input-error :messages="$errors->get('nombre')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="descripcion" value="Descripción" />
                            <textarea id="descripcion" name="descripcion"
                                rows="4"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">{{ old('descripcion', $proyecto->descripcion) }}</textarea>
                            <x-input-error :messages="$errors->get('descripcion')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="estado" value="Estado" />
                            <select id="estado" name="estado"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                @foreach (['activo', 'pausado', 'completado', 'cancelado'] as $opcion)
                                    <option value="{{ $opcion }}" {{ old('estado', $proyecto->estado) === $opcion ? 'selected' : '' }}>
                                        {{ ucfirst($opcion) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('estado')" class="mt-1" />
                        </div>

                        <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="fecha_inicio" value="Fecha de inicio" />
                                <x-text-input id="fecha_inicio" name="fecha_inicio" type="date"
                                    class="mt-1 block w-full"
                                    value="{{ old('fecha_inicio', $proyecto->fecha_inicio?->format('Y-m-d')) }}" />
                                <x-input-error :messages="$errors->get('fecha_inicio')" class="mt-1" />
                            </div>
                            <div>
                                <x-input-label for="fecha_fin_estimada" value="Fecha estimada de cierre" />
                                <x-text-input id="fecha_fin_estimada" name="fecha_fin_estimada" type="date"
                                    class="mt-1 block w-full"
                                    value="{{ old('fecha_fin_estimada', $proyecto->fecha_fin_estimada?->format('Y-m-d')) }}" />
                                <x-input-error :messages="$errors->get('fecha_fin_estimada')" class="mt-1" />
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-6">
                            <x-primary-button>Actualizar proyecto</x-primary-button>
                            <a href="{{ route('proyectos.show', $proyecto) }}">
                                <x-secondary-button type="button">Cancelar</x-secondary-button>
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
