<?php

namespace App\Livewire\Tasks;

use Livewire\Component;
use App\Models\Task;
use App\Models\TaskTimeLog;
use Carbon\Carbon;

class TaskModal extends Component
{
    public $taskId;
    public $title;
    public $description;
    public $status;

    public $show = false;

    protected $listeners = [
        'openTask' => 'openTask',
        'open-task' => 'openTask',
        'startTask' => 'startTask',
        'stopTask' => 'stopTask',
    ];

    public function openTask($taskId)
    {
        $task = Task::find($taskId);

        if (!$task) return;

        $this->taskId = $task->id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->status = $task->status;
        $this->show = true;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required',
        ]);

        $task = Task::find($this->taskId);
        if (!$task) return;

        $task->update([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        $this->dispatch('taskUpdated');
        $this->close();
    }

    // start working on a task (from card button)
    public function startTask($payload = null)
    {
        $taskId = is_array($payload) ? ($payload['taskId'] ?? $payload[0] ?? null) : $payload;
        if (!$taskId) return;

        $task = Task::find($taskId);
        if (!$task) return;

        // if already active, do nothing
        $active = TaskTimeLog::where('task_id', $task->id)->whereNull('end_time')->first();
        if ($active) return;

        TaskTimeLog::create([
            'task_id' => $task->id,
            'start_time' => Carbon::now(),
        ]);

        $this->dispatch('taskUpdated');
    }

    // stop working on a task (from card button)
    public function stopTask($payload = null)
    {
        $taskId = is_array($payload) ? ($payload['taskId'] ?? $payload[0] ?? null) : $payload;
        if (!$taskId) return;

        $task = Task::find($taskId);
        if (!$task) return;

        $log = TaskTimeLog::where('task_id', $task->id)->whereNull('end_time')->latest()->first();
        if (!$log) return;

        $log->update([
            'end_time' => Carbon::now(),
            'duration_minutes' => Carbon::parse($log->start_time)->diffInMinutes(Carbon::now()),
        ]);

        $this->dispatch('taskUpdated');
    }




    public function close()
    {
        $this->show = false;
    }


    public function render()
    {
        return view('livewire.tasks.task-modal');
    }
}
