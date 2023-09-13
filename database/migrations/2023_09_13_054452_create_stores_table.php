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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 50)->nullable();
            $table->string('symbol', 10)->nullable(); // currency symbol
            $table->string('email', 100)->nullable();
            $table->string('tagline', 150)->nullable();
            $table->longText('description')->nullable();
            $table->string('contact')->nullable();
            $table->enum('contact_type', ['mobile', 'lineland', 'other'])->default('other');
            $table->string('cover')->nullable();
            $table->string('logo')->nullable();
            $table->enum('status', ['active', 'inactive', 'other'])->default('other');
            // $table->boolean('published')->default(false);

            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100)->nullable();

            $table->float('shipping')->default(0);
            $table->float('tax')->default(0);

            $table->timestamps();

            // $table->unsignedBigInteger('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
