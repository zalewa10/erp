<?php

namespace App\Livewire\Tasks;

use Livewire\Component;
use App\Models\Task;

class TaskModal extends Component
{
    public $taskId;
    public $title;
    public $description;
    public $status;

    public $show = false;

    protected $listeners = ['open-task' => 'openTask'];

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




    public function close()
    {
        $this->show = false;
    }


    public function render()
    {
        return view('livewire.tasks.task-modal');
    }
}
