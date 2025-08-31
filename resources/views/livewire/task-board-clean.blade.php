<x-card>
    <!-- Header -->
    <x-card-header>
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                @if($boards && $boards->isNotEmpty())
                    <!-- Board Selector -->
                    <select wire:model.live="selectedBoardId" wire:change="selectBoard($event.target.value)" 
                            class="px-3 py-2 border border-input rounded-md bg-background text-foreground focus:ring-2 focus:ring-ring">
                        @foreach($boards as $boardOption)
                            <option value="{{ $boardOption->id }}">{{ $boardOption->title }}</option>
                        @endforeach
                    </select>

                    @if($board)
                        <div>
                            <x-card-title>{{ $board->title }}</x-card-title>
                            @if($board->description)
                                <x-card-description>{{ $board->description }}</x-card-description>
                            @endif
                        </div>
                    @endif
                @else
                    <x-card-title>Task Boards</x-card-title>
                @endif
            </div>

            <!-- New Board Button -->
            <button wire:click="$set('showCreateBoard', true)" 
                    class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                <span class="mr-1">+</span> New Board
            </button>
        </div>
    </x-card-header>

    <!-- Main Content -->
    <x-card-content>
        @if($boards && $boards->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="w-16 h-16 mx-auto bg-accent rounded-full mb-4 flex items-center justify-center">
                    <span class="text-2xl">📋</span>
                </div>
                <h2 class="text-xl font-semibold text-card-foreground mb-2">Welcome to Your Task Boards!</h2>
                <p class="text-muted-foreground mb-6">Create your first board to start organizing tasks Trello-style</p>
                <button wire:click="$set('showCreateBoard', true)" 
                        class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                    🚀 Create Your First Board
                </button>
            </div>

        @elseif($board)
            <!-- Board View -->
            <div class="rounded-lg p-6" style="background: linear-gradient(135deg, {{ $board->background_color }}, {{ $board->background_color }}dd);">
                <div class="flex space-x-6 overflow-x-auto pb-4">
                    <!-- Task Lists -->
                    @if($board->taskLists)
                        @foreach($board->taskLists as $taskList)
                            <div class="flex-none w-80">
                                <x-card>
                                    <!-- List Header -->
                                    <x-card-header class="bg-muted/50 rounded-t-lg">
                                        <div class="flex items-center justify-between">
                                            <h3 class="font-semibold text-card-foreground">{{ $taskList->title }}</h3>
                                            <div class="flex items-center space-x-2">
                                                <x-badge variant="secondary">
                                                    {{ $taskList->tasks ? $taskList->tasks->count() : 0 }}
                                                </x-badge>
                                                <button wire:click="deleteList({{ $taskList->id }})" 
                                                        wire:confirm="Are you sure you want to delete this list and all its tasks?"
                                                        class="text-muted-foreground hover:text-destructive p-1 rounded text-sm transition-colors">
                                                    🗑️
                                                </button>
                                            </div>
                                        </div>
                                    </x-card-header>

                                    <!-- Tasks -->
                                    <x-card-content class="space-y-3 min-h-[300px]">
                                        <div class="sortable-tasks" data-list-id="{{ $taskList->id }}">
                                            @if($taskList->tasks && $taskList->tasks->count() > 0)
                                                @foreach($taskList->tasks as $task)
                                                    <x-card class="hover:bg-muted/50 transition-colors cursor-move group sortable-task mb-3" 
                                                           data-task-id="{{ $task->id }}" 
                                                           data-position="{{ $task->position }}">
                                                        <div class="p-3">
                                                        <div class="flex items-start space-x-2">
                                                            <!-- Drag Handle -->
                                                            <div class="drag-handle mt-1 cursor-move text-muted-foreground hover:text-foreground transition-colors flex-shrink-0">
                                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M7 2a2 2 0 1 1 .001 4.001A2 2 0 0 1 7 2zM7 8a2 2 0 1 1 .001 4.001A2 2 0 0 1 7 8zM7 14a2 2 0 1 1 .001 4.001A2 2 0 0 1 7 14zM13 2a2 2 0 1 1 .001 4.001A2 2 0 0 1 13 2zM13 8a2 2 0 1 1 .001 4.001A2 2 0 0 1 13 8zM13 14a2 2 0 1 1 .001 4.001A2 2 0 0 1 13 14z"></path>
                                                                </svg>
                                                            </div>
                                                            
                                                            <!-- Completion Checkbox -->
                                                            <button wire:click="toggleTaskComplete({{ $task->id }})" 
                                                                    class="mt-1 w-4 h-4 rounded border-2 border-input flex items-center justify-center hover:border-primary transition-colors flex-shrink-0
                                                                           {{ $task->completed ? 'bg-primary border-primary' : 'bg-background' }}">
                                                                @if($task->completed)
                                                                    <svg class="w-3 h-3 text-primary-foreground" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                                    </svg>
                                                                @endif
                                                            </button>
                                                            
                                                            <!-- Task Content -->
                                                            <div class="flex-1 min-w-0">
                                                                <h4 class="font-medium text-card-foreground text-sm {{ $task->completed ? 'line-through opacity-60' : '' }}">
                                                                    {{ $task->title }}
                                                                </h4>
                                                                @if($task->description)
                                                                    <p class="text-xs text-muted-foreground mt-1 {{ $task->completed ? 'line-through opacity-60' : '' }}">
                                                                        {{ $task->description }}
                                                                    </p>
                                                                @endif
                                                                
                                                                <!-- Task Footer -->
                                                                <div class="flex items-center justify-between mt-2">
                                                                    <x-badge variant="{{ $task->priority === 'high' ? 'destructive' : ($task->priority === 'medium' ? 'default' : 'secondary') }}">
                                                                        {{ ucfirst($task->priority) }}
                                                                    </x-badge>
                                                                    @if($task->due_date)
                                                                        <span class="text-xs text-muted-foreground">
                                                                            📅 {{ $task->due_date->format('M j') }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Task Actions -->
                                                            <button wire:click="deleteTask({{ $task->id }})"
                                                                    wire:confirm="Delete this task?"
                                                                    class="opacity-0 group-hover:opacity-100 p-1 text-muted-foreground hover:text-destructive transition-all">
                                                                🗑️
                                                            </button>
                                                        </div>
                                                    </div>
                                                    </x-card>
                                                @endforeach
                                            @else
                                                <div class="text-center py-8 text-muted-foreground empty-drop-zone">
                                                    <p class="text-sm">No tasks yet</p>
                                                    <p class="text-xs">Add your first task below</p>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Add Task Component -->
                                        <livewire:create-task :task-list-id="$taskList->id" :key="'create-task-'.$taskList->id" />
                                    </x-card-content>
                                </x-card>
                            </div>
                        @endforeach
                    @endif

                    <!-- Add New List -->
                    <div class="flex-none w-80">
                        <x-card>
                            <x-card-content class="p-4">
                                <form wire:submit="createList" class="space-y-3">
                                    <h4 class="font-medium text-card-foreground">➕ Add a list</h4>
                                    <input type="text" 
                                           wire:model="newListTitle" 
                                           placeholder="Enter list title..." 
                                           class="w-full px-3 py-2 border border-input rounded-md bg-background text-foreground focus:ring-2 focus:ring-ring"
                                           required>
                                    @error('newListTitle') <span class="text-destructive text-sm">{{ $message }}</span> @enderror
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                        Add List
                                    </button>
                                </form>
                            </x-card-content>
                        </x-card>
                    </div>
                </div>
            </div>

        @else
            <!-- No Board Selected -->
            <div class="text-center py-12">
                <p class="text-muted-foreground">Select a board from the dropdown above or create a new one</p>
            </div>
        @endif
    </x-card-content>

    <!-- Create Board Modal -->
    @if($showCreateBoard)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <x-card class="w-full max-w-md mx-4">
                <x-card-header>
                    <x-card-title>Create New Board</x-card-title>
                </x-card-header>
                
                <x-card-content>
                    <form wire:submit="createBoard" class="space-y-4">
                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-medium text-card-foreground mb-1">Board Title</label>
                            <input type="text" 
                                   wire:model="title" 
                                   placeholder="My awesome board..."
                                   class="w-full px-3 py-2 border border-input rounded-md bg-background text-foreground focus:ring-2 focus:ring-ring"
                                   required>
                            @error('title') <span class="text-destructive text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-card-foreground mb-1">Description (optional)</label>
                            <textarea wire:model="description" 
                                      placeholder="What's this board about?"
                                      rows="2"
                                      class="w-full px-3 py-2 border border-input rounded-md bg-background text-foreground focus:ring-2 focus:ring-ring"></textarea>
                            @error('description') <span class="text-destructive text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Background Color -->
                        <div>
                            <label class="block text-sm font-medium text-card-foreground mb-2">Background Color</label>
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($colors as $color => $name)
                                    <label class="cursor-pointer">
                                        <input type="radio" 
                                               wire:model="background_color" 
                                               value="{{ $color }}" 
                                               class="sr-only">
                                        <div class="w-full h-10 rounded border-2 flex items-center justify-center text-xs font-medium transition-all
                                                    {{ $background_color === $color ? 'border-primary ring-2 ring-ring' : 'border-border hover:border-input' }}"
                                             style="background-color: {{ $color }}; color: {{ $color === '#ffffff' ? '#000' : '#fff' }}">
                                            {{ $name }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('background_color') <span class="text-destructive text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end space-x-3 pt-4 border-t border-border">
                            <button type="button" 
                                    wire:click="$set('showCreateBoard', false)"
                                    class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                Create Board
                            </button>
                        </div>
                    </form>
                </x-card-content>
            </x-card>
        </div>
    @endif
</x-card>

@push('scripts')
<style>
.sortable-chosen {
    transform: rotate(2deg) scale(1.05);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    border: 2px solid #3b82f6;
    z-index: 1000;
}

.sortable-drag {
    opacity: 0.8;
    transform: rotate(-2deg);
}

.sortable-ghost {
    opacity: 0.4;
}

.drag-handle:hover {
    background-color: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}
</style>
<script>
document.addEventListener('livewire:navigated', function () {
    initializeDragAndDrop();
});

document.addEventListener('DOMContentLoaded', function () {
    initializeDragAndDrop();
});

function initializeDragAndDrop() {
    // Initialize sortable for each task list
    document.querySelectorAll('.sortable-tasks').forEach(function(taskList) {
        if (taskList.sortableInstance) {
            taskList.sortableInstance.destroy();
        }
        
        taskList.sortableInstance = new Sortable(taskList, {
            group: 'tasks',
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'opacity-50',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                const taskId = evt.item.getAttribute('data-task-id');
                const newListId = evt.to.getAttribute('data-list-id');
                const newPosition = evt.newIndex;
                
                // Dispatch Livewire event
                window.Livewire.dispatch('task-moved', {
                    taskId: parseInt(taskId),
                    newListId: parseInt(newListId),
                    newPosition: newPosition
                });
            }
        });
    });
}

// Reinitialize on Livewire updates
document.addEventListener('livewire:updated', function () {
    setTimeout(initializeDragAndDrop, 100);
});
</script>
@endpush