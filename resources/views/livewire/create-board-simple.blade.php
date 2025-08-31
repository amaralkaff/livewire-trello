<div>
    <form wire:submit="createBoard" class="space-y-4">
        <!-- Title -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
            <input type="text" 
                   id="title"
                   wire:model="title" 
                   placeholder="Board title..."
                   class="w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:ring-2 focus:ring-blue-500"
                   required>
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea id="description"
                      wire:model="description" 
                      placeholder="Optional description..."
                      rows="3"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:ring-2 focus:ring-blue-500"></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Background Color -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Background Color</label>
            <div class="grid grid-cols-4 gap-2">
                @foreach($colors as $color => $name)
                    <label class="cursor-pointer">
                        <input type="radio" 
                               wire:model="background_color" 
                               value="{{ $color }}" 
                               class="sr-only">
                        <div class="w-full h-12 rounded border-2 flex items-center justify-center text-sm font-medium transition-all
                                    {{ $background_color === $color ? 'border-blue-500 ring-2 ring-blue-200' : 'border-gray-300 hover:border-gray-400' }}"
                             style="background-color: {{ $color }}; color: {{ $color === '#ffffff' ? '#000' : '#fff' }}">
                            {{ $name }}
                        </div>
                    </label>
                @endforeach
            </div>
            @error('background_color') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center justify-center">
            <span class="mr-2">+</span>
            Create Board
        </button>
    </form>
</div>