<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('spam_logs', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->float('spam_probability');
            $table->boolean('is_spam');
            $table->string('source')->nullable();
            $table->json('features')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spam_logs');
    }
};