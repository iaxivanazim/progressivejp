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
    Schema::table('hands', function (Blueprint $table) {
        $table->boolean('float')->default(false);  // Adding the float flag with default false
    });
}

public function down()
{
    Schema::table('hands', function (Blueprint $table) {
        $table->dropColumn('float');
    });
}
};
