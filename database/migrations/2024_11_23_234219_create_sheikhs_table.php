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
        Schema::create('sheikhs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('image');
            $table->string('age');
            $table->string('gender');
            $table->string('level_of_english');
            $table->boolean('vacation');
            $table->string('education');
            $table->string('time_available');
            $table->boolean('studies');
            $table->string('links');
            $table->string('cv');
            $table->string('recommendations');
            $table->string('title');
            $table->text('description');
            $table->string('experience');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sheikhs');
    }
};
