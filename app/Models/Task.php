<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'task_list_id',
        'user_id',
        'priority',
        'due_date',
        'position',
        'completed',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed' => 'boolean',
    ];

    public function taskList(): BelongsTo
    {
        return $this->belongsTo(TaskList::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function board()
    {
        return $this->taskList->board();
    }

    public function priorityColor(): Attribute
    {
        return Attribute::get(function () {
            return match($this->priority) {
                'low' => 'bg-green-100 text-green-800',
                'medium' => 'bg-yellow-100 text-yellow-800', 
                'high' => 'bg-red-100 text-red-800',
                default => 'bg-gray-100 text-gray-800'
            };
        });
    }
}
