<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id()
                ->index()
                ->comment('Id of the user');

            $table->timestamps();

            $table->string('first_name')
                ->nullable(false)
                ->index()
                ->comment('First name of the user');

            $table->string('last_name')
                ->nullable(false)
                ->index()
                ->comment('Last name of the user');

            $table->string('nickname')
                ->nullable(false)
                ->unique()
                ->comment('Nickname of thee user');

            $table->string('email')
                ->nullable(false)
                ->unique()
                ->comment('E-mail of the user');

            $table->timestamp('email_verified_at')
                ->nullable()
                ->comment('Date of e-mail verification');

            $table->string('avatar')
                ->nullable(false)
                ->default('https://i.servimg.com/u/f21/18/21/41/30/na1110.png')
                ->comment('Link to the avatar of user');

            $table->string('password')
                ->nullable(false)
                ->comment('Password of the user');

            $table->enum('role', ['user', 'admin'])
                ->nullable(false)
                ->default('user')
                ->comment('Role of the user');

            $table->enum('ban', [0, 1])
                ->nullable(false)
                ->default(0)
                ->comment('Block status of user');

            $table->string('reason_ban')
                ->nullable()
                ->comment('Reason of ban for user');

            $table->text('category_list')
                ->nullable()
                ->comment('History of user subscribes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
