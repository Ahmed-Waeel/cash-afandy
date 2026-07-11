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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('locale');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('excerpt')->nullable();
            $table->text('content');
            $table->string('cover_image');
            $table->string('media_type')->nullable();
            $table->text('media')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('tags')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
