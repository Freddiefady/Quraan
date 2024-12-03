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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم الباقة
            $table->integer('sessions_per_week'); // عدد الجلسات الأسبوعية
            $table->integer('session_duration'); // مدة الجلسة بالدقائق
            $table->decimal('price', 8, 2); // سعر الباقة
            $table->boolean('has_trial_lesson')->default(false); // هل الباقة تحتوي على درس تجريبي؟
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
