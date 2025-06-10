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
        Schema::create('like_genres', function (Blueprint $table) {
            $table->id('id_like_genres')->autoIncrement();
            $table->unsignedBigInteger('id_genre');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_genre')->references('id_genre')->on('genres');
            $table->foreign('id_user')->references('id_user')->on('users');

            // Prevent duplicate likes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('like_genres');
    }
};
