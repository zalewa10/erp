<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\TaskTimeLog;
use Carbon\Carbon;

class TaskBoard extends Component
{
    protected $listeners = [
        'updateTaskOrder' => 'updateTaskOrder',
        'taskUpdated' => '$refresh',
        'taskStatusUpdated' => '$refresh',
    ];

    public function updateTaskOrder($payload, $status = null)
    {
        if (is_array($payload) && isset($payload['tasks']) && isset($payload['status'])) {
            $tasks = $payload['tasks'];
            $status = $payload['status'];
        } elseif (is_array($payload) && $status === null) {
            $tasks = $payload;
        } else {
            $tasks = $payload;
        }

        foreach ($tasks as $index => $taskId) {
            Task::where('id', $taskId)->update([
                'status' => $status,
                'sort_order' => $index,
            ]);
        }

        // NIE odświeżaj po drag & drop - Sortable już zaktualizował DOM
    }

    public function startWork($taskId)
    {
        logger()->info("StartWork called for task: {$taskId}");

        $task = Task::find($taskId);
        if (!$task) {
            logger()->error("Task not found: {$taskId}");
            return;
        }

        $active = TaskTimeLog::where('task_id', $taskId)
            ->whereNull('end_time')
            ->exists();

        if ($active) {
            logger()->info("Task {$taskId} already has active log");
            return;
        }

        TaskTimeLog::create([
            'task_id' => $taskId,
            'start_time' => Carbon::now(),
        ]);

        logger()->info("Started work on task: {$taskId}");

        // USUŃ $this->dispatch('$refresh')
        // Zamiast tego frontend sam się odświeży
    }

    public function stopWork($taskId)
    {
        logger()->info("StopWork called for task: {$taskId}");

        $task = Task::find($taskId);
        if (!$task) {
            logger()->error("Task not found: {$taskId}");
            return;
        }

        $log = TaskTimeLog::where('task_id', $taskId)
            ->whereNull('end_time')
            ->latest()
            ->first();

        if (!$log) {
            logger()->info("No active log found for task: {$taskId}");
            return;
        }

        $log->update([
            'end_time' => Carbon::now(),
            'duration_minutes' => Carbon::parse($log->start_time)->diffInMinutes(Carbon::now()),
        ]);

        logger()->info("Stopped work on task: {$taskId}");

        // USUŃ $this->dispatch('$refresh')
    }

    public function render()
    {
        $queue = Task::where('status', 'queue')
            ->orderBy('sort_order')
            ->get();

        $today = Task::where('status', 'today')
            ->orderBy('sort_order')
            ->get();

        $done = Task::where('status', 'done')
            ->orderBy('sort_order')
            ->get();

        foreach ([$queue, $today, $done] as $collection) {
            foreach ($collection as $task) {
                $task->total_minutes = (int) $task->totalMinutes();
                $task->total_hours = (float) $task->totalHours();
            }
        }

        $activeLogs = TaskTimeLog::whereNull('end_time')
            ->pluck('task_id')
            ->toArray();

        return view('livewire.task-board', [
            'queue' => $queue,
            'today' => $today,
            'done' => $done,
            'activeLogs' => $activeLogs,
        ]);
    }
}
