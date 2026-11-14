<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpBuckflowTestDatabase();
    }

    protected function setUpBuckflowTestDatabase(): void
    {
        if (config('database.connections.buckflow.driver') === 'sqlite') {
            Schema::connection('buckflow')->dropIfExists('order_items');
            Schema::connection('buckflow')->dropIfExists('orders');
            Schema::connection('buckflow')->dropIfExists('products');
            Schema::connection('buckflow')->dropIfExists('users');

            Schema::connection('buckflow')->create('users', function ($table) {
                $table->id();
                $table->string('name');
                $table->string('username')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('role')->default('florist');
                $table->string('avatar_url')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });

            Schema::connection('buckflow')->create('products', function ($table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->nullable();
                $table->string('sku')->nullable();
                $table->string('category')->nullable();
                $table->unsignedBigInteger('series_id')->nullable();
                $table->string('sub_name')->nullable();
                $table->string('dominant_color')->nullable();
                $table->integer('stock')->default(0);
                $table->decimal('selling_price', 12, 2)->default(0);
                $table->string('image_url')->nullable();
                $table->string('image_path')->nullable();
                $table->text('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });

            Schema::connection('buckflow')->create('orders', function ($table) {
                $table->id();
                $table->string('tracking_code', 50)->unique();
                $table->string('customer_name', 150);
                $table->string('customer_phone', 30);
                $table->unsignedBigInteger('reseller_id')->nullable();
                $table->unsignedBigInteger('created_by_user_id')->nullable();
                $table->unsignedBigInteger('florist_user_id')->nullable();
                $table->string('status', 40)->default('pending');
                $table->string('payment_status', 30)->default('unpaid');
                $table->decimal('total_amount', 14, 2)->default(0);
                $table->decimal('total_cogs', 14, 2)->default(0);
                $table->string('payment_method', 50)->default('transfer_manual');
                $table->string('greeting_card_message', 500)->nullable();
                $table->string('event_type', 50)->nullable();
                $table->date('event_date')->nullable();
                $table->string('crm_follow_up_status', 30)->default('pending');
                $table->dateTime('crm_last_contacted_at')->nullable();
                $table->dateTime('deadline_at')->nullable();
                $table->dateTime('production_started_at')->nullable();
                $table->dateTime('ready_at')->nullable();
                $table->dateTime('completed_at')->nullable();
                $table->text('notes')->nullable();
                $table->string('courier_name', 100)->nullable();
                $table->string('courier_tracking_url', 500)->nullable();
                $table->string('qc_photo_path', 500)->nullable();
                $table->timestamps();
                $table->softDeletes();
            });

            Schema::connection('buckflow')->create('order_items', function ($table) {
                $table->id();
                $table->unsignedBigInteger('order_id');
                $table->unsignedBigInteger('product_id')->nullable();
                $table->integer('quantity')->default(1);
                $table->decimal('unit_price', 12, 2)->default(0);
                $table->decimal('unit_cogs', 12, 2)->default(0);
                $table->decimal('subtotal', 14, 2)->default(0);
                $table->text('customization_notes')->nullable();
                $table->timestamps();
            });
        }
    }
}
