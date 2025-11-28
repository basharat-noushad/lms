<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->enum('content_type', ['video', 'text', 'quiz', 'assignment'])->default('video');
            $table->longText('description')->nullable();
            $table->string('video_url', 500)->nullable();
            $table->enum('video_provider', ['self', 'youtube', 'vimeo', 'external'])->default('self');
            $table->integer('video_duration')->default(0)->comment('in seconds');
            $table->longText('text_content')->nullable();
            $table->boolean('is_free_preview')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index('section_id');
            $table->index('uuid');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
