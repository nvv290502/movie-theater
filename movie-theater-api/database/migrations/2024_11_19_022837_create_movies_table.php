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
            $table->string('movie_name')->nullable();
            $table->text('summary');
            $table->tinyInteger('duration')->nullable();
            $table->date('release_date')->nullable();
            $table->string('author')->nullable();
            $table->string('actor')->nullable();
            $table->string('language', 100);
            $table->string('trailer', 255);
            $table->boolean('is_enabled')->default(true);
            $table->string('poster_url');
            $table->string('banner_url');

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
