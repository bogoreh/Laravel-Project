<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tweet_logs', function (Blueprint $table) {
            $table->id();
            $table->string('tweet_id')->nullable();
            $table->text('content');
            $table->string('type'); // tweet, reply, like, retweet
            $table->json('response_data')->nullable();
            $table->string('status')->default('pending'); // pending, posted, failed
            $table->timestamps();
            
            $table->index('tweet_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tweet_logs');
    }
};