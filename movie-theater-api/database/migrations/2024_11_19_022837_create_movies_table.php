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
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('movie_id');
            $table->string('movie_name');
            $table->text('summary')->nullable();
            $table->integer('duration');
            $table->date('release_date');
            $table->string('author')->nullable();
            $table->string('actor')->nullable();
            $table->string('language', 100)->nullable();
            $table->string('trailer', 255)->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->string('poster_url')->nullable();
            $table->string('banner_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
