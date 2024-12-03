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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->string('favicon');
            $table->string('logo');
            $table->string('email');
            $table->string('facebook');
            $table->string('youtube');
            $table->string('country')->default('Egypt');
            $table->string('city')->default('Cairo');
            $table->string('street')->default('Ain Shams');
            $table->string('phone');
            $table->text('small_description')->default('small_description for SEO website');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
