<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration  // ← Changed from CreateEventsTable
{
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('color')->default('#fbbf24');
            $table->boolean('is_pinned')->default(false);
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['is_pinned', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('notes');
    }
}