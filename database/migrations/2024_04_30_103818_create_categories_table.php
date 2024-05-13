<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id()
                ->index()
                ->comment('Id of the category');

            $table->timestamps();

            $table->string('title')
                ->nullable(false)
                ->index()
                ->comment('Title of the category');

            $table->text('description_en')
                ->nullable(false)
                ->comment('Description of the category in English');

            $table->text('description_uk')
                ->nullable(false)
                ->comment('Description of the category in Ukrainian');

            $table->text('image')
                ->nullable(false)
                ->comment('Link to the image of the category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
