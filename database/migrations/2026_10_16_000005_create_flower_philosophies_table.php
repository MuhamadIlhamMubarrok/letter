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
        Schema::create('flower_philosophies', function (Blueprint $table) {
            $table->id();
            $table->string('flower_name');
            $table->string('scientific_name')->nullable();
            $table->string('emoji_or_icon')->default('🌸');
            $table->string('meaning');
            $table->text('description');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flower_philosophies');
    }
};
