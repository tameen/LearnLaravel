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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->enum('source', ['web', 'ios', 'android', 'other'])->default('other');
            $table->enum('status', ['active', 'inactive', 'other'])->default('other');

            $table->boolean('active')->default(true);
            $table->text('instruction')->nullable();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email', 100)->nullable();
            $table->string('mobile', 100)->nullable();
            $table->string('lineland', 100)->nullable();

            $table->string('billing_address1')->nullable();
            $table->string('billing_address2')->nullable();
            $table->string('billing_city', 50)->nullable();
            $table->string('billing_state', 100)->nullable();
            $table->string('billing_postal_code', 20)->nullable();
            $table->string('billing_country', 100)->nullable();

            $table->string('shipping_address1')->nullable();
            $table->string('shipping_address2')->nullable();
            $table->string('shipping_city', 50)->nullable();
            $table->string('shipping_state', 100)->nullable();
            $table->string('shipping_postal_code', 20)->nullable();
            $table->string('shipping_country', 100)->nullable();

            $table->string('promo')->nullable();
            $table->unsignedBigInteger('coupon_id')->default(0);

            $table->float('subtotal')->default(0);
            $table->float('shipping')->default(0);
            $table->float('tax')->default(0);
            $table->float('discount')->default(0);
            $table->float('total')->default(0);

            $table->foreignId('user_id')->index()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
