<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Lista projektów') }}
            </h2>
            <a href="{{ route('projects.create') }}" class="btn btn-primary">+ Nowy projekt</a>
        </div>
    </x-slot>

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
