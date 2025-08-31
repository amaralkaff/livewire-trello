<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-card-foreground leading-tight">
            {{ __('Task Boards') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('task-board-clean')
        </div>
    </div>
</x-app-layout>