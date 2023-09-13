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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->tinyInteger('quantity')->default(0);
            $table->float('price')->default(0);
            $table->float('discount')->default(0);
            $table->enum('status', ['available', 'pending', 'other'])->default('other');

            $table->foreignId('order_id')->index()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('product_id')->index()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('store_id')->index()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
