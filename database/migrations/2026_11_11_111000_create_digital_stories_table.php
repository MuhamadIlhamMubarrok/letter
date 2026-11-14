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
        Schema::create('digital_stories', function (Blueprint $table): void {
            $table->id();
            $table->string('order_code', 60)->nullable()->index(); // Relasi pesanan buket (misal: MF-202611-001)
            $table->string('customer_phone', 30)->nullable();     // Nomor WhatsApp pemesan untuk follow-up CMS
            $table->string('fulfillment_status', 30)->default('drafting')->index(); // pending_content, drafting, customer_review, ready_to_print, completed
            $table->string('template_key', 50)->default('vintage_envelope')->index(); // template identifier
            $table->string('slug')->unique()->index();
            $table->string('story_type', 30)->index(); // love_letter, wedding_invitation
            $table->string('duration_plan', 30); // 1_month, 6_months, 1_year, lifetime
            $table->string('status', 30)->default('active')->index(); // draft, active, expired, archived
            $table->string('theme', 50)->default('romantic_rose'); // romantic_rose, rustic_botanical, modern_emerald, classic_gold
            $table->string('title', 150);
            $table->string('sender_name', 100);
            $table->string('recipient_name', 100);
            $table->longText('message');
            $table->dateTime('event_date')->nullable();
            $table->string('audio_path')->nullable();
            $table->string('audio_title', 150)->nullable();
            $table->string('qr_code_path')->nullable();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->dateTime('expired_at')->nullable()->index();
            $table->text('notes')->nullable(); // Catatan internal tim florist
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_stories');
    }
};
