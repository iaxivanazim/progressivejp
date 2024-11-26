<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameTableHandTable extends Migration
{
    public function up(): void
    {
        Schema::create('game_table_hand', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_table_id');
            $table->unsignedBigInteger('hand_id');
            $table->timestamps();

            $table->foreign('game_table_id')->references('id')->on('game_tables')->onDelete('cascade');
            $table->foreign('hand_id')->references('id')->on('hands')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_table_hand');
    }
}