<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kanban') }}
            </h2>
            <a href="/tasks/create" class="btn btn-primary">+ Dodaj nowe zadanie</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:task-board />
        </div>
    </div>
</x-app-layout>
