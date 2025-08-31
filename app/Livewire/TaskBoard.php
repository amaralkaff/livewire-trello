<?php

namespace App\Livewire;

use App\Models\Board;
use App\Models\TaskList;
use App\Models\Task;
use Livewire\Component;
use Livewire\Attributes\On;

class TaskBoard extends Component
{
    public ?Board $board = null;
    public $boards;
    public $selectedBoardId = null;
    public $showCreateBoard = false;
    public $newListTitle = '';

    public function mount(?Board $board = null)
    {
        $this->boards = auth()->user()->boards;
        
        if ($board && $board->user_id === auth()->id()) {
            $this->board = $board;
            $this->selectedBoardId = $board->id;
        } elseif ($this->boards->isNotEmpty()) {
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

    #[On('board-created')]
    public function refreshBoards()
    {
        $this->boards = auth()->user()->boards;
        $latestBoard = $this->boards->last();
        if ($latestBoard) {
            $this->selectBoard($latestBoard->id);
        }
        $this->showCreateBoard = false;
    }

    #[On('task-created')]
    #[On('task-updated')]
    #[On('task-deleted')]
    public function refreshBoard()
    {
        if ($this->board) {
            $this->board = $this->board->fresh(['taskLists.tasks']);
        }
    }

    #[On('toggle-task-complete')]
    public function toggleTaskComplete($taskId)
    {
        $task = Task::where('id', $taskId)
            ->where('user_id', auth()->id())
            ->first();

        if ($task) {
            $task->update(['completed' => !$task->completed]);
            $this->refreshBoard();
        }
    }

    #[On('delete-task')]
    public function deleteTask($taskId)
    {
        $task = Task::where('id', $taskId)
            ->where('user_id', auth()->id())
            ->first();

        if ($task) {
            $task->delete();
            $this->refreshBoard();
        }
    }

    public function render()
    {
        return view('livewire.task-board-minimal');
    }
}
