<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->string('image_url')->nullable();
            $table->timestamps();
            $table->softDeletes();            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
