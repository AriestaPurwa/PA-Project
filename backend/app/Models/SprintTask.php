<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SprintTask extends Model
{
    protected $fillable = [
        'sprint_id',
        'name',
        'description',
        'weight',
        'status',
    ];

    public function sprint()
    {
        return $this->belongsTo(ProjectSprint::class, 'sprint_id');
    }
}