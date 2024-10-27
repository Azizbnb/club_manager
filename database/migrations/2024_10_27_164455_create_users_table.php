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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('password');
            $table->enum('gender', ['homme', 'femme']);
            $table->date('birth_date');
            $table->string('email')->unique();
            $table->enum('experience', ['débutant', 'intermédiaire', 'avancé']);
            $table->string('address');
            $table->string('phone');
            $table->boolean('profile_status')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->timestamps();

            $table->foreignId('category_id')->constrained()->onDelete('cascade');
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
