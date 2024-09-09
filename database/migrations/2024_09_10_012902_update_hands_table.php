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
        Schema::table('hands', function (Blueprint $table) {
            $table->enum('deduction_type', ['percentage', 'fixed'])->default('fixed');
            $table->decimal('deduction_value', 10, 2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hands', function (Blueprint $table) {
            $table->dropColumn(['deduction_type', 'deduction_value']);
        });
    }
};
