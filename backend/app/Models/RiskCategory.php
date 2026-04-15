<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiskCategory extends Model
{
    protected $fillable = [
        'project_id',
        'parent_id',
        'nama_kategori',
        'level',
    ];
    public function parent()
    {
        return $this->belongsTo(RiskCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(RiskCategory::class, 'parent_id');
    }

    public function risks()
    {
        return $this->hasMany(Risk::class, 'category_id');
    }

    protected static function booted()
    {
        static::deleting(function ($category) {

            foreach ($category->children as $child) {
                $child->delete();
            }

            foreach ($category->risks as $risk) {
                $risk->delete();
            }

        });
    }
}
