<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('status')
                ->default('Planning')
                ->after('project_type_id');

            $table->unsignedTinyInteger('progress')
                ->default(0)
                ->after('status');

            $table->decimal('estimated_budget', 15, 2)
                ->nullable()
                ->after('progress');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'progress',
                'estimated_budget',
            ]);
        });
    }
};
