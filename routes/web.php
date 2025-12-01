<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Models\Task;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::get('/dashboard', [TaskController::class, 'board'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::delete('/tasks/delete/{id}', [TaskController::class, 'delete'])->name('tasks.delete');
    Route::get('/tasks/board', [TaskController::class, 'board'])->name('tasks.index');
    Route::post('/tasks/{id}/start', [TaskController::class, 'startWork'])->name('tasks.start');
    Route::post('/tasks/{id}/stop', [TaskController::class, 'stopWork'])->name('tasks.stop');
    Route::post('/tasks/order', [TaskController::class, 'updateOrder'])->name('tasks.order');
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');

    Route::resource('projects', ProjectController::class);
});



require __DIR__ . '/auth.php';
