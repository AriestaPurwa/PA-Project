<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RiskCategory;


class RiskCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Level 1
        $technical = RiskCategory::create([
            'project_id' => 1,
            'parent_id' => null,
            'nama_kategori' => 'Technical Risk',
            'level' => 1
        ]);

        // Level 2
        RiskCategory::create([
            'project_id' => 1,
            'parent_id' => $technical->id,
            'nama_kategori' => 'Server Risk',
            'level' => 2
        ]);

        RiskCategory::create([
            'project_id' => 1,
            'parent_id' => $technical->id,
            'nama_kategori' => 'Software Bug',
            'level' => 2
        ]);
    }
}
