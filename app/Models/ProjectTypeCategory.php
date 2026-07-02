<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTypeCategory extends Model
{
    protected $fillable = [
        'project_type_id',
        'category_name',
    ];

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }
}