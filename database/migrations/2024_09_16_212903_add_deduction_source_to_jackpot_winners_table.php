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
        $table->string('deduction_source')->default('jackpot');  // Possible values: jackpot or meter
    });
}

public function down()
{
    Schema::table('jackpot_winners', function (Blueprint $table) {
        $table->dropColumn('deduction_source');
    });
}
};
