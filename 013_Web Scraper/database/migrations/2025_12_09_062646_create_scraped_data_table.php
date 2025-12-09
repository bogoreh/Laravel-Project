<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapedDataTable extends Migration
{
    public function up()
    {
        Schema::create('scraped_data', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('url');
            $table->text('description')->nullable();
            $table->json('data')->nullable();
            $table->string('status')->default('pending');
            $table->timestamp('scraped_at')->nullable();
            $table->timestamps();
            
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('scraped_data');
    }
}