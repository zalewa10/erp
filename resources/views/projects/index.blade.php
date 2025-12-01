<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Lista projektów') }}
            </h2>
            <a href="{{ route('projects.create') }}" class="btn btn-primary">+ Nowy projekt</a>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 mb-4 rounded container mx-auto mt-6">
            {{ session('success') }}
        </div>
    @endif
    <!-- Traditional modal (no Livewire) -->
    <div id="project-modal" class="modal" aria-hidden="true">
        <div class="modal-box relative w-full max-w-lg">
            <button type="button" class="btn btn-sm btn-ghost btn-circle absolute right-3 top-3" aria-label="Zamknij"
                id="project-modal-close">✕</button>

            <h3 id="project-modal-title" class="font-bold text-lg mb-3">Edytuj projekt</h3>

            <form id="project-modal-form" method="POST" action="">
                @csrf
                @method('PUT')

                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Nazwa</span></label>
                    <input type="text" name="name" id="project-name" class="input input-bordered w-full"
                        required />
                </div>

                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Klient</span></label>
                    <select name="client_id" id="project-client" class="select select-bordered w-full">
                        <option value="">Brak klienta</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Kwota (PLN)</span></label>
                    <input type="number" step="0.01" name="amount" id="project-amount"
                        class="input input-bordered w-full" />
                </div>

                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Opis</span></label>
                    <textarea name="description" id="project-description" class="textarea textarea-bordered w-full h-28"></textarea>
                </div>

                <div class="modal-action mt-2">
                    <button type="button" id="project-delete-btn" class="btn btn-error">Usuń</button>
                    <button type="button" id="project-cancel" class="btn">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                </div>
            </form>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">



            <div class="grid gap-4">
                @foreach ($projects as $project)
                    <div class="card bg-base-100 shadow">
                        <div class="card-body">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <h2 class="card-title">{{ $project->name }}</h2>
                                        <span
                                            class="badge badge-ghost">{{ $project->client->name ?? 'Brak klienta' }}</span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">Kwota: <strong>{{ $project->amount }}
                                            PLN</strong></p>
                                </div>
                                <button class="btn" popovertarget="{{ $project->id }}"
                                    style="anchor-name:--anchor-{{ $project->id }}">
                                    Ustawienia
                                </button>
                                <ul class="dropdown menu w-max rounded-box bg-base-100 shadow-sm " popover
                                    id="{{ $project->id }}" style="position-anchor:--anchor-{{ $project->id }}">
                                    <li>
                                        <button class="btn btn-soft mb-1 open-project" type="button"
                                            data-id="{{ $project->id }}"
                                            data-name="{{ htmlspecialchars($project->name, ENT_QUOTES) }}"
                                            data-client="{{ $project->client_id }}"
                                            data-amount="{{ $project->amount }}"
                                            data-description="{{ htmlspecialchars($project->description ?? '', ENT_QUOTES) }}">
                                            Edytuj
                                        </button>
                                    </li>
                                    <li>
                                        <form class="btn btn-soft btn-error project-delete-form"
                                            action="{{ route('projects.destroy', $project) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">Usuń</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            <div class="divider my-3"></div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium">Podsumowanie</h3>
                                    <p class="text-sm text-gray-500">Łączny czas: <strong>{{ $project->totalHours() }}
                                            h</strong> ({{ $project->totalMinutes() }} min)</p>
                                </div>
                                <div>
                                    <span class="badge badge-primary">Zadania:
                                        {{ $project->tasks_count ?? $project->tasks->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        console.log('DOM loaded');
        const modal = document.getElementById('project-modal');
        const openBtns = document.querySelectorAll('.open-project');
        const closeBtn = document.getElementById('project-modal-close');
        const cancelBtn = document.getElementById('project-cancel');
        const nameInput = document.getElementById('project-name');
        const clientSelect = document.getElementById('project-client');
        const amountInput = document.getElementById('project-amount');
        const descInput = document.getElementById('project-description');
        const form = document.getElementById('project-modal-form');
        const deleteBtn = document.getElementById('project-delete-btn');

        function openModal() {
            modal.classList.add('modal-open');
            modal.setAttribute('aria-hidden', 'false');
        }

        function closeModal() {
            modal.classList.remove('modal-open');
            modal.setAttribute('aria-hidden', 'true');
        }
        console.log(openBtns);
        openBtns.forEach(btn => btn.addEventListener('click', () => {
            console.log('clicked');
            const id = btn.dataset.id;
            nameInput.value = btn.dataset.name || '';
            clientSelect.value = btn.dataset.client || '';
            amountInput.value = btn.dataset.amount || '';
            descInput.value = btn.dataset.description || '';
            form.action = '/projects/' + id;
            deleteBtn.dataset.projectId = id;
            openModal();
        }));

        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

        if (deleteBtn) deleteBtn.addEventListener('click', () => {
            const id = deleteBtn.dataset.projectId;
            if (!confirm('Na pewno usunąć projekt?')) return;
            const delForm = document.createElement('form');
            delForm.method = 'POST';
            delForm.action = '/projects/' + id;
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

        // Close modal on backdrop click
        if (modal) modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });
    });
</script>
