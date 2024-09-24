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
    Schema::create('audit_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Foreign key for user
        $table->string('event_type'); // e.g., login, logout, navigation, etc.
        $table->text('details')->nullable(); // Store route or additional details like IP, session length
        $table->ipAddress('ip_address')->nullable(); // Store user IP address
        $table->timestamps(); // Record time of the action
    });
}

public function down()
{
    Schema::dropIfExists('audit_logs');
}
};
