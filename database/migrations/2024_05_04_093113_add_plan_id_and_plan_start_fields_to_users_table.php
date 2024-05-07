<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('plan_id')
                ->nullable()
                ->index()
                ->constrained()
                ->cascadeOnDelete()
                ->comment('Connection with Plan table');

            $table->timestamp('start_plan')
                ->nullable()
                ->comment('Start plan date');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->dropColumn('plan_id');
            $table->dropColumn('start_plan');
        });
    }
};
