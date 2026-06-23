<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectSprint;

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
    public function sprints()
    {
        return $this->belongsToMany(ProjectSprint::class, 'sprint_risks', 'risk_id', 'sprint_id')
            ->withPivot('mitigation_status', 'notes')
            ->withTimestamps();
    }

}
