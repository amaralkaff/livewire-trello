<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-foreground leading-tight">
            {{ __('My Activities') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <x-card-header>
                    <div class="flex justify-between items-center">
                        <x-card-title>Recent Activities</x-card-title>
                        <a href="{{ route('member.dashboard') }}" class="text-primary hover:text-primary/80 text-sm font-medium">
                            ← Back to Dashboard
                        </a>
                    </div>
                </x-card-header>
                
                <x-card-content>
                    <div class="space-y-4">
                        @foreach($activities as $activity)
                            <x-card class="transition-colors hover:bg-muted/50">
                                <div class="p-4">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-3">
                                                <x-badge variant="{{ $activity['type'] === 'profile' ? 'default' : ($activity['type'] === 'system' ? 'secondary' : 'outline') }}">
                                                    {{ ucfirst($activity['type']) }}
                                                </x-badge>
                                            </div>
                                            <h4 class="font-semibold text-card-foreground mb-2">{{ $activity['title'] }}</h4>
                                            <p class="text-muted-foreground text-sm">{{ $activity['description'] }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-muted-foreground">{{ $activity['date']->format('M j, Y') }}</p>
                                            <p class="text-xs text-muted-foreground/70">{{ $activity['date']->format('g:i A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </x-card>
                        @endforeach
                    </div>

                    @if(empty($activities))
                        <div class="text-center py-12">
                            <div class="text-muted-foreground mb-4">
                                <x-heroicon-o-clipboard-document-list class="mx-auto h-12 w-12" />
                            </div>
                            <h3 class="text-lg font-semibold text-card-foreground mb-2">No activities yet</h3>
                            <p class="text-muted-foreground">Your recent activities will appear here.</p>
                        </div>
                    @endif
                </x-card-content>
            </x-card>
        </div>
    </div>
</x-app-layout>