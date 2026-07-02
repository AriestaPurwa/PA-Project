<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('project_types')->insert([
            [
                'id' => 1,
                'name' => 'Software Development',
                'description' => 'Software, website, mobile app, dan sistem informasi',
                'is_active' => true,
            ],
            [
                'id' => 2,
                'name' => 'Construction',
                'description' => 'Proyek konstruksi dan pembangunan',
                'is_active' => true,
            ],
            [
                'id' => 3,
                'name' => 'Research',
                'description' => 'Proyek penelitian dan pengembangan',
                'is_active' => true,
            ],
            [
                'id' => 4,
                'name' => 'General Project',
                'description' => 'Proyek umum yang tidak termasuk kategori khusus',
                'is_active' => true,
            ],
        ]);
    }
}
