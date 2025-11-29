<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskTimeLog extends Model
{
    protected $fillable = [
        'task_id',
        'start_time',
        'end_time',
        'duration_minutes',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
