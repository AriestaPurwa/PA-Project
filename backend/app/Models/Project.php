<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'nama_project',
        'deskripsi',
        'project_type_id',
        // baru
        'status',
        'progress',
        'estimated_budget',
    ];
    public function categories()
    {
        return $this->hasMany(RiskCategory::class);
    }

    protected static function booted()
    {
        static::deleting(function ($project) {

            foreach ($project->riskCategories as $category) {
                $category->delete();
            }

        });
    }

    public function risks()
    {
        return $this->hasMany(Risk::class);
    }

    public function riskCategories()
    {
        return $this->hasMany(RiskCategory::class);
    }

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
    
}
