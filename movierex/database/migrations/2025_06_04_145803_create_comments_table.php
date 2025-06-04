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
        Schema::create('comments', function (Blueprint $table) {
            $table->id('id_comment')->autoIncrement();
            $table->unsignedBigInteger('id_movie');
            $table->unsignedBigInteger('id_user');
            $table->text('comment');
            $table->timestamps();

            $table->foreign('id_movie')->references('id_movie')->on('movies')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
