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
        Schema::create('room_seat', function (Blueprint $table) {
            $table->bigIncrements('room_seat_id');
            $table->enum('type_seat', ['NORMAL', 'VIP', "HIDDEN"]);
            $table->unsignedBigInteger('seat_id');
            $table->unsignedBigInteger('room_id');
            $table->unique(['seat_id','room_id']);
            $table->foreign('seat_id')->references('seat_id')->on('seats');
            $table->foreign('room_id')->references('room_id')->on('rooms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_seat');
    }
};
