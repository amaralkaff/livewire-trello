<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <x-page-content>
                    <h3 class="text-lg font-semibold mb-4">Welcome, Admin {{ Auth::user()->name }}!</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div class="bg-blue-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800">Total Users</h4>
                            <p class="text-2xl font-bold text-blue-900">{{ \App\Models\User::count() }}</p>
                        </div>
                        
                        <div class="bg-green-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800">Admin Users</h4>
                            <p class="text-2xl font-bold text-green-900">{{ \App\Models\User::where('role', 'admin')->count() }}</p>
                        </div>
                        
                        <div class="bg-purple-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-800">Member Users</h4>
                            <p class="text-2xl font-bold text-purple-900">{{ \App\Models\User::where('role', 'member')->count() }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="text-lg font-semibold mb-4">Admin Actions</h4>
                        <div class="space-y-2">
                            <a href="{{ route('admin.users') }}" class="inline-flex items-center">
                                <x-button variant="primary" class="bg-blue-600 hover:bg-blue-700 active:bg-blue-900 focus:border-blue-900 focus:ring-blue-300">
                                    <x-heroicon-o-users class="w-4 h-4 mr-2" />
                                    Manage Users
                                </x-button>
                            </a>
                            
                            <x-button variant="primary" class="bg-green-600 hover:bg-green-700 active:bg-green-900 focus:border-green-900 focus:ring-green-300 ml-2">
                                <x-heroicon-o-chart-bar class="w-4 h-4 mr-2" />
                                View Reports
                            </x-button>
                            
                            <x-button variant="primary" class="bg-purple-600 hover:bg-purple-700 active:bg-purple-900 focus:border-purple-900 focus:ring-purple-300 ml-2">
                                <x-heroicon-o-cog-6-tooth class="w-4 h-4 mr-2" />
                                System Settings
                            </x-button>
                        </div>
                    </div>
    </x-page-content>
</x-app-layout>