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
        Schema::create('like_movies', function (Blueprint $table) {
            $table->id('id_like_movies')->autoIncrement();
            $table->unsignedBigInteger('id_movie');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_movie')->references('id_movie')->on('movies')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');

            // Prevent duplicate likes
            $table->unique(['id_movie', 'id_user']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('like_movies');


    }
};
