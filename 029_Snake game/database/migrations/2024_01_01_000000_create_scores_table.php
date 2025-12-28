<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('scores')) {
            Schema::create('scores', function (Blueprint $table) {
                $table->id();
                $table->string('player_name', 50);
                $table->integer('score')->default(0);
                $table->integer('level')->default(1);
                $table->integer('snake_length')->default(3);
                $table->timestamps();
                
                $table->index('score'); // For faster high score queries
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};