<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('url');
            $table->string('image_url')->nullable();
            $table->string('author')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();
            
            // SQLite doesn't support multiple columns in unique() constraint the same way
            // We'll handle this differently
        });

        // Add unique constraint separately for SQLite compatibility
        DB::statement('CREATE UNIQUE INDEX articles_source_url_unique ON articles(source_id, url)');
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};