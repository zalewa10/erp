<div>
    @if ($show)
        <div class="modal modal-open" role="dialog" aria-modal="true" aria-labelledby="task-modal-title"
            wire:keydown.escape.window="close" tabindex="0">
            <div class="modal-box relative w-full max-w-md">

                <button type="button" class="btn btn-sm btn-ghost btn-circle absolute right-3 top-3" aria-label="Zamknij"
                    wire:click="close">✕</button>

                <h3 id="task-modal-title" class="font-bold text-lg mb-3">Szczegóły zadania</h3>

                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Tytuł</span></label>
                    <input type="text" wire:model.defer="title" class="input input-bordered w-full" />
                    @error('title')
                        <span class="text-sm text-error mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Opis</span></label>
                    <textarea wire:model.defer="description" class="textarea textarea-bordered w-full h-28"></textarea>
                    @error('description')
                        <span class="text-sm text-error mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Status</span></label>
                    <select wire:model="status" class="select select-bordered w-full">
                        <option value="queued">W kolejce</option>
                        <option value="today">Dzisiaj</option>
                        <option value="done">Zakończone</option>
                    </select>
                    @error('status')
                        <span class="text-sm text-error mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="modal-action mt-2">
                    <button type="button" wire:click="delete" class="btn btn-error">Usuń</button>
                    <button type="button" wire:click="close" class="btn">Anuluj</button>
                    <button type="button" wire:click="save" class="btn btn-primary">Zapisz</button>
                </div>

            </div>
        </div>
    @endif
</div>
