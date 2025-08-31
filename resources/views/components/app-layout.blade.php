<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Livewire Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-background text-foreground">
        <div class="flex h-screen" x-data="{ sidebarOpen: false }">
            <!-- Mobile sidebar overlay -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-40 bg-black bg-opacity-25 lg:hidden"
                 @click="sidebarOpen = false"></div>

            <!-- Sidebar -->
            <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 flex flex-col transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
                 :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }"
                 style="background-color: hsl(var(--card, 0 0% 100%)); border-color: hsl(var(--border, 214.3 31.8% 91.4%));"
                
                <!-- Logo -->
                <div class="p-5 border-b border-border">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <x-application-logo class="h-8 w-8 text-primary" />
                        <span class="text-xl font-bold text-card-foreground">{{ config('app.name') }}</span>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 p-4 space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-md text-sm font-medium transition-colors
                              {{ request()->routeIs('dashboard') ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}">
                        <x-heroicon-o-briefcase class="w-5 h-5" />
                        <span>Dashboard</span>
                    </a>

                    @if(auth()->user()->isMember() || auth()->user()->isAdmin())
                        <!-- Section Divider -->
                        <div class="border-b border-border my-3 mx-3"></div>
                    @endif

                    @if(auth()->user()->isMember())
                        <!-- Member Activities -->
                        <a href="{{ route('member.activities') }}" 
                           class="flex items-center space-x-3 px-3 py-2 rounded-md text-sm font-medium transition-colors
                                  {{ request()->routeIs('member.activities') ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}">
                            <x-heroicon-o-clipboard-document-list class="w-5 h-5" />
                            <span>Activities</span>
                        </a>

                        <!-- Task Boards -->
                        <a href="{{ route('member.boards') }}" 
                           class="flex items-center space-x-3 px-3 py-2 rounded-md text-sm font-medium transition-colors
                                  {{ request()->routeIs('member.boards*') ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}">
                            <x-heroicon-o-squares-2x2 class="w-5 h-5" />
                            <span>Task Boards</span>
                        </a>
                    @endif

                    @if(auth()->user()->isAdmin())
                        <!-- User Management -->
                        <a href="{{ route('admin.users') }}" 
                           class="flex items-center space-x-3 px-3 py-2 rounded-md text-sm font-medium transition-colors
                                  {{ request()->routeIs('admin.users*') ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}">
                            <x-heroicon-o-users class="w-5 h-5" />
                            <span>User Management</span>
                        </a>
                    @endif

                    <!-- Section Divider -->
                    <div class="border-b border-border my-3 mx-3"></div>

                    <!-- Profile -->
                    <a href="{{ route('profile') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-md text-sm font-medium transition-colors
                              {{ request()->routeIs('profile') ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}">
                        <x-heroicon-o-user class="w-5 h-5" />
                        <span>Profile</span>
                    </a>
                </nav>

                <!-- User Info & Logout -->
                <div class="p-4 border-t border-border">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-primary-foreground">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-card-foreground truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-muted-foreground truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full flex items-center space-x-3 px-3 py-2 rounded-md text-sm font-medium text-muted-foreground hover:bg-destructive hover:text-destructive-foreground transition-colors">
                            <x-heroicon-o-arrow-left-on-rectangle class="w-5 h-5" />
                            <span>Log Out</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Mobile header with menu button -->
                <div class="lg:hidden bg-card border-b border-border p-3 flex items-center justify-between">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-md text-muted-foreground hover:text-foreground hover:bg-accent">
                        <x-heroicon-o-bars-3 class="w-6 h-6" />
                    </button>
                    <span class="font-semibold text-foreground">{{ config('app.name') }}</span>
                    <div class="w-10"></div> <!-- Spacer for centering -->
                </div>

                <!-- Header -->
                @isset($header)
                    <header class="bg-card border-b border-border">
                        <div class="px-6 py-4">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto bg-background">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Scripts Stack -->
        @stack('scripts')
        
        <!-- Livewire Scripts -->
        @livewireScripts
    </body>
</html>