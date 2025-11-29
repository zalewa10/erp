<div>
    @if ($show)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow-xl w-96">

                <h2 class="text-lg font-bold mb-4">Szczegóły zadania</h2>

                <input type="text" wire:model="title" class="w-full border p-2 mb-2">
                <textarea wire:model="description" class="w-full border p-2 mb-2"></textarea>
                <select wire:model="status" class="w-full border p-2 mb-2">
                    <option value="queued">W kolejce</option>
                    <option value="today">Dzisiaj</option>
                    <option value="done">Zakończone</option>
                </select>


                <div class="flex justify-end gap-2 mt-4">
                    <button wire:click="close" class="px-3 py-1 bg-gray-300 rounded">Anuluj</button>
                    <button wire:click="save" class="px-3 py-1 bg-blue-600 text-white rounded">Zapisz</button>
                </div>

            </div>
        </div>
    @endif
</div>
