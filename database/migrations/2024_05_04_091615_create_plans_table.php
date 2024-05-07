<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {

            $table->id()
                ->comment('Id of the plan');

            $table->timestamps();

            $table->string('title_en')
                ->nullable(false)
                ->comment('Title of the plan in English');

            $table->string('title_uk')
                ->nullable(false)
                ->comment('Title of the plan in Ukrainian');

            $table->integer('duration')
                ->nullable(false)
                ->comment('Duration of the plan in days');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
