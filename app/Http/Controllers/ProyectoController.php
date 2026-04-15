<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProyectoController extends Controller
{
    public function index()
    {
        $proyectos = Auth::user()->proyectos()->latest()->get();

        return view('proyectos.index', compact('proyectos'));
    }

    public function create()
    {
        return view('proyectos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'             => ['required', 'string', 'max:255'],
            'descripcion'        => ['nullable', 'string'],
            'estado'             => ['required', 'string', 'in:activo,pausado,completado,cancelado'],
            'fecha_inicio'       => ['nullable', 'date'],
            'fecha_fin_estimada' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
        ]);

        $proyecto = Auth::user()->proyectos()->create($validated);

        return redirect()->route('proyectos.show', $proyecto)
            ->with('success', 'Proyecto creado correctamente.');
    }

    public function show(Proyecto $proyecto)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);

        return view('proyectos.show', compact('proyecto'));
    }

    public function edit(Proyecto $proyecto)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);

        return view('proyectos.edit', compact('proyecto'));
    }

    public function update(Request $request, Proyecto $proyecto)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'nombre'             => ['required', 'string', 'max:255'],
            'descripcion'        => ['nullable', 'string'],
            'estado'             => ['required', 'string', 'in:activo,pausado,completado,cancelado'],
            'fecha_inicio'       => ['nullable', 'date'],
            'fecha_fin_estimada' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
        ]);

        $proyecto->update($validated);

        return redirect()->route('proyectos.show', $proyecto)
            ->with('success', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Proyecto $proyecto)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);

        $proyecto->delete();

        return redirect()->route('proyectos.index')
            ->with('success', 'Proyecto eliminado correctamente.');
    }
}
