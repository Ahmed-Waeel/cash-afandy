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
        $default = config('database.default');
        $driver = config("database.connections.$default.driver");

        Schema::create('language_tokens', function (Blueprint $table) use ($driver) {
            $table->id();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();

            if ($driver === 'mysql' || $driver === 'mariadb') {
                $table->text('key')->charset('utf8mb4')->collation('utf8mb4_bin'); // case-sensitive
            } else {
                $table->text('key');
            }

            $table->text('value');
            $table->text('original_translation');
            $table->boolean('from_json')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('language_tokens');
    }
};
