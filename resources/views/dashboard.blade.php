<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel principal
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-1">
                        Bienvenido, {{ Auth::user()->name }}
                    </h3>
                    <p class="text-gray-600 text-sm">
                        Este es el sistema de gestión de proyectos. Desde aquí podrás registrar tus proyectos, cargar sus insumos y generar los artefactos de gestión correspondientes.
                    </p>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500">Proyectos</p>
                    <p class="mt-1 text-2xl font-bold text-gray-800">—</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500">Requerimientos</p>
                    <p class="mt-1 text-2xl font-bold text-gray-800">—</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500">Tareas activas</p>
                    <p class="mt-1 text-2xl font-bold text-gray-800">—</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
