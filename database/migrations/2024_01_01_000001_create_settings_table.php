<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->integer('price_daily')->default(0);
            $table->integer('price_weekly')->default(0);
            $table->string('whatsapp_number')->default('6281234567890');
            $table->enum('status', ['available', 'maintenance'])->default('available');
            $table->text('room_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
