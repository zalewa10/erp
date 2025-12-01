<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Priority;
use App\Models\Project;
use App\Models\TaskTimeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['priority', 'assignedUser'])
            ->orderBy('id', 'desc')
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show Kanban board
     */
    public function board()
    {
        $priorities = Priority::all();
        $queue = Task::where('status', 'queue')->orderBy('sort_order')->get();
        $today = Task::where('status', 'today')->orderBy('sort_order')->get();
        $done = Task::where('status', 'done')->orderBy('sort_order')->get();

        foreach ([$queue, $today, $done] as $collection) {
            foreach ($collection as $task) {
                $task->total_minutes = (int) $task->totalMinutes();
                $task->total_hours = (float) $task->totalHours();
                $task->priority = $priorities->find($task->priority_id);
            }
        }

        $activeLogs = TaskTimeLog::whereNull('end_time')->pluck('task_id')->toArray();

        return view('tasks.index', compact('queue', 'today', 'done', 'activeLogs', 'priorities'));
    }

    public function startWork($id)
    {
        $task = Task::find($id);
        if (!$task) return response()->json(['error' => 'Not found'], 404);

        $active = TaskTimeLog::where('task_id', $id)->whereNull('end_time')->exists();
        if ($active) return response()->json(['status' => 'already_active']);

        TaskTimeLog::create(['task_id' => $id, 'start_time' => Carbon::now()]);
        return response()->json(['status' => 'started']);
    }

    public function stopWork($id)
    {
        $task = Task::find($id);
        if (!$task) return response()->json(['error' => 'Not found'], 404);

        $log = TaskTimeLog::where('task_id', $id)->whereNull('end_time')->latest()->first();
        if (!$log) return response()->json(['error' => 'no_active_log'], 400);

        $log->update([
            'end_time' => Carbon::now(),
            'duration_minutes' => Carbon::parse($log->start_time)->diffInMinutes(Carbon::now()),
        ]);

        return response()->json(['status' => 'stopped']);
    }

    public function updateOrder(Request $request)
    {
        $data = $request->all();
        $tasks = $data['tasks'] ?? [];
        $status = $data['status'] ?? null;

        foreach ($tasks as $index => $taskId) {
            Task::where('id', $taskId)->update(['status' => $status, 'sort_order' => $index]);
        }

        return response()->json(['status' => 'ok']);
    }
    public function create()
    {
        return view('tasks.create', [
            'priorities' => Priority::all(),
            'users' => \App\Models\User::all(),
            'projects' => Project::orderBy('name')->get()
        ]);
    }

    public function delete($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Zadanie zostało usunięte!');
    }

    public function store(Request $request)
    {
        // walidacja
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'project_id' => 'nullable|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'priority_id' => 'nullable|exists:priorities,id',
            'due_date' => 'nullable|date',
        ]);

        // dodajemy, kto stworzył zadanie (jeśli masz login)
        $validated['created_by'] = Auth::id();

        // zapis do bazy
        Task::create($validated);
        return redirect()->route('tasks.index')->with('success', 'Zadanie zostało utworzone!');
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        // walidacja
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'project_id' => 'nullable|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'priority_id' => 'nullable|exists:priorities,id',
            'due_date' => 'nullable|date',
            'status' => 'nullable|string',
        ]);

        // aktualizacja zadania
        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Zadanie zostało zaktualizowane!');
    }
}
