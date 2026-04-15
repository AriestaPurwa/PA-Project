<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'deskripsi'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function category()
    {
        return $this->belongsTo(RiskCategory::class, 'category_id');
    }

}
