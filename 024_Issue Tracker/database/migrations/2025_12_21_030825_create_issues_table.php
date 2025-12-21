<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuesTable extends Migration
{
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->enum('type', ['bug', 'feature', 'task', 'improvement'])->default('task');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->foreignId('reported_by')->constrained('users');
            $table->timestamp('due_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('issues');
    }
}