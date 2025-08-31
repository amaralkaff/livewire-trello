<div class="p-6">
    <!-- Board Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            @if($boards && $boards->isNotEmpty())
                <!-- Board Selector -->
                <select wire:model.live="selectedBoardId" wire:change="selectBoard($event.target.value)" 
                        class="px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:ring-2 focus:ring-blue-500">
                    @foreach($boards as $boardOption)
                        <option value="{{ $boardOption->id }}">{{ $boardOption->title }}</option>
                    @endforeach
                </select>

                @if($board)
                    <h1 class="text-2xl font-bold text-gray-900">{{ $board->title }}</h1>
                    @if($board->description)
                        <p class="text-gray-600">{{ $board->description }}</p>
                    @endif
                @endif
            @else
                <h1 class="text-2xl font-bold text-gray-900">Task Boards</h1>
            @endif
        </div>

        <!-- New Board Button -->
        <button wire:click="$set('showCreateBoard', true)" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            + New Board
        </button>
    </div>

    @if($boards && $boards->isEmpty())
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="w-16 h-16 mx-auto bg-gray-200 rounded-full mb-4 flex items-center justify-center">
                <span class="text-2xl">📋</span>
            </div>
            <h2 class="text-xl font-semibold text-gray-900 mb-2">No boards yet</h2>
            <p class="text-gray-600 mb-6">Create your first board to start organizing your tasks</p>
            <button wire:click="$set('showCreateBoard', true)" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Create Your First Board
            </button>
        </div>
    @elseif($board)
        <!-- Board Content -->
        <div class="flex space-x-4 overflow-x-auto pb-6 p-4 rounded-lg" style="background-color: {{ $board->background_color }};">
            <!-- Task Lists -->
            @if($board->taskLists)
                @foreach($board->taskLists as $taskList)
                    <div class="flex-none w-80 bg-white rounded-lg border border-gray-200 shadow-sm">
                        <!-- List Header -->
                        <div class="p-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-gray-900">{{ $taskList->title }}</h3>
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                        {{ $taskList->tasks ? $taskList->tasks->count() : 0 }}
                                    </span>
                                    <button wire:click="deleteList({{ $taskList->id }})" 
                                            wire:confirm="Are you sure you want to delete this list?"
                                            class="text-gray-400 hover:text-red-600 text-sm">
                                        🗑️
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Tasks Container with Drag & Drop -->
                        <div class="p-4 space-y-3 min-h-[200px] task-list" data-list-id="{{ $taskList->id }}">
                            @if($taskList->tasks)
                                @foreach($taskList->tasks as $task)
                                    <div class="task-item bg-white border border-gray-200 rounded-lg p-3 shadow-sm cursor-move hover:shadow-md transition-all group" 
                                         data-task-id="{{ $task->id }}"
                                         draggable="true">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-start space-x-2 flex-1">
                                                <!-- Completion Checkbox -->
                                                <button wire:click="toggleTaskComplete({{ $task->id }})" 
                                                        class="mt-0.5 w-4 h-4 rounded border-2 border-gray-300 flex items-center justify-center hover:border-blue-500 transition-colors
                                                               {{ $task->completed ? 'bg-blue-500 border-blue-500' : 'bg-white' }}">
                                                    @if($task->completed)
                                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    @endif
                                                </button>
                                                
                                                <!-- Task Content -->
                                                <div class="flex-1">
                                                    <h4 class="font-medium text-gray-900 {{ $task->completed ? 'line-through opacity-60' : '' }}">{{ $task->title }}</h4>
                                                    @if($task->description)
                                                        <p class="text-sm text-gray-600 mt-1 {{ $task->completed ? 'line-through opacity-60' : '' }}">{{ $task->description }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Task Actions -->
                                            <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button wire:click="deleteTask({{ $task->id }})"
                                                        wire:confirm="Are you sure you want to delete this task?"
                                                        class="p-1 text-gray-400 hover:text-red-600 rounded text-sm">
                                                    🗑️
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Task Footer -->
                                        <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100">
                                            <span class="text-xs px-2 py-1 rounded-full font-medium {{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                            @if($task->due_date)
                                                <span class="text-xs text-gray-500">Due: {{ $task->due_date->format('M j') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            
                            <!-- Add Task Form Placeholder -->
                            <div class="mt-3">
                                <button class="w-full px-3 py-2 text-sm text-gray-600 bg-gray-50 rounded-md hover:bg-gray-100 border-2 border-dashed border-gray-300">
                                    + Add a task
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- Add New List -->
            <div class="flex-none w-80">
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <form wire:submit="createList">
                        <input type="text" 
                               wire:model="newListTitle" 
                               placeholder="Enter list title..." 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                               required>
                        <button type="submit" class="mt-2 w-full px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                            + Add List
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Create Board Modal -->
    @if($showCreateBoard)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-96 max-w-md">
                <h3 class="text-lg font-semibold mb-4">Create New Board</h3>
                <p class="mb-4">Board creation form will be here</p>
                <button wire:click="$set('showCreateBoard', false)" class="mt-4 px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                    Cancel
                </button>
            </div>
        </div>
    @endif

    <!-- SortableJS Implementation -->
    @push('scripts')
    <script>
        document.addEventListener('livewire:navigated', function() {
            initializeDragAndDrop();
        });

        function initializeDragAndDrop() {
            // Clean up existing sortable instances
            document.querySelectorAll('.task-list').forEach(function(list) {
                if (list.sortableInstance) {
                    list.sortableInstance.destroy();
                }
                
                // Initialize Sortable
                list.sortableInstance = new Sortable(list, {
                    group: 'shared',
                    animation: 150,
                    ghostClass: 'opacity-50',
                    dragClass: 'rotate-3',
                    chosenClass: 'bg-blue-50',
                    filter: '.livewire-component, button, input, textarea',
                    preventOnFilter: false,
                    
                    onEnd: function(evt) {
                        const taskId = evt.item.dataset.taskId;
                        const newListId = evt.to.dataset.listId;
                        const newPosition = evt.newIndex;
                        
                        if (taskId && newListId) {
                            // Dispatch Livewire event
                            Livewire.dispatch('task-moved', {
                                taskId: parseInt(taskId),
                                newListId: parseInt(newListId), 
                                newPosition: newPosition
                            });
                        }
                    }
                });
            });
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', initializeDragAndDrop);
    </script>
    @endpush
</div>