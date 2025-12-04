<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('board_state')->default('{"board":[],"turn":"white","moves":[]}');
            $table->string('player_white')->nullable();
            $table->string('player_black')->nullable();
            $table->string('status')->default('waiting'); // waiting, ongoing, completed
            $table->string('winner')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};