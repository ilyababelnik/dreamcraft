<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->string('description_en')
                ->nullable(false)
                ->comment('Description of plan in English');

            $table->string('description_uk')
                ->nullable(false)
                ->comment('Description of plan in Ukrainian');

            $table->float('price')
                ->nullable(false)
                ->comment('Month price of plan');

            $table->string('restrictions_en')
                ->nullable()
                ->comment('Restrictions of the plan in English');

            $table->string('restrictions_uk')
                ->nullable()
                ->comment('Restrictions of the plan in Ukrainian');
        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('description_en');
            $table->dropColumn('description_uk');
            $table->dropColumn('price');
            $table->dropColumn('restrictions_en');
            $table->dropColumn('restrictions_uk');
        });
    }
};
