<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista wszystkich zadań') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <a href="/tasks/create">+ Dodaj nowe zadanie</a>
            <br><br>

            <table border="1" cellpadding="8" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tytuł</th>
                        <th>Klient</th>
                        <th>Priorytet</th>
                        <th>Przypisany do</th>
                        <th>Termin</th>
                        <th>Kwota</th>
                        <th>Rozliczone?</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->client?->name ?? '-' }}</td>
                            <td>{{ $task->priority?->name ?? '-' }}</td>
                            <td>{{ $task->assignedUser?->name ?? '-' }}</td>
                            <td>{{ $task->due_date ?? '-' }}</td>
                            <td>{{ $task->amount ? number_format($task->amount, 2) : '-' }}</td>
                            <td>{{ $task->billed ? 'TAK' : 'NIE' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Brak zadań</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
