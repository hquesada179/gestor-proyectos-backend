<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs text-gray-500 mb-1">
                <a href="{{ route('proyectos.inputs.show', [$proyecto, $input]) }}" class="hover:text-indigo-600">
                    {{ $proyecto->nombre }} › Insumos › {{ $input->titulo }}
                </a>
            </p>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar insumo
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('proyectos.inputs.update', [$proyecto, $input]) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <x-input-label for="tipo" value="Tipo de insumo" />
                            <select id="tipo" name="tipo"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                @foreach (['documento', 'entrevista', 'observacion', 'reunion', 'otro'] as $opcion)
                                    <option value="{{ $opcion }}" {{ old('tipo', $input->tipo) === $opcion ? 'selected' : '' }}>
                                        {{ ucfirst($opcion) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('tipo')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="titulo" value="Título" />
                            <x-text-input id="titulo" name="titulo" type="text"
                                class="mt-1 block w-full"
                                value="{{ old('titulo', $input->titulo) }}"
                                required autofocus />
                            <x-input-error :messages="$errors->get('titulo')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="contenido" value="Contenido" />
                            <textarea id="contenido" name="contenido"
                                rows="6"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">{{ old('contenido', $input->contenido) }}</textarea>
                            <x-input-error :messages="$errors->get('contenido')" class="mt-1" />
                        </div>

                        <div class="flex items-center gap-3 mt-6">
                            <x-primary-button>Actualizar insumo</x-primary-button>
                            <a href="{{ route('proyectos.inputs.show', [$proyecto, $input]) }}">
                                <x-secondary-button type="button">Cancelar</x-secondary-button>
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
