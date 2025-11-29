<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\TaskTimeLog;
use Carbon\Carbon;

class TaskDetails extends Component
{
    public $task;

    public function mount(Task $task)
    {
        $this->task = $task;
    }

    public function startWork()
    {
        TaskTimeLog::create([
            'task_id' => $this->task->id,
            'start_time' => Carbon::now(),
        ]);

        $this->task->refresh();
    }

    public function stopWork()
    {
        $log = $this->task->activeLog()->first();

        if ($log) {
            $log->update([
                'end_time' => Carbon::now(),
                'duration_minutes' => Carbon::parse($log->start_time)
                    ->diffInMinutes(Carbon::now()),
            ]);
        }

        $this->task->refresh();
    }

    public function render()
    {
        return view('livewire.task-details');
    }
    public function getTotalTimeProperty()
    {
        return $this->task->totalMinutes();
    }

    public function getTotalHoursProperty()
    {
        return $this->task->totalHours();
    }
}
