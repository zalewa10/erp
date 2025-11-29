<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }
    public function timeLogs()
    {
        return $this->hasMany(TaskTimeLog::class);
    }

    public function activeLog()
    {
        return $this->hasOne(TaskTimeLog::class)
            ->whereNull('end_time');
    }
    public function totalMinutes()
    {
        return $this->timeLogs()
            ->whereNotNull('duration_minutes')
            ->sum('duration_minutes');
    }

    public function totalHours()
    {
        return round($this->totalMinutes() / 60, 2);
    }

    protected $fillable = [
        'title',
        'description',
        'client_id',
        'assigned_to',
        'created_by',
        'priority_id',
        'due_date',
        'amount',
    ];
}
