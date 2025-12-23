<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->decimal('price', 8, 2);
            $table->integer('stock_quantity');
            $table->string('cover_image')->nullable();
            $table->string('genre');
            $table->integer('release_year');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('albums');
    }
};