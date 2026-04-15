<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Requirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequirementController extends Controller
{
    public function index(Proyecto $proyecto)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);

        $requirements = $proyecto->requirements()->latest()->get();

        return view('proyectos.requirements.index', compact('proyecto', 'requirements'));
    }

    public function create(Proyecto $proyecto)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);

        return view('proyectos.requirements.create', compact('proyecto'));
    }

    public function store(Request $request, Proyecto $proyecto)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);

        $validated = $request->validate(
            $this->rules(),
            $this->messages()
        );

        $proyecto->requirements()->create($validated);

        return redirect()->route('proyectos.requirements.index', $proyecto)
            ->with('success', 'Requerimiento agregado correctamente.');
    }

    public function show(Proyecto $proyecto, Requirement $requirement)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);
        abort_if($requirement->proyecto_id !== $proyecto->id, 404);

        return view('proyectos.requirements.show', compact('proyecto', 'requirement'));
    }

    public function edit(Proyecto $proyecto, Requirement $requirement)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);
        abort_if($requirement->proyecto_id !== $proyecto->id, 404);

        return view('proyectos.requirements.edit', compact('proyecto', 'requirement'));
    }

    public function update(Request $request, Proyecto $proyecto, Requirement $requirement)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);
        abort_if($requirement->proyecto_id !== $proyecto->id, 404);

        $validated = $request->validate(
            $this->rules(),
            $this->messages()
        );

        $requirement->update($validated);

        return redirect()->route('proyectos.requirements.show', [$proyecto, $requirement])
            ->with('success', 'Requerimiento actualizado correctamente.');
    }

    public function destroy(Proyecto $proyecto, Requirement $requirement)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);
        abort_if($requirement->proyecto_id !== $proyecto->id, 404);

        $requirement->delete();

        return redirect()->route('proyectos.requirements.index', $proyecto)
            ->with('success', 'Requerimiento eliminado correctamente.');
    }

    private function rules(): array
    {
        return [
            'codigo'      => ['nullable', 'string', 'max:50'],
            'titulo'      => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:5000'],
            'tipo'        => ['required', 'string', 'in:funcional,no_funcional'],
            'prioridad'   => ['required', 'string', 'in:alta,media,baja'],
        ];
    }

    private function messages(): array
    {
        return [
            'titulo.required'      => 'El título es obligatorio.',
            'titulo.max'           => 'El título no puede superar los 255 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.max'      => 'La descripción no puede superar los 5000 caracteres.',
            'codigo.max'           => 'El código no puede superar los 50 caracteres.',
            'tipo.required'        => 'El tipo es obligatorio.',
            'tipo.in'              => 'El tipo debe ser funcional o no funcional.',
            'prioridad.required'   => 'La prioridad es obligatoria.',
            'prioridad.in'         => 'La prioridad debe ser alta, media o baja.',
        ];
    }
}
