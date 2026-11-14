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
            $table->string('order_code')->unique(); // MAJA-2026-XXXX
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('recipient_name');
            $table->dateTime('delivery_date');
            $table->text('delivery_address');
            $table->enum('bouquet_type', ['CATALOG', 'CUSTOM'])->default('CATALOG');
            $table->decimal('total_price', 12, 2);
            $table->enum('status', [
                'ORDER_PLACED',
                'CRAFTING',
                'PHOTO_APPROVAL',
                'PACKAGING',
                'OUT_FOR_DELIVERY',
                'DELIVERED',
            ])->default('ORDER_PLACED');
            $table->text('greeting_card_note')->nullable();
            $table->json('custom_options')->nullable(); // wrapping, add-ons, etc.
            $table->string('preview_photo')->nullable(); // photo uploaded by florist for approval
            $table->string('customer_approval_status')->nullable(); // e.g. APPROVED, REVISION_REQUESTED
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
