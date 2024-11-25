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
        Schema::create('cinemas', function (Blueprint $table) {
            $table->bigIncrements('cinema_id');
            $table->string('cinema_name', 255);
            $table->string('cinema_image_url')->nullable();
            $table->string('address')->nullable();
            $table->string('hotline', 20)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('rating')->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cinemas');
    }
};
