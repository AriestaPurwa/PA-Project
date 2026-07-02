<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    public function categories()
    {
        return $this->hasMany(ProjectTypeCategory::class);
    }
}
