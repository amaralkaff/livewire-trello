<div class="bg-card border border-border rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow duration-200 cursor-pointer"
     wire:key="task-{{ $task->id }}">
    
    @if($editing)
        <!-- Edit Mode -->
        <form wire:submit="save" class="space-y-3">
            <!-- Title -->
            <input type="text" 
                   wire:model="title" 
                   placeholder="Task title..."
                   class="w-full px-2 py-1 text-sm border border-border rounded bg-background text-foreground focus:ring-1 focus:ring-primary"
                   required>
            @error('title') <span class="text-destructive text-xs">{{ $message }}</span> @enderror
            
            <!-- Description -->
            <textarea wire:model="description" 
                      placeholder="Description..."
                      rows="3"
                      class="w-full px-2 py-1 text-xs border border-border rounded bg-background text-foreground focus:ring-1 focus:ring-primary resize-none"></textarea>
            @error('description') <span class="text-destructive text-xs">{{ $message }}</span> @enderror
            
            <!-- Priority -->
            <div>
                <label class="block text-xs font-medium text-muted-foreground mb-1">Priority</label>
                <select wire:model="priority" class="w-full px-2 py-1 text-xs border border-border rounded bg-background text-foreground">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
                @error('priority') <span class="text-destructive text-xs">{{ $message }}</span> @enderror
            </div>
            
            <!-- Due Date -->
            <div>
                <label class="block text-xs font-medium text-muted-foreground mb-1">Due Date</label>
                <input type="date" 
                       wire:model="due_date"
                       class="w-full px-2 py-1 text-xs border border-border rounded bg-background text-foreground">
                @error('due_date') <span class="text-destructive text-xs">{{ $message }}</span> @enderror
            </div>
            
            <!-- Actions -->
            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" 
                        wire:click="cancel"
                        class="px-3 py-1 text-xs bg-secondary text-secondary-foreground rounded hover:bg-secondary/80">
                    Cancel
                </button>
                <button type="submit"
                        class="px-3 py-1 text-xs bg-primary text-primary-foreground rounded hover:bg-primary/90">
                    Save
                </button>
            </div>
        </form>
    @else
        <!-- Display Mode -->
        <div class="space-y-2">
            <!-- Header with checkbox and actions -->
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-2 flex-1">
                    <!-- Completion Checkbox -->
                    <button wire:click="toggleComplete" 
                            class="mt-0.5 w-4 h-4 rounded border-2 border-border flex items-center justify-center hover:border-primary transition-colors
                                   {{ $task->completed ? 'bg-primary border-primary' : 'bg-background' }}">
                        @if($task->completed)
                            <svg class="w-3 h-3 text-primary-foreground" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        @endif
                    </button>
                    
                    <!-- Title -->
                    <h3 class="font-medium text-card-foreground text-sm leading-tight flex-1 {{ $task->completed ? 'line-through opacity-60' : '' }}">
                        {{ $task->title }}
                    </h3>
                </div>
                
                <!-- Actions Menu -->
                <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button wire:click="edit" 
                            class="p-1 text-muted-foreground hover:text-foreground hover:bg-accent rounded">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button wire:click="deleteTask" 
                            wire:confirm="Are you sure you want to delete this task?"
                            class="p-1 text-muted-foreground hover:text-destructive hover:bg-accent rounded">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Description -->
            @if($task->description)
                <p class="text-xs text-muted-foreground leading-relaxed {{ $task->completed ? 'line-through opacity-60' : '' }}">
                    {{ $task->description }}
                </p>
            @endif
            
            <!-- Footer with priority and due date -->
            <div class="flex items-center justify-between pt-1">
                <!-- Priority Badge -->
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $task->priority_color }}">
                    {{ ucfirst($task->priority) }}
                </span>
                
                <!-- Due Date -->
                @if($task->due_date)
                    <span class="text-xs text-muted-foreground">
                        {{ $task->due_date->format('M j') }}
                    </span>
                @endif
            </div>
        </div>
    @endif
</div>
