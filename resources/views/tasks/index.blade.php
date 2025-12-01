<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kanban') }}
            </h2>
            <a href="/tasks/create" class="btn btn-primary">+ Dodaj nowe zadanie</a>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 mb-4 rounded container mx-auto mt-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container mx-auto p-6">

                <!-- Traditional task modal -->
                <div id="task-modal" class="modal" aria-hidden="true">
                    <div class="modal-box relative w-full max-w-md">
                        <button type="button" class="btn btn-sm btn-ghost btn-circle absolute right-3 top-3"
                            aria-label="Zamknij" id="task-modal-close">✕</button>
                        <h3 id="task-modal-title" class="font-bold text-lg mb-3">Szczegóły zadania</h3>

                        <form id="task-modal-form" method="POST" action="">
                            @csrf
                            @method('PUT')
                            <div class="form-control mb-3">
                                <label class="label"><span class="label-text">Tytuł</span></label>
                                <input type="text" name="title" id="task-title" class="input input-bordered w-full"
                                    required />
                            </div>
                            <div class="form-control mb-3">
                                <label class="label"><span class="label-text">Opis</span></label>
                                <textarea name="description" id="task-description" class="textarea textarea-bordered w-full h-28"></textarea>
                            </div>
                            <div class="form-control mb-3">
                                <label class="label"><span class="label-text">Status</span></label>
                                <select name="status" id="task-status" class="select select-bordered w-full">
                                    <option value="queue">W kolejce</option>
                                    <option value="today">Dzisiaj</option>
                                    <option value="done">Zakończone</option>
                                </select>
                            </div>
                            <div class="form-control mb-3">
                                <label class="label"><span class="label-text">Priorytet</span></label>
                                <select name="priority_id" id="task-priority" class="select select-bordered w-full">
                                    <option value="">Brak priorytetu</option>
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="modal-action mt-2">
                                <button type="button" id="task-delete-btn" class="btn btn-error">Usuń</button>
                                <button type="button" id="task-cancel" class="btn">Anuluj</button>
                                <form method="POST" id="task-edit-form" action="" style="display: none;">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" id="task-submit" class="btn btn-primary">Zapisz</button>
                                </form>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- W kolejce -->
                    <div class="card bg-base-200 shadow-xl">
                        <div class="card-body p-4">
                            <h2 class="card-title text-lg mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                W kolejce
                                <span class="badge badge-neutral">{{ count($queue) }}</span>
                            </h2>

                            <ul id="queue" class="task-column space-y-3" data-status="queue">
                                @foreach ($queue as $task)
                                    @include('tasks._task_item', [
                                        'task' => $task,
                                        'activeLogs' => $activeLogs,
                                        'isDone' => false,
                                    ])
                                @endforeach

                                @if (count($queue) === 0)
                                    <li class="text-center py-8 text-base-content/50">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-12 w-12 mx-auto mb-2 opacity-30" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Dzisiaj
                                <span class="badge badge-primary">{{ count($today) }}</span>
                            </h2>

                            <ul id="today" class="task-column space-y-3" data-status="today">
                                @foreach ($today as $task)
                                    @include('tasks._task_item', [
                                        'task' => $task,
                                        'activeLogs' => $activeLogs,
                                        'isDone' => false,
                                    ])
                                @endforeach

                                @if (count($today) === 0)
                                    <li class="text-center py-8 text-base-content/50">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-12 w-12 mx-auto mb-2 opacity-30" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Zakończone
                                <span class="badge badge-success">{{ count($done) }}</span>
                            </h2>

                            <ul id="done" class="task-column space-y-3" data-status="done">
                                @foreach ($done as $task)
                                    @include('tasks._task_item', [
                                        'task' => $task,
                                        'activeLogs' => $activeLogs,
                                        'isDone' => true,
                                    ])
                                @endforeach

                                @if (count($done) === 0)
                                    <li class="text-center py-8 text-base-content/50">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-12 w-12 mx-auto mb-2 opacity-30" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
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

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        let sortableInstances = [];

                        function initSortable() {
                            sortableInstances.forEach(i => i && i.destroy && i.destroy());
                            sortableInstances = [];
                            document.querySelectorAll('.task-column').forEach(column => {
                                const sortable = new Sortable(column, {
                                    group: 'tasks',
                                    animation: 150,
                                    ghostClass: 'opacity-50',
                                    dragClass: 'rotate-2',
                                    onEnd: function(evt) {
                                        const to = evt.to;
                                        const status = to.dataset.status;
                                        const tasks = Array.from(to.querySelectorAll('.task-item')).map(
                                            item => item.dataset.id);
                                        fetch('{{ route('tasks.order') }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({
                                                tasks,
                                                status
                                            })
                                        }).then(() => console.log('order updated'));
                                    }
                                });
                                sortableInstances.push(sortable);
                            });
                        }
                        initSortable();

                        // actions: start/stop
                        document.querySelectorAll('.task-action-btn').forEach(btn => btn.addEventListener('click', async (
                            e) => {
                            const id = btn.dataset.id;
                            const action = btn.dataset.action;
                            const url = action === 'start' ? '{{ url('/tasks') }}/' + id + '/start' :
                                '{{ url('/tasks') }}/' + id + '/stop';
                            await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            });
                            location.reload();
                        }));

                        // modal openers
                        const modal = document.getElementById('task-modal');
                        const closeBtn = document.getElementById('task-modal-close');
                        const cancelBtn = document.getElementById('task-cancel');
                        const form = document.getElementById('task-modal-form');
                        const titleInput = document.getElementById('task-title');
                        const descInput = document.getElementById('task-description');
                        const statusInput = document.getElementById('task-status');
                        const deleteBtn = document.getElementById('task-delete-btn');

                        function openModal() {
                            modal.classList.add('modal-open');
                            modal.setAttribute('aria-hidden', 'false');
                        }

                        function closeModal() {
                            modal.classList.remove('modal-open');
                            modal.setAttribute('aria-hidden', 'true');
                        }

                        document.querySelectorAll('.open-task').forEach(el => el.addEventListener('click', () => {
                            const id = el.dataset.id;
                            titleInput.value = el.dataset.title || '';
                            descInput.value = el.dataset.description || '';
                            statusInput.value = el.dataset.status || 'queue';
                            form.action = '/tasks/' + id;
                            deleteBtn.dataset.taskId = id;
                            openModal();
                        }));

                        if (closeBtn) closeBtn.addEventListener('click', closeModal);
                        if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

                        const submitBtn = document.getElementById('task-submit');
                        if (submitBtn) submitBtn.addEventListener('click', () => {
                            form.submit();
                        });

                        if (deleteBtn) deleteBtn.addEventListener('click', () => {
                            const id = deleteBtn.dataset.taskId;
                            const delForm = document.createElement('form');
                            delForm.method = 'POST';
                            delForm.action = '/tasks/delete/' + id;
                            delForm.style.display = 'none';
                            const csrf = document.createElement('input');
                            csrf.name = '_token';
                            csrf.value = '{{ csrf_token() }}';
                            delForm.appendChild(csrf);
                            const method = document.createElement('input');
                            method.name = '_method';
                            method.value = 'DELETE';
                            delForm.appendChild(method);
                            document.body.appendChild(delForm);
                            delForm.submit();
                        });

                        // backdrop click
                        if (modal) modal.addEventListener('click', (e) => {
                            if (e.target === modal) closeModal();
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
