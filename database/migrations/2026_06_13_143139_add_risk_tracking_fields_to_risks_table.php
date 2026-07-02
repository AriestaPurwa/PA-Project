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
        Schema::table('risks', function (Blueprint $table) {
            $table->string('status')
                ->default('Open')
                ->after('risk_level');

            $table->boolean('is_occurred')
                ->default(false)
                ->after('status');

            $table->timestamp('resolved_at')
                ->nullable()
                ->after('is_occurred');
        });
    }

    public function down(): void
    {
        Schema::table('risks', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'is_occurred',
                'resolved_at',
            ]);
        });
    }
};
