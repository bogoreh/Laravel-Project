<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('stock_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->decimal('average_price', 10, 2);
            $table->decimal('total_investment', 12, 2);
            $table->decimal('current_value', 12, 2);
            $table->decimal('profit_loss', 12, 2)->default(0);
            $table->decimal('profit_loss_percent', 8, 2)->default(0);
            $table->timestamps();
            
            $table->unique(['user_id', 'stock_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};