<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dodawanie zadania') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h3 class="text-lg font-semibold">{{ __('Dodawanie zadania') }}</h3>

                    @if (session('success'))
                        <div class="alert alert-success mt-4">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4 mt-4">
                        @csrf

                        <div class="form-control">
                            <label class="label"><span class="label-text">Tytuł</span></label>
                            <input type="text" name="title" value="{{ old('title') }}" required
                                class="input input-bordered w-full" />
                            @error('title')
                                <span class="text-sm text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Projekt (opcjonalnie)</span></label>
                            <select name="project_id" class="select select-bordered w-full">
                                <option value="">-- brak --</option>
                                @foreach ($projects ?? [] as $project)
                                    <option value="{{ $project->id }}"
                                        {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <span class="text-sm text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Opis</span></label>
                            <textarea name="description" class="textarea textarea-bordered w-full" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-sm text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Priorytet</span></label>
                            <select name="priority_id" class="select select-bordered w-full">
                                <option value="">-- brak --</option>
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->id }}"
                                        {{ old('priority_id') == $priority->id ? 'selected' : '' }}>
                                        {{ $priority->name }}</option>
                                @endforeach
                            </select>
                            @error('priority_id')
                                <span class="text-sm text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label"><span class="label-text">Przypisane do użytkownika</span></label>
                                <select name="assigned_to" class="select select-bordered w-full">
                                    <option value="">-- brak --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('assigned_to')
                                    <span class="text-sm text-error mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text">Termin wykonania</span></label>
                                <input type="datetime-local" name="due_date" value="{{ old('due_date') }}"
                                    class="input input-bordered w-full" />
                                @error('due_date')
                                    <span class="text-sm text-error mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>



                        <div class="flex items-center justify-end gap-2 pt-2">
                            <a href="{{ route('tasks.index') }}" class="btn btn-ghost">Anuluj</a>
                            <button type="submit" class="btn btn-primary">Zapisz zadanie</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
