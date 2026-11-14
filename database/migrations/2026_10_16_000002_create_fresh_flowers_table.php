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
        Schema::create('fresh_flowers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('botanical_name', 150)->nullable();
            $table->string('origin', 100)->nullable();
            $table->string('color_name', 100);
            $table->string('color_hex', 20)->default('#E11D48');
            $table->unsignedInteger('stock_stems')->default(10);
            $table->enum('status', ['ready', 'limited', 'sold_out'])->default('ready');
            $table->unsignedInteger('price_per_stem')->nullable();
            $table->string('vase_life', 50)->nullable();
            $table->string('aroma_note', 100)->nullable();
            $table->text('description')->nullable();
            $table->string('image_path', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fresh_flowers');
    }
};
