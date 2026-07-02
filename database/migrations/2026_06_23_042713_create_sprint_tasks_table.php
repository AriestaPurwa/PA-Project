<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sprint_tasks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sprint_id')
                ->constrained('project_sprints')
                ->cascadeOnDelete();

            $table->string('name');
            $table->text('description')->nullable();

            $table->decimal('weight', 8, 2)->default(1);

            $table->string('status')->default('To Do');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sprint_tasks');
    }
};