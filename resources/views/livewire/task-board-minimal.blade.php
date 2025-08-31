<div class="p-6">
    <h2>Minimal TaskBoard - Testing</h2>
    <p>User: {{ auth()->user()->name ?? 'Not authenticated' }}</p>
    <p>Boards count: {{ $boards ? $boards->count() : 'null' }}</p>
</div>