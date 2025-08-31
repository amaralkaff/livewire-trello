<?php

namespace App\Livewire;

use App\Models\Board;
use Livewire\Component;

class CreateBoard extends Component
{
    public $title = '';
    public $description = '';
    public $background_color = '#ffffff';

    public $colors = [
        '#ffffff' => 'White',
        '#f3f4f6' => 'Gray', 
        '#dbeafe' => 'Blue',
        '#dcfce7' => 'Green',
        '#fef3c7' => 'Yellow',
        '#fed7d7' => 'Red',
        '#e9d5ff' => 'Purple',
        '#fce7f3' => 'Pink',
    ];

    public function createBoard()
    {
        $this->validate([
            'title' => 'required|min:1|max:255',
            'description' => 'nullable|max:1000',
            'background_color' => 'required|string',
        ]);

        $maxPosition = auth()->user()->boards()->max('position') ?? -1;

        Board::create([
            'title' => $this->title,
            'description' => $this->description,
            'background_color' => $this->background_color,
            'user_id' => auth()->id(),
            'position' => $maxPosition + 1,
        ]);

        $this->reset();
        $this->dispatch('board-created');
    }

    public function render()
    {
        return view('livewire.create-board-simple');
    }
}
