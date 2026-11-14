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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('delivery_method', 20)->default('DELIVERY')->after('bouquet_type');
            // Change status to string(40) to accommodate READY_FOR_PICKUP & PICKED_UP
            $table->string('status', 40)->default('ORDER_PLACED')->change();
            // Allow delivery_address to be nullable for self pick-up orders
            $table->text('delivery_address')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('delivery_method');
            $table->enum('status', [
                'ORDER_PLACED',
                'CRAFTING',
                'PHOTO_APPROVAL',
                'PACKAGING',
                'OUT_FOR_DELIVERY',
                'DELIVERED',
            ])->default('ORDER_PLACED')->change();
        });
    }
};
