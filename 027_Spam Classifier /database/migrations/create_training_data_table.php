<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('training_data', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->enum('label', ['spam', 'ham']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('training_data');
    }
};