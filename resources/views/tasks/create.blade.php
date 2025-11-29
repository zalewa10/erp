<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dodawanie zadania') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            @if (session('success'))
                <div style="color: green">{{ session('success') }}</div>
            @endif

            <form action="/tasks" method="POST">
                @csrf

                <label>Tytuł:</label><br>
                <input type="text" name="title" required><br><br>

                <label>Opis:</label><br>
                <textarea name="description"></textarea><br><br>

                <label>Klient:</label><br>
                <select name="client_id">
                    <option value="">-- brak --</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
                <br><br>

                <label>Priorytet:</label><br>
                <select name="priority_id">
                    <option value="">-- brak --</option>
                    @foreach ($priorities as $priority)
                        <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                    @endforeach
                </select>
                <br><br>

                <label>Przypisane do użytkownika:</label><br>
                <select name="assigned_to">
                    <option value="">-- brak --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <br><br>

                <label>Termin wykonania:</label><br>
                <input type="datetime-local" name="due_date"><br><br>

                <label>Kwota:</label><br>
                <input type="number" step="0.01" name="amount"><br><br>

                <button type="submit">Zapisz zadanie</button>
            </form>



        </div>
    </div>
</x-app-layout>
