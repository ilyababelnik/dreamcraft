<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {

            $table->id()
                ->index()
                ->comment('Id of the comment');

            $table->timestamps();

            $table->text('text')
                ->nullable(false)
                ->comment('Comment text');

            $table->enum('is_edit', [0, 1])
                ->nullable(false)
                ->default(0)
                ->comment('Message edit status');

            $table->foreignId('category_id')
                ->nullable(false)
                ->index()
                ->constrained()
                ->cascadeOnDelete()
                ->comment('The category id in which the comment was left');

            $table->foreignId('user_id')
                ->nullable(false)
                ->index()
                ->constrained()
                ->cascadeOnDelete()
                ->comment('The user id who left a comment');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
