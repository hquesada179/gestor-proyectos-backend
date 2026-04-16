<?php

use App\Http\Controllers\MyTasksController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectInputController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserStoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/mis-tareas', [MyTasksController::class, 'index'])->name('mis-tareas');

    Route::resource('proyectos', ProyectoController::class);
    Route::resource('proyectos.inputs', ProjectInputController::class);
    Route::resource('proyectos.requirements', RequirementController::class);
    Route::resource('proyectos.requirements.user-stories', UserStoryController::class);
    Route::get('proyectos/{proyecto}/tasks/export', [TaskController::class, 'export'])->name('proyectos.tasks.export');
    Route::resource('proyectos.tasks', TaskController::class);
    Route::resource('proyectos.sprints', SprintController::class);
});

require __DIR__.'/auth.php';
