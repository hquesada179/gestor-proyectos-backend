<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Requirement;
use App\Models\UserStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserStoryController extends Controller
{
    public function index(Proyecto $proyecto, Requirement $requirement)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);
        abort_if($requirement->proyecto_id !== $proyecto->id, 404);

        $userStories = $requirement->userStories()->latest()->get();

        return view('proyectos.requirements.user-stories.index', compact('proyecto', 'requirement', 'userStories'));
    }

    public function create(Proyecto $proyecto, Requirement $requirement)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);
        abort_if($requirement->proyecto_id !== $proyecto->id, 404);

        return view('proyectos.requirements.user-stories.create', compact('proyecto', 'requirement'));
    }

    public function store(Request $request, Proyecto $proyecto, Requirement $requirement)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);
        abort_if($requirement->proyecto_id !== $proyecto->id, 404);

        $validated = $request->validate(
            $this->rules(),
            $this->messages()
        );

        $requirement->userStories()->create($validated);

        return redirect()->route('proyectos.requirements.user-stories.index', [$proyecto, $requirement])
            ->with('success', 'Historia de usuario agregada correctamente.');
    }

    public function show(Proyecto $proyecto, Requirement $requirement, UserStory $userStory)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);
        abort_if($requirement->proyecto_id !== $proyecto->id, 404);
        abort_if($userStory->requirement_id !== $requirement->id, 404);

        return view('proyectos.requirements.user-stories.show', compact('proyecto', 'requirement', 'userStory'));
    }

    public function edit(Proyecto $proyecto, Requirement $requirement, UserStory $userStory)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);
        abort_if($requirement->proyecto_id !== $proyecto->id, 404);
        abort_if($userStory->requirement_id !== $requirement->id, 404);

        return view('proyectos.requirements.user-stories.edit', compact('proyecto', 'requirement', 'userStory'));
    }

    public function update(Request $request, Proyecto $proyecto, Requirement $requirement, UserStory $userStory)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);
        abort_if($requirement->proyecto_id !== $proyecto->id, 404);
        abort_if($userStory->requirement_id !== $requirement->id, 404);

        $validated = $request->validate(
            $this->rules(),
            $this->messages()
        );

        $userStory->update($validated);

        return redirect()->route('proyectos.requirements.user-stories.show', [$proyecto, $requirement, $userStory])
            ->with('success', 'Historia de usuario actualizada correctamente.');
    }

    public function destroy(Proyecto $proyecto, Requirement $requirement, UserStory $userStory)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);
        abort_if($requirement->proyecto_id !== $proyecto->id, 404);
        abort_if($userStory->requirement_id !== $requirement->id, 404);

        $userStory->delete();

        return redirect()->route('proyectos.requirements.user-stories.index', [$proyecto, $requirement])
            ->with('success', 'Historia de usuario eliminada correctamente.');
    }

    private function rules(): array
    {
        return [
            'titulo'                 => ['required', 'string', 'max:255'],
            'como_usuario'           => ['nullable', 'string', 'max:500'],
            'quiero'                 => ['nullable', 'string', 'max:500'],
            'para_poder'             => ['nullable', 'string', 'max:500'],
            'criterios_aceptacion'   => ['nullable', 'string', 'max:5000'],
            'prioridad'              => ['required', 'string', 'in:alta,media,baja'],
        ];
    }

    private function messages(): array
    {
        return [
            'titulo.required'    => 'El título es obligatorio.',
            'titulo.max'         => 'El título no puede superar los 255 caracteres.',
            'prioridad.required' => 'La prioridad es obligatoria.',
            'prioridad.in'       => 'La prioridad debe ser alta, media o baja.',
        ];
    }
}
