<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTypeCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('project_type_categories')->insert([
            // Software Development
            ['project_type_id' => 1, 'category_name' => 'Technical'],
            ['project_type_id' => 1, 'category_name' => 'Security'],
            ['project_type_id' => 1, 'category_name' => 'Infrastructure'],
            ['project_type_id' => 1, 'category_name' => 'Management'],

            // Construction
            ['project_type_id' => 2, 'category_name' => 'Technical'],
            ['project_type_id' => 2, 'category_name' => 'Safety'],
            ['project_type_id' => 2, 'category_name' => 'Resource'],
            ['project_type_id' => 2, 'category_name' => 'Management'],

            // Research
            ['project_type_id' => 3, 'category_name' => 'Methodology'],
            ['project_type_id' => 3, 'category_name' => 'Resource'],
            ['project_type_id' => 3, 'category_name' => 'External'],
            ['project_type_id' => 3, 'category_name' => 'Management'],

            // General Project
            ['project_type_id' => 4, 'category_name' => 'Technical'],
            ['project_type_id' => 4, 'category_name' => 'Management'],
            ['project_type_id' => 4, 'category_name' => 'Organizational'],
            ['project_type_id' => 4, 'category_name' => 'External'],
        ]);
    }
}
