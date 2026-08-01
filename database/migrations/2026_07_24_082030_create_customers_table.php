<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('full_name');
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->string('phone')->unique();
            $table->string('national_id');
            $table->string('city');
            $table->string('neighborhood');
            $table->string('street');
            $table->string('building_number')->nullable();
            $table->string('location_link')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};