<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stwórz projekt') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('projects.store') }}" method="POST">
                @csrf

                <label>Nazwa projektu</label>
                <input type="text" name="name">

                <label>Klient</label>
                <select name="client_id">
                    <option value="">-- wybierz --</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>

                <label>Kwota</label>
                <input type="number" step="0.01" name="amount">

                <label>Opis</label>
                <textarea name="description"></textarea>

                <button type="submit">Zapisz</button>
            </form>

        </div>
    </div>
</x-app-layout>
