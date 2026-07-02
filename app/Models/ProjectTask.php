<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'start_date',
        'end_date',
        'duration_days',
        'task_cost',
        'status',
        'progress',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function subtasks()
    {
        return $this->hasMany(ProjectSubtask::class, 'task_id');
    }

    public function risks()
    {
        return $this->belongsToMany(Risk::class, 'task_risks', 'task_id', 'risk_id')
            ->withPivot('monitoring_status', 'notes')
            ->withTimestamps();
    }
}