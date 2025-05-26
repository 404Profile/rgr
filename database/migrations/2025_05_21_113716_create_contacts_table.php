<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('email');
            $table->text('address_ru');
            $table->text('address_en');
            $table->string('map_latitude')->nullable();
            $table->string('map_longitude')->nullable();
            $table->json('social_links')->nullable(); // массив ссылок
            $table->string('working_hours_ru')->nullable();
            $table->string('working_hours_en')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
