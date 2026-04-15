<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Proyecto $proyecto)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);

        $tasks = $proyecto->tasks()->with('status')->latest()->get();

        return view('proyectos.tasks.index', compact('proyecto', 'tasks'));
    }

    public function create(Proyecto $proyecto)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);

        $statuses    = TaskStatus::orderBy('orden')->get();
        $userStories = $this->userStoriesForProject($proyecto);

        return view('proyectos.tasks.create', compact('proyecto', 'statuses', 'userStories'));
    }

    public function store(Request $request, Proyecto $proyecto)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);

        $validated = $request->validate(
            $this->rules($proyecto),
            $this->messages()
        );

        $proyecto->tasks()->create($validated);

        return redirect()->route('proyectos.tasks.index', $proyecto)
            ->with('success', 'Tarea creada correctamente.');
    }

    public function show(Proyecto $proyecto, Task $task)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);
        abort_if($task->proyecto_id !== $proyecto->id, 404);

        $task->load('status', 'userStory');

        return view('proyectos.tasks.show', compact('proyecto', 'task'));
    }

    public function edit(Proyecto $proyecto, Task $task)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);
        abort_if($task->proyecto_id !== $proyecto->id, 404);

        $statuses    = TaskStatus::orderBy('orden')->get();
        $userStories = $this->userStoriesForProject($proyecto);

        return view('proyectos.tasks.edit', compact('proyecto', 'task', 'statuses', 'userStories'));
    }

    public function update(Request $request, Proyecto $proyecto, Task $task)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);
        abort_if($task->proyecto_id !== $proyecto->id, 404);

        $validated = $request->validate(
            $this->rules($proyecto),
            $this->messages()
        );

        $task->update($validated);

        return redirect()->route('proyectos.tasks.show', [$proyecto, $task])
            ->with('success', 'Tarea actualizada correctamente.');
    }

    public function destroy(Proyecto $proyecto, Task $task)
    {
        abort_if($proyecto->user_id !== Auth::id(), 403);
        abort_if($task->proyecto_id !== $proyecto->id, 404);

        $task->delete();

        return redirect()->route('proyectos.tasks.index', $proyecto)
            ->with('success', 'Tarea eliminada correctamente.');
    }

    private function rules(Proyecto $proyecto): array
    {
        $userStoryIds = $this->userStoriesForProject($proyecto)->pluck('id')->implode(',');

        return [
            'titulo'         => ['required', 'string', 'max:255'],
            'descripcion'    => ['nullable', 'string', 'max:5000'],
            'task_status_id' => ['required', 'exists:task_statuses,id'],
            'user_story_id'  => ['nullable', 'exists:user_stories,id'],
            'fecha_limite'   => ['nullable', 'date'],
        ];
    }

    private function messages(): array
    {
        return [
            'titulo.required'         => 'El título es obligatorio.',
            'titulo.max'              => 'El título no puede superar los 255 caracteres.',
            'task_status_id.required' => 'El estado es obligatorio.',
            'task_status_id.exists'   => 'El estado seleccionado no es válido.',
            'user_story_id.exists'    => 'La historia de usuario seleccionada no es válida.',
            'fecha_limite.date'       => 'La fecha límite no tiene un formato válido.',
        ];
    }

    private function userStoriesForProject(Proyecto $proyecto)
    {
        return \App\Models\UserStory::whereHas('requirement', function ($q) use ($proyecto) {
            $q->where('proyecto_id', $proyecto->id);
        })->get();
    }
}
