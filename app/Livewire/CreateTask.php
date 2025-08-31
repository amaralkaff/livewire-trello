<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;

class CreateTask extends Component
{
    public $taskListId;
    public $title = '';
    public $description = '';
    public $priority = 'medium';
    public $due_date = '';
    public $showForm = false;

    public function mount($taskListId)
    {
        $this->taskListId = $taskListId;
    }

    public function createTask()
    {
        $this->validate([
            'title' => 'required|min:1|max:255',
            'description' => 'nullable|max:1000',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        $maxPosition = Task::where('task_list_id', $this->taskListId)->max('position') ?? -1;

        Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'task_list_id' => $this->taskListId,
            'user_id' => auth()->id(),
            'priority' => $this->priority,
            'due_date' => $this->due_date ?: null,
            'position' => $maxPosition + 1,
            'completed' => false,
        ]);

        $this->reset(['title', 'description', 'priority', 'due_date', 'showForm']);
        $this->dispatch('task-created');
    }

    public function render()
    {
        return view('livewire.create-task');
    }
}