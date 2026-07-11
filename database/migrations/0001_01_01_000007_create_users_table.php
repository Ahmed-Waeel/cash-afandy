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

        Schema::create('users', function (Blueprint $table) use ($driver) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');

            if ($driver === 'sqlite') {
                $table->string('full_name')->storedAs('first_name || " " || last_name');
            } else {
                $table->string('full_name')->storedAs('CONCAT(first_name, " ", last_name)');
            }

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('last_login_at')->nullable()->default(null);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
