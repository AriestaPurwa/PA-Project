<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_risks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('task_id')
                ->constrained('project_tasks')
                ->cascadeOnDelete();

            $table->foreignId('risk_id')
                ->constrained('risks')
                ->cascadeOnDelete();

            $table->string('monitoring_status')->default('Open');
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(['task_id', 'risk_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_risks');
    }
};