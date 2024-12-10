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
        Schema::create('bill_detail', function (Blueprint $table) {
            $table->bigIncrements('bill_detail_id');
            $table->unsignedBigInteger('schedule_room_id');
            $table->unsignedBigInteger('bill_id');
            $table->unsignedBigInteger('seat_id');

            $table->foreign('schedule_room_id')->references('schedule_room_id')->on('schedule_room');
            $table->foreign('bill_id')->references('bill_id')->on('bills');
            $table->foreign('seat_id')->references('seat_id')->on('seats');
            $table->float('price')->nullable();
            $table->string('bill_code')->nullable();
            $table->timestamps();
            $table->unique(['schedule_room_id', 'bill_id', 'seat_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_detail');
    }
};
