<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sprint_risks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sprint_id')
                ->constrained('project_sprints')
                ->cascadeOnDelete();

            $table->foreignId('risk_id')
                ->constrained('risks')
                ->cascadeOnDelete();

            $table->string('mitigation_status')->default('Open');
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(['sprint_id', 'risk_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sprint_risks');
    }
};