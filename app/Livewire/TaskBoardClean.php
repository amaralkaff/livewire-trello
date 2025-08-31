<?php

namespace App\Livewire;

use App\Models\Board;
use App\Models\TaskList;
use App\Models\Task;
use Livewire\Component;
use Livewire\Attributes\On;

class TaskBoardClean extends Component
{
    public $boards;
    public $board = null;
    public $selectedBoardId = null;
    public $showCreateBoard = false;
    public $newListTitle = '';

    // Board creation properties
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

    public function mount()
    {
        $this->boards = auth()->user()->boards ?? collect();
        
        if ($this->boards->isNotEmpty()) {
            $this->board = $this->boards->first();
            $this->selectedBoardId = $this->board->id;
        }
    }

    public function selectBoard($boardId)
    {
        $board = auth()->user()->boards()->find($boardId);
        if ($board) {
            $this->board = $board;
            $this->selectedBoardId = $boardId;
        }
    }

    public function createBoard()
    {
        $this->validate([
            'title' => 'required|min:1|max:255',
            'description' => 'nullable|max:1000',
            'background_color' => 'required|string',
        ]);

        $maxPosition = auth()->user()->boards()->max('position') ?? -1;

        $newBoard = Board::create([
            'title' => $this->title,
            'description' => $this->description,
            'background_color' => $this->background_color,
            'user_id' => auth()->id(),
            'position' => $maxPosition + 1,
        ]);

        $this->reset(['title', 'description', 'background_color', 'showCreateBoard']);
        $this->background_color = '#ffffff'; // Reset to default
        $this->boards = auth()->user()->boards;
        $this->selectBoard($newBoard->id);
    }

    public function createList()
    {
        $this->validate([
            'newListTitle' => 'required|min:1|max:255',
        ]);

        if (!$this->board) return;

        $maxPosition = $this->board->taskLists()->max('position') ?? -1;

        TaskList::create([
            'title' => $this->newListTitle,
            'board_id' => $this->board->id,
            'position' => $maxPosition + 1,
        ]);

        $this->newListTitle = '';
        $this->board = $this->board->fresh(['taskLists.tasks']);
    }

    public function deleteList($listId)
    {
        $taskList = TaskList::where('id', $listId)
            ->whereHas('board', fn($query) => $query->where('user_id', auth()->id()))
            ->first();

        if ($taskList) {
            $taskList->delete();
            $this->board = $this->board->fresh(['taskLists.tasks']);
        }
    }

    public function toggleTaskComplete($taskId)
    {
        $task = Task::where('id', $taskId)
            ->where('user_id', auth()->id())
            ->first();

        if ($task) {
            $task->update(['completed' => !$task->completed]);
            $this->board = $this->board->fresh(['taskLists.tasks']);
        }
    }

    public function deleteTask($taskId)
    {
        $task = Task::where('id', $taskId)
            ->where('user_id', auth()->id())
            ->first();

        if ($task) {
            $task->delete();
            $this->board = $this->board->fresh(['taskLists.tasks']);
        }
    }

    #[On('task-created')]
    public function refreshBoard()
    {
        if ($this->board) {
            $this->board = $this->board->fresh(['taskLists.tasks']);
        }
    }

    #[On('task-moved')]
    public function updateTaskPosition($taskId, $newListId, $newPosition)
    {
        $task = Task::where('id', $taskId)
            ->where('user_id', auth()->id())
            ->first();

        if ($task) {
            $task->update([
                'task_list_id' => $newListId,
                'position' => $newPosition,
            ]);
            
            $this->board = $this->board->fresh(['taskLists.tasks']);
        }
    }

    public function render()
    {
        return view('livewire.task-board-clean');
    }
}