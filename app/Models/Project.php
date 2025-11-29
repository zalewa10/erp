<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function totalMinutes()
    {
        return $this->tasks()
            ->with('timeLogs')
            ->get()
            ->flatMap(fn($task) => $task->timeLogs)
            ->whereNotNull('duration_minutes')
            ->sum('duration_minutes');
    }

    public function totalHours()
    {
        return round($this->totalMinutes() / 60, 2);
    }


    protected $fillable = [
        'name',
        'client_id',
        'amount',
        'description',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
