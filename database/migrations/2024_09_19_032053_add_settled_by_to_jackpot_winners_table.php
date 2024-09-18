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
        $table->unsignedBigInteger('settled_by')->nullable()->after('is_settled');
        $table->foreign('settled_by')->references('id')->on('users')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('jackpot_winners', function (Blueprint $table) {
        $table->dropForeign(['settled_by']);
        $table->dropColumn('settled_by');
    });
}
};
