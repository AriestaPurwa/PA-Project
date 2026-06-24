<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSubtask extends Model
{
    protected $fillable = [
        'task_id',
        'name',
        'status',
    ];

    public function task()
    {
        return $this->belongsTo(ProjectTask::class, 'task_id');
    }
}