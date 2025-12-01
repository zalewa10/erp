<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stwórz projekt') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h3 class="text-lg font-semibold">{{ __('Stwórz projekt') }}</h3>

                    @if ($errors->any())
                        <div class="alert alert-error mt-4">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Wystąpiły błędy. Sprawdź formularz.</span>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('projects.store') }}" method="POST" class="space-y-4 mt-4">
                        @csrf

                        <div class="form-control">
                            <label class="label"><span class="label-text">Nazwa projektu</span></label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="input input-bordered w-full" placeholder="Nazwa projektu" />
                            @error('name')
                                <span class="text-sm text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Klient</span></label>
                            <select name="client_id" class="select select-bordered w-full">
                                <option value="">-- wybierz --</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <span class="text-sm text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Kwota</span></label>
                            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}"
                                class="input input-bordered w-full" placeholder="0.00" />
                            @error('amount')
                                <span class="text-sm text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Opis</span></label>
                            <textarea name="description" class="textarea textarea-bordered w-full" rows="4" placeholder="Opis projektu">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-sm text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-2">
                            <a href="{{ route('projects.index') }}" class="btn btn-ghost">Anuluj</a>
                            <button type="submit" class="btn btn-primary">Zapisz</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
