<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-card-foreground leading-tight">
            {{ __('Member Dashboard') }}
        </h2>
    </x-slot>

    <x-page-content>
            <x-card>
                <x-card-header>
                    <x-card-title>Welcome, {{ Auth::user()->name }}!</x-card-title>
                    <x-card-description>Your member dashboard overview</x-card-description>
                </x-card-header>
                
                <x-card-content>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <x-card class="bg-primary/5 border-primary/20">
                            <div class="p-6">
                                <h4 class="font-semibold text-primary mb-2">Member Since</h4>
                                <p class="text-2xl font-bold text-primary">{{ Auth::user()->created_at->format('F d, Y') }}</p>
                            </div>
                        </x-card>
                        
                        <x-card class="bg-secondary border-secondary">
                            <div class="p-6">
                                <h4 class="font-semibold text-secondary-foreground mb-2">Account Status</h4>
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <p class="text-2xl font-bold text-secondary-foreground">Active Member</p>
                                </div>
                            </div>
                        </x-card>
                    </div>

                    <div class="mt-8">
                        <h4 class="text-lg font-semibold text-card-foreground mb-6">Quick Actions</h4>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('profile') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                <x-heroicon-o-user class="w-4 h-4 mr-2" />
                                Edit Profile
                            </a>
                            
                            <a href="{{ route('member.activities') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                                <x-heroicon-o-clipboard-document-list class="w-4 h-4 mr-2" />
                                View Activities
                            </a>
                            
                            <a href="{{ route('member.boards') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                                <x-heroicon-o-squares-2x2 class="w-4 h-4 mr-2" />
                                Task Boards
                            </a>
                    </div>

                    <x-card class="mt-8 bg-accent/50 border-accent">
                        <x-card-header>
                            <x-card-title class="text-accent-foreground">Member Benefits</x-card-title>
                            <x-card-description>Exclusive perks for our valued members</x-card-description>
                        </x-card-header>
                        <x-card-content>
                            <ul class="space-y-2 text-accent-foreground">
                                <li class="flex items-center gap-2">
                                    <x-heroicon-s-check class="w-4 h-4 text-green-600" />
                                    Access to member-exclusive content
                                </li>
                                <li class="flex items-center gap-2">
                                    <x-heroicon-s-check class="w-4 h-4 text-green-600" />
                                    Priority support
                                </li>
                                <li class="flex items-center gap-2">
                                    <x-heroicon-s-check class="w-4 h-4 text-green-600" />
                                    Monthly newsletter
                                </li>
                                <li class="flex items-center gap-2">
                                    <x-heroicon-s-check class="w-4 h-4 text-green-600" />
                                    Community forum access
                                </li>
                            </ul>
                        </x-card-content>
                    </x-card>
                </x-card-content>
            </x-card>
    </x-page-content>
</x-app-layout>