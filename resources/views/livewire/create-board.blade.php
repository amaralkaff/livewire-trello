<div>
    <h3 class="text-lg font-semibold text-card-foreground mb-4">Create New Board</h3>
    
    <form wire:submit="createBoard" class="space-y-4">
        <!-- Title -->
        <div>
            <label for="title" class="block text-sm font-medium text-card-foreground mb-2">Title</label>
            <input type="text" 
                   id="title"
                   wire:model="title" 
                   placeholder="Board title..."
                   class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground placeholder-muted-foreground focus:ring-2 focus:ring-primary"
                   required>
            @error('title') <span class="text-destructive text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-card-foreground mb-2">Description</label>
            <textarea id="description"
                      wire:model="description" 
                      placeholder="Optional description..."
                      rows="3"
                      class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground placeholder-muted-foreground focus:ring-2 focus:ring-primary"></textarea>
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
                        <div class="w-full h-12 rounded border-2 flex items-center justify-center text-sm font-medium transition-all
                                    {{ $background_color === $color ? 'border-primary ring-2 ring-primary' : 'border-border hover:border-accent' }}"
                             style="background-color: {{ $color }}; color: {{ $color === '#ffffff' ? '#000' : '#fff' }}">
                            {{ $name }}
                        </div>
                    </label>
                @endforeach
            </div>
            @error('background_color') <span class="text-destructive text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Submit Button -->
        <x-button variant="primary" type="submit" class="w-full">
            <x-heroicon-o-plus class="w-4 h-4 mr-2" />
            Create Board
        </x-button>
    </form>
</div>