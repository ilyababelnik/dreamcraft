<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('mark')->nullable(false)->index();

            $table->foreignId('user_id')
                ->index()
                ->constrained()
                ->cascadeOnDelete()
                ->comment('Connection with Users table');

            $table->foreignId('category_id')
                ->index()
                ->constrained()
                ->cascadeOnDelete()
                ->comment('Connection with Category table');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};
