<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alarm_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alarm_id')->constrained()->onDelete('cascade');
            $table->timestamp('triggered_at');
            $table->timestamp('stopped_at')->nullable();
            $table->boolean('was_snoozed')->default(false);
            $table->integer('snooze_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alarm_logs');
    }
};