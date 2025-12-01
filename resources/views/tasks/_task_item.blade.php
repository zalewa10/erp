<li data-id="{{ $task->id }}" data-priority="{{ $task->priority['name'] ?? '' }} "
    class="task-item card bg-base-100 shadow-md hover:shadow-lg transition-shadow cursor-move border-l-2 
    {{ isset($task->priority)
        ? match ($task->priority->name) {
            'Niski' => 'border-l-green-500',
            'Średni' => 'border-l-yellow-500',
            'Wysoki' => 'border-l-red-500',
        }
        : 'border-l-gray-300' }}
   ">
    <div class="card-body p-4">
        <div class="flex items-start justify-between gap-3">
            <div class="flex-1 cursor-pointer open-task" data-id="{{ $task->id }}"
                data-title="{{ htmlspecialchars($task->title, ENT_QUOTES) }}"
                data-description="{{ htmlspecialchars($task->description ?? '', ENT_QUOTES) }}"
                data-status="{{ $task->status }}">
                <h3
                    class="font-semibold text-base {{ isset($isDone) && $isDone ? 'line-through text-base-content/70' : '' }}">
                    {{ $task->title }}</h3>
                <div class="flex items-center gap-2 mt-2">
                    <div class="badge badge-ghost badge-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        @if ($task->total_minutes < 60)
                            {{ $task->total_minutes }} min
                        @else
                            {{ $task->total_hours }} h
                        @endif
                    </div>
                    @if (!(isset($isDone) && $isDone) && in_array($task->id, $activeLogs))
                        <div class="badge badge-error badge-sm gap-1 animate-pulse">
                            <span class="w-2 h-2 rounded-full bg-white"></span>W trakcie
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex-shrink-0">
                @if (!(isset($isDone) && $isDone))
                    @if (in_array($task->id, $activeLogs))
                        <button data-action="stop" data-id="{{ $task->id }}" type="button"
                            class="btn btn-error btn-sm btn-circle task-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    @else
                        <button data-action="start" data-id="{{ $task->id }}" type="button"
                            class="btn btn-success btn-sm btn-circle task-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</li>
