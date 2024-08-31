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
        Schema::create('jackpots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('seed_amount', 15, 2);
            $table->decimal('current_amount', 15, 2)->default(0);
            $table->decimal('contribution_percentage', 5, 2);
            $table->boolean('is_global')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jackpots');
    }
};
