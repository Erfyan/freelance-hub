@props(['project', 'startTime'])
<div class="fixed bottom-0 left-0 right-0 bg-gradient-to-r from-cyan-500/90 to-blue-600/90 backdrop-blur-md text-white px-6 py-3 flex items-center justify-between z-50 timer-glow">
    <div class="flex items-center space-x-4">
        <div class="flex items-center space-x-2">
            <div class="h-2 w-2 bg-white rounded-full animate-ping"></div>
            <span class="text-sm font-medium">⏱️ {{ $project->title ?? 'Proyek' }}</span>
        </div>
        <span id="timer-display" class="text-2xl font-mono font-bold" data-start="{{ $startTime }}">00:00:00</span>
    </div>
    <button id="stop-timer-btn" class="bg-white text-cyan-700 px-4 py-1.5 rounded-full text-sm font-semibold hover:bg-red-50 hover:text-red-600 transition-colors">
        Stop
    </button>
</div>

<script>
    // Timer real-time
    function updateTimer() {
        const display = document.getElementById('timer-display');
        const start = new Date(display.dataset.start).getTime();
        const now = new Date().getTime();
        const diff = Math.max(0, Math.floor((now - start) / 1000));
        const hours = Math.floor(diff / 3600).toString().padStart(2, '0');
        const minutes = Math.floor((diff % 3600) / 60).toString().padStart(2, '0');
        const seconds = Math.floor(diff % 60).toString().padStart(2, '0');
        display.textContent = `${hours}:${minutes}:${seconds}`;
    }
    updateTimer();
    setInterval(updateTimer, 1000);

    // Stop timer
    document.getElementById('stop-timer-btn').addEventListener('click', async () => {
        await fetch('{{ route('timer.stop') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        window.location.reload();
    });
</script>