<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSprint extends Model
{
    protected $fillable = [
        'project_id',
        'sprint_number',
        'name',
        'start_date',
        'end_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function tasks()
    {
        return $this->hasMany(SprintTask::class, 'sprint_id');
    }

    public function risks()
    {
        return $this->belongsToMany(Risk::class, 'sprint_risks', 'sprint_id', 'risk_id')
            ->withPivot('mitigation_status', 'notes')
            ->withTimestamps();
    }
}