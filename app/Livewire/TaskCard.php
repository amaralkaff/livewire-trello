<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;

class TaskCard extends Component
{
    public Task $task;
    public $editing = false;
    public $title;
    public $description;
    public $priority;
    public $due_date;

    public function mount(Task $task)
    {
        $this->task = $task;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->priority = $task->priority;
        $this->due_date = $task->due_date?->format('Y-m-d');
    }

    public function edit()
    {
        $this->editing = true;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|min:1|max:255',
            'description' => 'nullable|max:1000',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        $this->task->update([
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'due_date' => $this->due_date,
        ]);

        $this->editing = false;
        $this->dispatch('task-updated');
    }

    public function cancel()
    {
        $this->title = $this->task->title;
        $this->description = $this->task->description;
        $this->priority = $this->task->priority;
        $this->due_date = $this->task->due_date?->format('Y-m-d');
        $this->editing = false;
    }

    public function toggleComplete()
    {
        $this->task->update([
            'completed' => !$this->task->completed
        ]);
        $this->task = $this->task->fresh();
        $this->dispatch('task-updated');
    }

    public function deleteTask()
    {
        $this->task->delete();
        $this->dispatch('task-deleted');
    }

    public function render()
    {
        return view('livewire.task-card');
    }
}
