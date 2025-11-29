<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;

class TaskBoard extends Component
{
    public $queue;
    public $today;
    public $done;
    protected $listeners = [
        'updateTaskOrder' => 'updateTaskOrder',
        'taskUpdated' => 'refreshTasks'
    ];
    public function mount()
    {
        $this->loadTasks();
    }

    public function loadTasks()
    {
        $this->queue = Task::where('status', 'queue')->orderBy('sort_order')->get();
        $this->today = Task::where('status', 'today')->orderBy('sort_order')->get();
        $this->done  = Task::where('status', 'done')->orderBy('sort_order')->get();
    }
    public function refreshTasks()
    {
        $this->loadTasks();
    }

    public function updateTaskOrder($tasks, $status)
    {
        foreach ($tasks as $index => $taskId) {
            Task::where('id', $taskId)->update([
                'status' => $status,
                'sort_order' => $index,
            ]);
        }

        $this->loadTasks();
    }

    public function render()
    {
        return view('livewire.task-board');
    }
}
