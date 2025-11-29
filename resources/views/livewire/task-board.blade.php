<div class="container mx-auto p-6">
    <livewire:tasks.task-modal />

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- W kolejce -->
        <div class="card bg-base-200 shadow-xl">
            <div class="card-body p-4">
                <h2 class="card-title text-lg mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    W kolejce
                    <span class="badge badge-neutral">{{ count($queue) }}</span>
                </h2>

                <ul id="queue" class="task-column space-y-3" data-status="queue">
                    @foreach ($queue as $task)
                        <li wire:key="queue-task-{{ $task->id }}" data-id="{{ $task->id }}"
                            class="task-item card bg-base-100 shadow-md hover:shadow-lg transition-shadow cursor-move">
                            <div class="card-body p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1 cursor-pointer"
                                        wire:click="$dispatch('open-task', { taskId: {{ $task->id }} })">
                                        <h3 class="font-semibold text-base">{{ $task->title }}</h3>
                                        <div class="flex items-center gap-2 mt-2">
                                            <div class="badge badge-ghost badge-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                @if ($task->total_minutes < 60)
                                                    {{ $task->total_minutes }} min
                                                @else
                                                    {{ $task->total_hours }} h
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if (in_array($task->id, $activeLogs))
                                            <button wire:click.stop="stopWork({{ $task->id }})" type="button"
                                                class="btn btn-error btn-sm btn-circle">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        @else
                                            <button wire:click.stop="startWork({{ $task->id }})" type="button"
                                                class="btn btn-success btn-sm btn-circle">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach

                    @if (count($queue) === 0)
                        <li class="text-center py-8 text-base-content/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2 opacity-30"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p class="text-sm">Brak zadań w kolejce</p>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Dzisiaj -->
        <div class="card bg-primary/10 shadow-xl border-2 border-primary/20">
            <div class="card-body p-4">
                <h2 class="card-title text-lg mb-4 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Dzisiaj
                    <span class="badge badge-primary">{{ count($today) }}</span>
                </h2>

                <ul id="today" class="task-column space-y-3" data-status="today">
                    @foreach ($today as $task)
                        <li wire:key="today-task-{{ $task->id }}" data-id="{{ $task->id }}"
                            class="task-item card bg-base-100 shadow-md hover:shadow-lg transition-shadow cursor-move border-l-4 border-primary">
                            <div class="card-body p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1 cursor-pointer"
                                        wire:click="$dispatch('open-task', { taskId: {{ $task->id }} })">
                                        <h3 class="font-semibold text-base">{{ $task->title }}</h3>
                                        <div class="flex items-center gap-2 mt-2">
                                            <div class="badge badge-primary badge-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                @if ($task->total_minutes < 60)
                                                    {{ $task->total_minutes }} min
                                                @else
                                                    {{ $task->total_hours }} h
                                                @endif
                                            </div>
                                            @if (in_array($task->id, $activeLogs))
                                                <div class="badge badge-error badge-sm gap-1 animate-pulse">
                                                    <span class="w-2 h-2 rounded-full bg-white"></span>
                                                    W trakcie
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if (in_array($task->id, $activeLogs))
                                            <button wire:click.stop="stopWork({{ $task->id }})" type="button"
                                                class="btn btn-error btn-sm btn-circle">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        @else
                                            <button wire:click.stop="startWork({{ $task->id }})" type="button"
                                                class="btn btn-success btn-sm btn-circle">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach

                    @if (count($today) === 0)
                        <li class="text-center py-8 text-base-content/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2 opacity-30"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="text-sm">Brak zadań na dziś</p>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Zakończone -->
        <div class="card bg-success/10 shadow-xl border-2 border-success/20">
            <div class="card-body p-4">
                <h2 class="card-title text-lg mb-4 text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Zakończone
                    <span class="badge badge-success">{{ count($done) }}</span>
                </h2>

                <ul id="done" class="task-column space-y-3" data-status="done">
                    @foreach ($done as $task)
                        <li wire:key="done-task-{{ $task->id }}"
                            class="task-item card bg-base-100 shadow-md hover:shadow-lg transition-shadow cursor-move opacity-75 hover:opacity-100"
                            data-id="{{ $task->id }}">
                            <div class="card-body p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1 cursor-pointer"
                                        wire:click="$dispatch('open-task', { taskId: {{ $task->id }} })">
                                        <h3 class="font-semibold text-base line-through text-base-content/70">
                                            {{ $task->title }}
                                        </h3>
                                        <div class="flex items-center gap-2 mt-2">
                                            <div class="badge badge-success badge-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                @if ($task->total_minutes < 60)
                                                    {{ $task->total_minutes }} min
                                                @else
                                                    {{ $task->total_hours }} h
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach

                    @if (count($done) === 0)
                        <li class="text-center py-8 text-base-content/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2 opacity-30"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            <p class="text-sm">Brak zakończonych zadań</p>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <!-- Sortable.js -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    @script
        <script>
            let sortableInstances = [];

            function initSortable() {
                sortableInstances.forEach(instance => {
                    if (instance && instance.destroy) {
                        instance.destroy();
                    }
                });
                sortableInstances = [];

                document.querySelectorAll('.task-column').forEach(column => {
                    const sortable = new Sortable(column, {
                        group: 'tasks',
                        animation: 150,
                        ghostClass: 'opacity-50',
                        dragClass: 'rotate-2',
                        onEnd: function(evt) {
                            const column = evt.to;
                            const status = column.dataset.status;
                            const tasks = Array.from(column.querySelectorAll('.task-item'))
                                .map(item => item.dataset.id);
                            $wire.call('updateTaskOrder', {
                                tasks,
                                status
                            });
                        }
                    });
                    sortableInstances.push(sortable);
                });

                console.log('Sortable initialized with', sortableInstances.length, 'instances');
            }

            initSortable();

            Livewire.on('task-status-changed', (data) => {
                $wire.$refresh();
                setTimeout(() => {
                    initSortable();
                }, 100);
            });
        </script>
    @endscript
</div>
