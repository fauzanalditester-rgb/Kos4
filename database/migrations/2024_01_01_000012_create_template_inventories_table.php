<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantity')->default(1);
            $table->enum('condition', ['new', 'good', 'fair', 'poor', 'broken'])->default('good');
            $table->decimal('price', 12, 0)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_inventories');
    }
};
