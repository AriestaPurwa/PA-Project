<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('sprint_risks');
        Schema::dropIfExists('sprint_tasks');
        Schema::dropIfExists('project_sprints');
    }

    public function down(): void
    {
        //
    }
};