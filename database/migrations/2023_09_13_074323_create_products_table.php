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
            $table->string('title');
            $table->string('thumbnail')->nullable();
            $table->string('sku')->unique();
            $table->text('tagline')->nullable();
            $table->longText('description')->nullable();
            $table->float('price')->default(0);
            $table->float('discount')->default(0);
            $table->enum('status', ['active', 'inactive', 'other'])->default('other');
            $table->boolean('published')->default(true);
            $table->boolean('featured')->default(false);
            $table->integer('stock')->default(0);
            $table->foreignId('store_id')->index()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->index()->constrained()->onDelete('cascade')->onUpdate('cascade');
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
