<div class="p-4">

    <h2 class="text-xl font-bold">{{ $task->title }}</h2>
    <p>{{ $task->description }}</p>

    <hr class="my-3">

    @if ($task->activeLog)
        <button wire:click="stopWork" class="bg-red-500 text-white px-4 py-2 rounded">
            ⏹ Zatrzymaj czas
        </button>

        <p class="mt-2 text-sm text-gray-600">
            Liczy od: {{ $task->activeLog->start_time }}
        </p>
    @else
        <button wire:click="startWork" class="bg-green-500 text-white px-4 py-2 rounded">
            ▶️ Start pracy
        </button>
    @endif

    <hr class="my-3">

    <h3 class="font-semibold">Historia czasu:</h3>

    @foreach ($task->timeLogs as $log)
        <div class="border p-2 my-1 rounded">
            <strong>Start:</strong> {{ $log->start_time }} <br>
            <strong>Koniec:</strong> {{ $log->end_time ?? '— trwa' }} <br>
            <strong>Czas:</strong>
            {{ $log->duration_minutes ? $log->duration_minutes . ' min' : '—' }}
        </div>
    @endforeach
    <hr class="my-3">

    <div class="p-3 bg-gray-100 rounded">
        <h3 class="font-semibold text-lg">⏱ Podsumowanie czasu</h3>

        <p class="mt-2">
            <strong>Łącznie minut:</strong> {{ $this->totalTime }} min
        </p>

        <p>
            <strong>Łącznie godzin:</strong> {{ $this->totalHours }} h
        </p>
    </div>


</div>
