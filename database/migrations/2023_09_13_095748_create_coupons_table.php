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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['general', 'other'])->default('other');
            $table->string('promo',20);
            $table->tinyInteger('percentage')->default(0);;
            $table->text('comment')->nullable();
            $table->enum('status', ['active', 'inactive', 'other'])->default('other');
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
        Schema::dropIfExists('coupons');
    }
};
