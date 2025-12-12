<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('artist');
            $table->string('album')->nullable();
            $table->string('file_path');
            $table->string('cover_image')->nullable();
            $table->integer('duration')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('songs');
    }
};