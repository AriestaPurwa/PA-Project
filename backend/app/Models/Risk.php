<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectTask;

class Risk extends Model
{
    protected $fillable = [
        'project_id',
        'category_id',
        'nama_risiko',
        'probability',
        'impact',
        'risk_score',
        'risk_level',
        'deskripsi',
        // baru
        'status',
        'is_occurred',
        'resolved_at',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function category()
    {
        return $this->belongsTo(RiskCategory::class, 'category_id');
    }

    public function projectTasks()
    {
        return $this->belongsToMany(ProjectTask::class, 'task_risks', 'risk_id', 'task_id')
            ->withPivot('monitoring_status', 'notes')
            ->withTimestamps();
    }

}
