<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class MyTasksController extends Controller
{
    public function index()
    {
        $tasks = Task::where('assigned_to', Auth::id())
            ->with('proyecto', 'status', 'sprint')
            ->orderBy('fecha_limite')
            ->paginate(20)
            ->withQueryString();

        return view('mis-tareas', compact('tasks'));
    }
}
