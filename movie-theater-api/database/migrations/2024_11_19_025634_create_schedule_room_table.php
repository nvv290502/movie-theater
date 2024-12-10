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
        Schema::create('schedule_room', function (Blueprint $table) {
            $table->bigIncrements('schedule_room_id');
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('room_id');
            $table->foreign('schedule_id')->references('schedule_id')->on('schedules');
            $table->foreign('room_id')->references('room_id')->on('rooms');
            $table->float('price')->nullable();
            $table->timestamps();
            $table->unique(['schedule_id', 'room_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_room');
    }
};
