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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->default(config('app.fallback_locale'))->index();
            $table->string('image');
            $table->string('background_size')->default('cover');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('foreground')->default('#ffffff');
            $table->string('background')->default('#00000080');
            $table->json('buttons')->nullable();
            $table->boolean('active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('admins');
            $table->foreignId('updated_by')->nullable()->constrained('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
