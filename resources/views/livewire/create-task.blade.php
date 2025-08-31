<div class="mt-3">
    @if($showForm)
        <div class="bg-white border border-gray-200 rounded-lg p-3 shadow-sm">
            <form wire:submit="createTask" class="space-y-3">
                <!-- Title -->
                <input type="text" 
                       wire:model="title" 
                       placeholder="Task title..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                       required>
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                
                <!-- Description -->
                <textarea wire:model="description" 
                          placeholder="Description (optional)..."
                          rows="2"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                
                <!-- Priority and Due Date -->
                <div class="flex space-x-2">
                    <select wire:model="priority" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                        <option value="low">Low Priority</option>
                        <option value="medium">Medium Priority</option>
                        <option value="high">High Priority</option>
                    </select>
                    <input type="date" 
                           wire:model="due_date"
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                </div>
                @error('priority') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @error('due_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                
                <!-- Actions -->
                <div class="flex justify-end space-x-2">
                    <button type="button" 
                            wire:click="$set('showForm', false)"
                            class="px-3 py-2 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-3 py-2 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Add Task
                    </button>
                </div>
            </form>
        </div>
    @else
        <button wire:click="$set('showForm', true)" 
                class="w-full px-3 py-2 text-sm text-gray-600 bg-gray-50 rounded-md hover:bg-gray-100 border-2 border-dashed border-gray-300">
            + Add a task
        </button>
    @endif
</div>