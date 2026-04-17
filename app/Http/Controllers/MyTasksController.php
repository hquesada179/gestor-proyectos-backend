<?php

namespace App\Http\Controllers;

use App\Models\Sprint;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;

class MyTasksController extends Controller
{
    public function index()
    {
        $sprintFiltro = request('sprint', 'todos');
        $estadoFiltro = request('estado', 'todos');

        $sprintsDisponibles = Sprint::whereHas(
            'proyecto', fn($q) => $q->where('user_id', Auth::id())
        )->orderBy('nombre')->get();

        $estadosDisponibles = TaskStatus::orderBy('orden')->get();

        $tasksQuery = Task::where('assigned_to', Auth::id())
            ->with('proyecto', 'status', 'sprint');

        if ($sprintFiltro === 'sin_sprint') {
            $tasksQuery->whereNull('sprint_id');
        } elseif ($sprintFiltro !== 'todos' && is_numeric($sprintFiltro)) {
            $tasksQuery->where('sprint_id', (int) $sprintFiltro);
        }

        if ($estadoFiltro !== 'todos' && is_numeric($estadoFiltro)) {
            $tasksQuery->where('task_status_id', (int) $estadoFiltro);
        }

        $tasks = $tasksQuery->orderBy('fecha_limite')->paginate(20)->withQueryString();

        return view('mis-tareas', compact(
            'tasks',
            'sprintFiltro', 'sprintsDisponibles',
            'estadoFiltro', 'estadosDisponibles'
        ));
    }
}
