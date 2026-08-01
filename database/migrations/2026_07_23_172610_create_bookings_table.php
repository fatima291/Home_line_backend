<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');

            // بيانات العميل
            $table->string('full_name');
            $table->string('phone');
            $table->string('national_id');
            $table->string('email')->nullable();

            // عنوان الخدمة
            $table->string('city');
            $table->string('neighborhood');
            $table->string('street');
            $table->string('building_number')->nullable();
            $table->string('map_link')->nullable();

            // ملاحظات
            $table->text('notes')->nullable();

            // خيارات خاصة بكل خدمة (JSON مرن)
            $table->json('service_options')->nullable();

            // حالة الحجز
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};