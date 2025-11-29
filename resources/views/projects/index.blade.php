<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista projektów') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('projects.create') }}">+ Nowy projekt</a>

            <ul>
                @foreach ($projects as $project)
                    <li>
                        {{ $project->name }} — {{ $project->client->name ?? 'brak klienta' }} — {{ $project->amount }}
                        PLN
                        <div class="p-4 bg-gray-100 rounded mt-4">
                            <h2 class="font-bold text-lg">⏱ Podsumowanie projektu</h2>

                            <p class="mt-2">
                                <strong>Łączny czas:</strong> {{ $project->totalHours() }} h
                                ({{ $project->totalMinutes() }} min)
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>

        </div>
    </div>
</x-app-layout>
