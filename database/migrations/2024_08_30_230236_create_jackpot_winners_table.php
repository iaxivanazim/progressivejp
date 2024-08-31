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
        Schema::create('jackpot_winners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jackpot_id')->constrained()->onDelete('cascade');
            $table->foreignId('game_table_id')->constrained()->onDelete('cascade');
            $table->string('table_name');
            $table->unsignedInteger('sensor_number');
            $table->decimal('win_amount', 15, 2);
            $table->boolean('is_settled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jackpot_winners');
    }
};
