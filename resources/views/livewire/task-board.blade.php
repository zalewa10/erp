<div class="flex gap-4">
    <livewire:tasks.task-modal />

    <!-- W kolejce -->
    <div class="w-1/3 bg-gray-100 p-4 rounded">
        <h2 class="font-bold">W kolejce</h2>

        <ul id="queue" class="task-column" data-status="queue">
            @foreach ($queue as $task)
                <li class="task-item" data-id="{{ $task->id }}"
                    wire:click="$dispatch('open-task', { taskId: {{ $task->id }} })">
                    {{ $task->title }}
                </li>
            @endforeach

        </ul>
    </div>

    <!-- Dzisiaj -->
    <div class="w-1/3 bg-gray-100 p-4 rounded">
        <h2 class="font-bold">Dzisiaj</h2>

        <ul id="today" class="task-column" data-status="today">
            @foreach ($today as $task)
                <li class="task-item" data-id="{{ $task->id }}"
                    wire:click="$dispatch('open-task', { taskId: {{ $task->id }} })">
                    {{ $task->title }}
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Zakończone -->
    <div class="w-1/3 bg-gray-100 p-4 rounded">
        <h2 class="font-bold">Zakończone</h2>

        <ul id="done" class="task-column" data-status="done">
            @foreach ($done as $task)
                <li class="task-item" data-id="{{ $task->id }}"
                    wire:click="$dispatch('open-task', { taskId: {{ $task->id }} })">
                    {{ $task->title }}
                </li>
            @endforeach
        </ul>
    </div>


    <!-- Sortable.js -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        document.querySelectorAll('.task-column').forEach(column => {
            new Sortable(column, {
                group: 'tasks',
                animation: 150,
                onEnd: function(evt) {
                    const column = evt.to;
                    const status = column.dataset.status;

                    const tasks = Array.from(column.querySelectorAll('.task-item'))
                        .map(item => item.dataset.id);

                    Livewire.dispatch('updateTaskOrder', {
                        tasks,
                        status
                    });
                }
            });
        });
    </script>

</div>
