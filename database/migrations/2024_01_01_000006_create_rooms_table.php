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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('code');
            $table->string('type'); // Standard, Deluxe, Suite
            $table->decimal('price_monthly', 12, 0);
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available');
            $table->text('facilities')->nullable();
            $table->text('description')->nullable();
            $table->integer('floor')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
