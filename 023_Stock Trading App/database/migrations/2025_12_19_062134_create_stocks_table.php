<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('symbol')->unique();
            $table->string('company_name');
            $table->decimal('current_price', 10, 2);
            $table->decimal('change', 8, 2)->default(0);
            $table->decimal('change_percent', 5, 2)->default(0);
            $table->bigInteger('volume')->default(0);
            $table->decimal('high', 10, 2);
            $table->decimal('low', 10, 2);
            $table->decimal('open', 10, 2);
            $table->decimal('previous_close', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};