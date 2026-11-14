<?php

declare(strict_types=1);

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
        Schema::create('story_rsvps', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('digital_story_id')->constrained('digital_stories')->cascadeOnDelete();
            $table->string('guest_name', 100);
            $table->string('attendance_status', 30)->default('attending'); // attending, not_attending, tentative
            $table->unsignedTinyInteger('guest_count')->default(1);
            $table->text('wishes')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('story_rsvps');
    }
};
