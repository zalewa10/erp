<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Client;
use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['client', 'priority', 'assignedUser'])
            ->orderBy('id', 'desc')
            ->get();

        return view('tasks.board', compact('tasks'));
    }
    public function create()
    {
        return view('tasks.create', [
            'clients' => Client::all(),
            'priorities' => Priority::all(),
            'users' => \App\Models\User::all()
        ]);
    }

    public function store(Request $request)
    {
        // walidacja
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'client_id' => 'nullable|exists:clients,id',
            'assigned_to' => 'nullable|exists:users,id',
            'priority_id' => 'nullable|exists:priorities,id',
            'due_date' => 'nullable|date',
            'amount' => 'nullable|numeric',
        ]);

        // dodajemy, kto stworzył zadanie (jeśli masz login)
        $validated['created_by'] = Auth::id();

        // zapis do bazy
        Task::create($validated);

        return redirect('/tasks/create')->with('success', 'Zadanie zostało utworzone!');
    }
}
