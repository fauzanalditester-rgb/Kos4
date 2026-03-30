<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('category');
            $table->integer('quantity')->default(1);
            $table->string('unit')->default('pcs');
            $table->decimal('price', 12, 0)->default(0);
            $table->date('purchase_date')->nullable();
            $table->enum('condition', ['new', 'good', 'fair', 'poor', 'broken'])->default('good');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
