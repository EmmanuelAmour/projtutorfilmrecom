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
        Schema::create('like_keywords', function (Blueprint $table) {
            $table->id('id_like_keywords');
            $table->unsignedBigInteger('id_keyword');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_keyword')->references('id_keyword')->on('keywords')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');

            // Prevent duplicate likes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('like_keywords');
    }
};
