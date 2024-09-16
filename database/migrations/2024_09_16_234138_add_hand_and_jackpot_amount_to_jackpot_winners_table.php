<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('jackpot_winners', function (Blueprint $table) {
        $table->unsignedBigInteger('hand_id')->nullable(); // To store the selected hand ID
        $table->decimal('current_jackpot_amount', 10, 2)->nullable(); // To store the jackpot amount after each win

        $table->foreign('hand_id')->references('id')->on('hands')->onDelete('set null'); // Set null if hand is deleted
    });
}

public function down()
{
    Schema::table('jackpot_winners', function (Blueprint $table) {
        $table->dropForeign(['hand_id']);
        $table->dropColumn('hand_id');
        $table->dropColumn('current_jackpot_amount');
    });
}
};
