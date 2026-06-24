<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_subtasks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('task_id')
                ->constrained('project_tasks')
                ->cascadeOnDelete();

            $table->string('name');

            $table->string('status')->default('To Do');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_subtasks');
    }
};