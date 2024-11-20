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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->string('username', 50);
            $table->string('email', 50)->unique();
            $table->string('full_name', 255)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone', 12);
            $table->string('avatar_url')->nullable();;
            $table->enum('signup_device', ['LOCAL', 'GOOGLE'])->nullable();
            $table->enum('member_ship_level', ['BASIC', 'SILVER', 'GOLD', 'PLATINUM', 'DIAMOND'])->nullable();
            $table->boolean('is_enabled');
            $table->boolean('is_confirm');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken('remember_token');
            $table->timestamps();
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('role_id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
