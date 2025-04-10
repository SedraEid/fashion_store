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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
    $table->string('product_name');
    $table->text('description')->nullable();
    $table->decimal('price', 8, 2);
    $table->string('color');
    $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
    $table->foreignId('saller_id')->constrained('sellers')->onDelete('cascade');
    $table->integer('stock_quantity')->default(0);
    $table->decimal('discounts', 5, 2)->default(0);
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
