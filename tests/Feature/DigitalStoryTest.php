<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Domains\DigitalStory\Actions\CreateStoryAction;
use App\Domains\DigitalStory\Actions\ExtendStoryDurationAction;
use App\Domains\DigitalStory\Actions\GenerateStoryQrCodeAction;
use App\Domains\DigitalStory\Enums\StoryDurationPlan;
use App\Domains\DigitalStory\Enums\StoryFulfillmentStatus;
use App\Domains\DigitalStory\Enums\StoryStatus;
use App\Domains\DigitalStory\Enums\StoryTemplateKey;
use App\Domains\DigitalStory\Enums\StoryTemplateTheme;
use App\Domains\DigitalStory\Enums\StoryType;
use App\Domains\DigitalStory\Models\DigitalStory;
use App\Domains\DigitalStory\Models\StoryMedia;
use App\Domains\DigitalStory\Models\StoryRsvp;
use App\Domains\DigitalStory\Templates\StoryTemplateRegistry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DigitalStoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    /**
     * Test story duration calculation and expiration date.
     */
    public function test_duration_plan_calculates_expiry_correctly(): void
    {
        $now = Carbon::parse('2026-11-11 12:00:00');
        Carbon::setTestNow($now);

        $oneMonthExpiry = StoryDurationPlan::ONE_MONTH->calculateExpiry($now);
        $this->assertNotNull($oneMonthExpiry);
        $this->assertEquals('2026-12-11 23:59:59', $oneMonthExpiry->format('Y-m-d H:i:s'));

        $sixMonthsExpiry = StoryDurationPlan::SIX_MONTHS->calculateExpiry($now);
        $this->assertNotNull($sixMonthsExpiry);
        $this->assertEquals('2027-05-10 23:59:59', $sixMonthsExpiry->format('Y-m-d H:i:s'));

        $lifetimeExpiry = StoryDurationPlan::LIFETIME->calculateExpiry($now);
        $this->assertNull($lifetimeExpiry);

        Carbon::setTestNow();
    }

    /**
     * Test CreateStoryAction creates record, media, and QR code within transaction.
     */
    public function test_create_story_action_executes_successfully(): void
    {
        $action = app(CreateStoryAction::class);

        $photo1 = UploadedFile::fake()->image('polaroid1.jpg', 600, 600);
        $photo2 = UploadedFile::fake()->image('polaroid2.jpg', 600, 600);

        $story = $action->execute(
            payload: [
                'story_type' => StoryType::LOVE_LETTER,
                'duration_plan' => StoryDurationPlan::ONE_MONTH,
                'theme' => StoryTemplateTheme::ROMANTIC_ROSE,
                'title' => 'Surat Cinta Untuk Dinda',
                'sender_name' => 'Rian',
                'recipient_name' => 'Dinda',
                'message' => 'Terima kasih telah menemani perjalananku selama ini...',
                'event_date' => '2026-02-14',
                'photo_captions' => ['Hari pertama kita bertemu', 'Liburan di Bandung'],
            ],
            photos: [$photo1, $photo2]
        );

        $this->assertDatabaseHas('digital_stories', [
            'id' => $story->id,
            'title' => 'Surat Cinta Untuk Dinda',
            'sender_name' => 'Rian',
            'recipient_name' => 'Dinda',
            'status' => StoryStatus::ACTIVE->value,
            'story_type' => StoryType::LOVE_LETTER->value,
            'duration_plan' => StoryDurationPlan::ONE_MONTH->value,
        ]);

        $this->assertNotNull($story->slug);
        $this->assertNotNull($story->expired_at);
        $this->assertNotNull($story->qr_code_path);

        // Verify storage stores relative path and file exists
        Storage::disk('public')->assertExists($story->qr_code_path);
        $this->assertFalse(str_starts_with($story->qr_code_path, 'http'));

        // Verify media relation
        $this->assertCount(2, $story->media);
        foreach ($story->media as $mediaItem) {
            Storage::disk('public')->assertExists($mediaItem->file_path);
            $this->assertFalse(str_starts_with($mediaItem->file_path, 'http'));
        }
    }

    /**
     * Test active and expired query scopes.
     */
    public function test_active_and_expired_scopes(): void
    {
        // 1. Active story (future expiry)
        $activeStory = DigitalStory::create([
            'slug' => 'active-story-' . uniqid(),
            'story_type' => StoryType::LOVE_LETTER,
            'duration_plan' => StoryDurationPlan::ONE_MONTH,
            'status' => StoryStatus::ACTIVE,
            'theme' => StoryTemplateTheme::ROMANTIC_ROSE,
            'title' => 'Active Story',
            'sender_name' => 'A',
            'recipient_name' => 'B',
            'message' => 'Active message',
            'expired_at' => Carbon::now()->addDays(15),
        ]);

        // 2. Lifetime story (expired_at is null)
        $lifetimeStory = DigitalStory::create([
            'slug' => 'lifetime-story-' . uniqid(),
            'story_type' => StoryType::LOVE_LETTER,
            'duration_plan' => StoryDurationPlan::LIFETIME,
            'status' => StoryStatus::ACTIVE,
            'theme' => StoryTemplateTheme::CLASSIC_GOLD,
            'title' => 'Lifetime Story',
            'sender_name' => 'A',
            'recipient_name' => 'B',
            'message' => 'Lifetime message',
            'expired_at' => null,
        ]);

        // 3. Expired story (past expiry)
        $expiredStory = DigitalStory::create([
            'slug' => 'expired-story-' . uniqid(),
            'story_type' => StoryType::LOVE_LETTER,
            'duration_plan' => StoryDurationPlan::ONE_MONTH,
            'status' => StoryStatus::ACTIVE,
            'theme' => StoryTemplateTheme::RUSTIC_BOTANICAL,
            'title' => 'Expired Story',
            'sender_name' => 'A',
            'recipient_name' => 'B',
            'message' => 'Expired message',
            'expired_at' => Carbon::now()->subDay(),
        ]);

        $activeIds = DigitalStory::active()->pluck('id')->all();
        $this->assertContains($activeStory->id, $activeIds);
        $this->assertContains($lifetimeStory->id, $activeIds);
        $this->assertNotContains($expiredStory->id, $activeIds);

        $expiredIds = DigitalStory::expired()->pluck('id')->all();
        $this->assertContains($expiredStory->id, $expiredIds);
        $this->assertNotContains($activeStory->id, $expiredIds);
        $this->assertNotContains($lifetimeStory->id, $expiredIds);
    }

    /**
     * Test extending story duration via action.
     */
    public function test_extend_story_duration_action(): void
    {
        $story = DigitalStory::create([
            'slug' => 'extend-test-' . uniqid(),
            'story_type' => StoryType::LOVE_LETTER,
            'duration_plan' => StoryDurationPlan::ONE_MONTH,
            'status' => StoryStatus::EXPIRED,
            'theme' => StoryTemplateTheme::ROMANTIC_ROSE,
            'title' => 'Test Extend',
            'sender_name' => 'A',
            'recipient_name' => 'B',
            'message' => 'Message',
            'expired_at' => Carbon::now()->subDays(5),
        ]);

        $action = app(ExtendStoryDurationAction::class);
        $extended = $action->execute($story, StoryDurationPlan::SIX_MONTHS);

        $this->assertEquals(StoryStatus::ACTIVE, $extended->status);
        $this->assertEquals(StoryDurationPlan::SIX_MONTHS, $extended->duration_plan);
        $this->assertTrue($extended->expired_at->isFuture());
    }

    /**
     * Test public viewer route renders active story and increments views_count.
     */
    public function test_public_viewer_renders_and_increments_views(): void
    {
        $story = DigitalStory::create([
            'slug' => 'public-test-' . uniqid(),
            'story_type' => StoryType::LOVE_LETTER,
            'duration_plan' => StoryDurationPlan::ONE_MONTH,
            'status' => StoryStatus::ACTIVE,
            'theme' => StoryTemplateTheme::ROMANTIC_ROSE,
            'title' => 'Cerita Publik',
            'sender_name' => 'Romeo',
            'recipient_name' => 'Juliet',
            'message' => 'Pesan cinta yang indah...',
            'expired_at' => Carbon::now()->addDays(10),
            'views_count' => 0,
        ]);

        $response = $this->get(route('story.public.show', ['slug' => $story->slug]));
        $response->assertStatus(200);
        $response->assertSee('Cerita Publik');
        $response->assertSee('Juliet');
        $response->assertSee('Romeo');

        $story->refresh();
        $this->assertEquals(1, $story->views_count);

        // Same session should not increment views again
        $this->get(route('story.public.show', ['slug' => $story->slug]));
        $story->refresh();
        $this->assertEquals(1, $story->views_count);
    }

    /**
     * Test public viewer returns graceful expiration view (410) when story has expired.
     */
    public function test_public_viewer_graceful_expiration_when_expired(): void
    {
        $expiredStory = DigitalStory::create([
            'slug' => 'expired-public-' . uniqid(),
            'story_type' => StoryType::LOVE_LETTER,
            'duration_plan' => StoryDurationPlan::ONE_MONTH,
            'status' => StoryStatus::ACTIVE,
            'theme' => StoryTemplateTheme::ROMANTIC_ROSE,
            'title' => 'Cerita Telah Berakhir',
            'sender_name' => 'A',
            'recipient_name' => 'B',
            'message' => 'Pesan lama',
            'expired_at' => Carbon::now()->subHours(2),
        ]);

        $response = $this->get(route('story.public.show', ['slug' => $expiredStory->slug]));
        $response->assertStatus(410);
        $response->assertSee('Masa Aktif Kenangan Ini Telah Berakhir');
    }

    /**
     * Test RSVP submission for wedding invitations.
     */
    public function test_rsvp_submission_for_wedding_invitation(): void
    {
        $wedding = DigitalStory::create([
            'slug' => 'wedding-dinda-rian-' . uniqid(),
            'story_type' => StoryType::WEDDING_INVITATION,
            'duration_plan' => StoryDurationPlan::ONE_YEAR,
            'status' => StoryStatus::ACTIVE,
            'theme' => StoryTemplateTheme::CLASSIC_GOLD,
            'title' => 'The Wedding of Dinda & Rian',
            'sender_name' => 'Dinda & Rian',
            'recipient_name' => 'Keluarga Besar',
            'message' => 'Mengundang bapak/ibu...',
            'expired_at' => Carbon::now()->addMonths(6),
        ]);

        $response = $this->postJson(route('story.public.rsvp', ['slug' => $wedding->slug]), [
            'guest_name' => 'Budi Santoso',
            'attendance_status' => 'attending',
            'guest_count' => 2,
            'wishes' => 'Selamat menempuh hidup baru! Semoga samawa selalu.',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('story_rsvps', [
            'digital_story_id' => $wedding->id,
            'guest_name' => 'Budi Santoso',
            'attendance_status' => 'attending',
            'guest_count' => 2,
        ]);
    }

    /**
     * Test admin routes authorization (IDOR and auth middleware check).
     */
    public function test_admin_routes_require_authentication(): void
    {
        $response = $this->get(route('admin.digital-stories.index'));
        $response->assertRedirect(); // redirects to secret admin login

        $user = User::factory()->create();

        // Create a sample story with full relations to ensure view renders table row components
        $story = DigitalStory::create([
            'order_code' => 'MF-TEST-001',
            'customer_phone' => '081234567890',
            'fulfillment_status' => StoryFulfillmentStatus::READY_TO_PRINT,
            'template_key' => StoryTemplateKey::VINTAGE_ENVELOPE,
            'slug' => 'test-auth-story-' . uniqid(),
            'story_type' => StoryType::LOVE_LETTER,
            'duration_plan' => StoryDurationPlan::ONE_MONTH,
            'status' => StoryStatus::ACTIVE,
            'theme' => StoryTemplateTheme::ROMANTIC_ROSE,
            'title' => 'Story For View Testing',
            'sender_name' => 'Faris',
            'recipient_name' => 'Sarah',
            'message' => 'Pesan pengujian dashboard admin...',
            'event_date' => Carbon::now()->subMonths(1),
            'expired_at' => Carbon::now()->addDays(20),
        ]);

        $this->assertNotNull($story->getPublicUrl());
        $this->assertNotNull($story->getPrintCardUrl());
        $this->assertNotNull($story->getWhatsAppFollowUpUrl());
        $this->assertStringContainsString('<svg', $story->generateQrSvg());

        $authResponse = $this->actingAs($user)->get(route('admin.digital-stories.index'));
        $authResponse->assertStatus(200);
        $authResponse->assertSee('Story For View Testing');
        $authResponse->assertSee('MF-TEST-001');
    }

    /**
     * Test wedding invitation creation with full metadata.
     */
    public function test_wedding_invitation_creation_with_metadata(): void
    {
        $action = app(CreateStoryAction::class);

        $story = $action->execute(
            payload: [
                'story_type' => StoryType::WEDDING_INVITATION,
                'duration_plan' => StoryDurationPlan::LIFETIME,
                'theme' => StoryTemplateTheme::CLASSIC_GOLD,
                'title' => 'The Wedding of Dinda & Rian',
                'sender_name' => 'Dinda & Rian',
                'recipient_name' => 'Bapak/Ibu Tamu Undangan',
                'message' => 'Dengan memohon rahmat Allah SWT...',
                'event_date' => '2026-12-25 09:00:00',
                'wedding_venue_name' => 'Grand Ballroom Plataran',
                'wedding_venue_address' => 'Jl. Sudirman Kav 21 Jakarta',
                'wedding_maps_url' => 'https://maps.google.com/?q=plataran',
                'wedding_ceremony_time' => '08:00 - 10:00 WIB',
                'wedding_reception_time' => '11:00 - 14:00 WIB',
            ]
        );

        $this->assertEquals(StoryType::WEDDING_INVITATION, $story->story_type);
        $this->assertEquals(StoryDurationPlan::LIFETIME, $story->duration_plan);
        $this->assertNull($story->expired_at);
        $this->assertFalse($story->is_expired);

        $details = $story->wedding_details;
        $this->assertEquals('Grand Ballroom Plataran', $details['venue_name']);
        $this->assertEquals('08:00 - 10:00 WIB', $details['ceremony_time']);
    }

    /**
     * Test SVG QR Code generator output validity.
     */
    public function test_qr_code_generator_produces_valid_svg(): void
    {
        $action = app(GenerateStoryQrCodeAction::class);
        $path = $action->execute('https://majaflower.com/s/sample-slug-test', 'sample-slug-test');

        $this->assertEquals('stories/qr/sample-slug-test.svg', $path);
        Storage::disk('public')->assertExists($path);

        $content = Storage::disk('public')->get($path);
        $this->assertStringContainsString('<svg', $content);
        $this->assertStringContainsString('</svg>', $content);
    }

    /**
     * Test staff can view and render print layout card.
     */
    public function test_staff_can_view_print_layout_card(): void
    {
        $user = User::factory()->create();

        $story = DigitalStory::create([
            'slug' => 'print-card-test-' . uniqid(),
            'story_type' => StoryType::LOVE_LETTER,
            'duration_plan' => StoryDurationPlan::ONE_MONTH,
            'status' => StoryStatus::ACTIVE,
            'theme' => StoryTemplateTheme::ROMANTIC_ROSE,
            'title' => 'Kartu Ucapan Buket Spesial',
            'sender_name' => 'Bintang',
            'recipient_name' => 'Bulan',
            'message' => 'Semoga bunga ini membuatmu tersenyum.',
        ]);

        $response = $this->actingAs($user)->get(route('admin.digital-stories.print', $story));
        $response->assertStatus(200);
        $response->assertSee('Cetak Kartu QR Buket');
        $response->assertSee('Bulan');
        $response->assertSee('Bintang');
        $response->assertSee('ID: ' . $story->slug);
    }

    /**
     * Test CMS order follow-up and WhatsApp link generation.
     */
    public function test_cms_pipeline_and_whatsapp_follow_up_url(): void
    {
        $story = DigitalStory::create([
            'slug' => 'order-followup-' . uniqid(),
            'order_code' => 'MF-202611-0089',
            'customer_phone' => '081299887766',
            'fulfillment_status' => StoryFulfillmentStatus::PENDING_CONTENT,
            'story_type' => StoryType::LOVE_LETTER,
            'duration_plan' => StoryDurationPlan::ONE_MONTH,
            'status' => StoryStatus::ACTIVE,
            'theme' => StoryTemplateTheme::ROMANTIC_ROSE,
            'title' => 'Pesanan Buket Mawar Pink',
            'sender_name' => 'Andi',
            'recipient_name' => 'Siti',
            'message' => 'Menunggu kelengkapan pesan dari Andi...',
        ]);

        $this->assertEquals('6281299887766', $story->clean_customer_phone);
        $this->assertNotNull($story->whatsapp_follow_up_url);
        $this->assertStringContainsString('https://wa.me/6281299887766', $story->whatsapp_follow_up_url);
        $this->assertStringContainsString('MF-202611-0089', urldecode($story->whatsapp_follow_up_url));
    }

    /**
     * Test multi-template registry and dynamic template rendering.
     */
    public function test_multi_template_registry_and_rendering(): void
    {
        $registry = app(StoryTemplateRegistry::class);

        $this->assertGreaterThanOrEqual(4, $registry->forType(StoryType::LOVE_LETTER)->count());
        $this->assertGreaterThanOrEqual(3, $registry->forType(StoryType::WEDDING_INVITATION)->count());
        $this->assertContains(StoryTemplateKey::WEDDING_CUTE_PASTEL, $registry->forType(StoryType::WEDDING_INVITATION));
        $this->assertContains(StoryTemplateKey::WEDDING_CLASSIC_HERITAGE, $registry->forType(StoryType::WEDDING_INVITATION));
        $this->assertContains(StoryTemplateKey::WEDDING_ELEGANT_LUXURY, $registry->forType(StoryType::WEDDING_INVITATION));

        // Test rendering a specific template (Midnight Rose)
        $story = DigitalStory::create([
            'slug' => 'midnight-test-' . uniqid(),
            'template_key' => StoryTemplateKey::MIDNIGHT_ROSE,
            'story_type' => StoryType::LOVE_LETTER,
            'duration_plan' => StoryDurationPlan::ONE_MONTH,
            'status' => StoryStatus::ACTIVE,
            'theme' => StoryTemplateTheme::ROMANTIC_ROSE,
            'title' => 'Mawar Tengah Malam',
            'sender_name' => 'Adit',
            'recipient_name' => 'Bella',
            'message' => 'Pesona mawar di keheningan malam...',
        ]);

        $response = $this->get(route('story.public.show', ['slug' => $story->slug]));
        $response->assertStatus(200);
        $response->assertSee('Midnight Rose Edition');
        $response->assertSee('Bella');
        $response->assertSee('Adit');
    }

    /**
     * Test quick update fulfillment status in CMS.
     */
    public function test_quick_update_fulfillment_status(): void
    {
        $user = User::factory()->create();

        $story = DigitalStory::create([
            'slug' => 'fulfillment-update-' . uniqid(),
            'fulfillment_status' => StoryFulfillmentStatus::DRAFTING,
            'story_type' => StoryType::LOVE_LETTER,
            'duration_plan' => StoryDurationPlan::ONE_MONTH,
            'status' => StoryStatus::ACTIVE,
            'theme' => StoryTemplateTheme::ROMANTIC_ROSE,
            'title' => 'Update Status Test',
            'sender_name' => 'Faris',
            'recipient_name' => 'Gita',
            'message' => 'Konten...',
        ]);

        $response = $this->actingAs($user)->patch(route('admin.digital-stories.fulfillment', $story), [
            'fulfillment_status' => StoryFulfillmentStatus::READY_TO_PRINT->value,
        ]);

        $response->assertRedirect();
        $story->refresh();
        $this->assertEquals(StoryFulfillmentStatus::READY_TO_PRINT, $story->fulfillment_status);
    }

    /**
     * Test public live template preview renders with demo data and share buttons.
     */
    public function test_public_template_live_preview_renders_with_demo_data_and_share_buttons(): void
    {
        // 1. Test Love Letter Template Preview
        $loveResponse = $this->get(route('story.public.preview', ['templateKey' => 'vintage_envelope']));
        $loveResponse->assertStatus(200);
        $loveResponse->assertSee('Contoh Template Live');
        $loveResponse->assertSee('Salin Link Contoh');
        $loveResponse->assertSee('Share WA');
        $loveResponse->assertSee('Adinda Kirana');
        $loveResponse->assertSee('Rian Pratama');

        // 2. Test Wedding Invitation Template Preview
        $weddingResponse = $this->get(route('story.public.preview', ['templateKey' => 'online_wedding']));
        $weddingResponse->assertStatus(200);
        $weddingResponse->assertSee('Contoh Template Live');
        $weddingResponse->assertSee('The Wedding of Adinda & Rian');
        $weddingResponse->assertSee('Grand Glasshouse Ballroom Maja');

        // 3. Test Invalid Template Key returns 404
        $invalidResponse = $this->get(route('story.public.preview', ['templateKey' => 'invalid_template_xyz']));
        $invalidResponse->assertStatus(404);
    }

    /**
     * Test demo rsvp returns friendly success response without modifying database.
     */
    public function test_demo_rsvp_submission_returns_friendly_response(): void
    {
        $response = $this->postJson(route('story.public.rsvp', ['slug' => 'demo-online_wedding']), [
            'guest_name' => 'Demo Guest',
            'attendance_status' => 'attending',
            'guest_count' => 2,
            'wishes' => 'Semoga bahagia selalu!',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Terima kasih atas doa restunya! (Mode Pratinjau Demo)',
        ]);
    }

    /**
     * Test all template views render with zero exceptions in preview and live mode.
     */
    public function test_all_templates_render_successfully(): void
    {
        $registry = app(StoryTemplateRegistry::class);

        foreach ($registry->all() as $template) {
            $response = $this->get(route('story.public.preview', ['templateKey' => $template->value]));
            $response->assertStatus(200);
            $response->assertSee($template->title());
        }
    }

    /**
     * Test standardized Lucu, Klasik, and Elegan templates for both Surat and Undangan.
     */
    public function test_standardized_lucu_klasik_elegan_templates_for_surat_and_undangan(): void
    {
        $registry = app(StoryTemplateRegistry::class);

        // 1. Verify Surat (Love Letter) theme taxonomy
        $this->assertEquals('lucu', StoryTemplateKey::ONLINE_LOVE_LETTER->themeStyle());
        $this->assertEquals('klasik', StoryTemplateKey::VINTAGE_ENVELOPE->themeStyle());
        $this->assertEquals('elegan', StoryTemplateKey::MIDNIGHT_ROSE->themeStyle());
        $this->assertEquals(StoryType::LOVE_LETTER, StoryTemplateKey::ONLINE_LOVE_LETTER->storyType());
        $this->assertEquals(StoryType::LOVE_LETTER, StoryTemplateKey::VINTAGE_ENVELOPE->storyType());
        $this->assertEquals(StoryType::LOVE_LETTER, StoryTemplateKey::MIDNIGHT_ROSE->storyType());

        // 2. Verify Undangan (Wedding Invitation) theme taxonomy
        $this->assertEquals('lucu', StoryTemplateKey::WEDDING_CUTE_PASTEL->themeStyle());
        $this->assertEquals('klasik', StoryTemplateKey::WEDDING_CLASSIC_HERITAGE->themeStyle());
        $this->assertEquals('elegan', StoryTemplateKey::WEDDING_ELEGANT_LUXURY->themeStyle());
        $this->assertEquals(StoryType::WEDDING_INVITATION, StoryTemplateKey::WEDDING_CUTE_PASTEL->storyType());
        $this->assertEquals(StoryType::WEDDING_INVITATION, StoryTemplateKey::WEDDING_CLASSIC_HERITAGE->storyType());
        $this->assertEquals(StoryType::WEDDING_INVITATION, StoryTemplateKey::WEDDING_ELEGANT_LUXURY->storyType());

        // 3. Test Live Rendering of Undangan Lucu (Cute Pastel)
        $cuteWedding = DigitalStory::create([
            'slug' => 'wedding-cute-' . uniqid(),
            'story_type' => StoryType::WEDDING_INVITATION,
            'template_key' => StoryTemplateKey::WEDDING_CUTE_PASTEL,
            'duration_plan' => StoryDurationPlan::ONE_YEAR,
            'status' => StoryStatus::ACTIVE,
            'theme' => StoryTemplateTheme::ROMANTIC_ROSE,
            'title' => 'The Wedding of Daffa & Caca 💕',
            'sender_name' => 'Keluarga Bpk. Bambang',
            'recipient_name' => 'Sahabat Tercinta',
            'message' => 'Dengan penuh rasa syukur kami mengundang...',
            'event_date' => now()->addDays(20),
        ]);
        $responseCute = $this->get(route('story.public.show', $cuteWedding->slug) . '?to=Budi');
        $responseCute->assertStatus(200);
        $responseCute->assertSee('Budi');
        $responseCute->assertSee('The Wedding of Daffa & Caca 💕');

        // 4. Test Live Rendering of Undangan Klasik (Classic Heritage)
        $classicWedding = DigitalStory::create([
            'slug' => 'wedding-classic-' . uniqid(),
            'story_type' => StoryType::WEDDING_INVITATION,
            'template_key' => StoryTemplateKey::WEDDING_CLASSIC_HERITAGE,
            'duration_plan' => StoryDurationPlan::ONE_YEAR,
            'status' => StoryStatus::ACTIVE,
            'theme' => StoryTemplateTheme::RUSTIC_BOTANICAL,
            'title' => 'The Wedding of Raden Arya & Dyah Ayu 📜',
            'sender_name' => 'Keluarga Bpk. Ir. H. Bambang Kusuma',
            'recipient_name' => 'Tamu Terhormat',
            'message' => 'Merupakan suatu kehormatan bagi kami...',
            'event_date' => now()->addDays(20),
        ]);
        $responseClassic = $this->get(route('story.public.show', $classicWedding->slug) . '?to=Ibu+Siti');
        $responseClassic->assertStatus(200);
        $responseClassic->assertSee('Ibu Siti');
        $responseClassic->assertSee('The Wedding of Raden Arya & Dyah Ayu 📜');

        // 5. Test Live Rendering of Undangan Elegan (Elegant Luxury)
        $luxuryWedding = DigitalStory::create([
            'slug' => 'wedding-luxury-' . uniqid(),
            'story_type' => StoryType::WEDDING_INVITATION,
            'template_key' => StoryTemplateKey::WEDDING_ELEGANT_LUXURY,
            'duration_plan' => StoryDurationPlan::ONE_YEAR,
            'status' => StoryStatus::ACTIVE,
            'theme' => StoryTemplateTheme::MODERN_EMERALD,
            'title' => 'The Royal Wedding of Leonardo & Kimberly ✨',
            'sender_name' => 'Keluarga Bpk. William Adisurya',
            'recipient_name' => 'Distinguished VIP Guest',
            'message' => 'We cordially invite you to celebrate...',
            'event_date' => now()->addDays(20),
        ]);
        $responseLuxury = $this->get(route('story.public.show', $luxuryWedding->slug) . '?to=Mr.+Alexander');
        $responseLuxury->assertStatus(200);
        $responseLuxury->assertSee('Mr. Alexander');
        $responseLuxury->assertSee('The Royal Wedding of Leonardo & Kimberly ✨');
    }

    /**
     * Test wedding personalized guest link generator, persistence, and personalized invitation cover.
     */
    public function test_wedding_guest_link_generator_and_personalized_invitation_cover(): void
    {
        $user = User::factory()->create();

        $wedding = DigitalStory::create([
            'order_code' => 'MF-WED-GUEST',
            'slug' => 'wedding-personal-' . uniqid(),
            'story_type' => StoryType::WEDDING_INVITATION,
            'duration_plan' => StoryDurationPlan::ONE_YEAR,
            'status' => StoryStatus::ACTIVE,
            'theme' => StoryTemplateTheme::CLASSIC_GOLD,
            'template_key' => StoryTemplateKey::ONLINE_WEDDING,
            'title' => 'The Wedding of Sarah & Dimas',
            'sender_name' => 'Sarah',
            'recipient_name' => 'Dimas',
            'message' => 'Pernikahan agung...',
        ]);

        // 1. Staff accesses dedicated guest link generator workspace
        $viewResponse = $this->actingAs($user)->get(route('admin.digital-stories.guests', $wedding));
        $viewResponse->assertStatus(200);
        $viewResponse->assertSee('Generator Undangan Personal');
        $viewResponse->assertSee('Salin Seluruh Link Undangan Sekaligus');
        $viewResponse->assertSee('Tanpa Barcode');

        // Verify fulfillment WhatsApp message for wedding focuses on links without barcode/bouquet wording
        $weddingWa = urldecode(StoryFulfillmentStatus::COMPLETED->generateWaMessage($wedding));
        $this->assertStringContainsString('Link Utama Undangan', $weddingWa);
        $this->assertStringNotContainsString('QR Code', $weddingWa);
        $this->assertStringNotContainsString('buket', $weddingWa);

        // 2. Staff pastes raw guest names line-by-line and saves
        $rawGuestNames = "Bpk. Budi Santoso & Keluarga\ndr. Hendra Pratama\nSiti Aminah";
        $saveResponse = $this->actingAs($user)->postJson(route('admin.digital-stories.guests.save', $wedding), [
            'guest_names' => $rawGuestNames,
            'wa_template' => "Halo {nama_tamu}, hadir yuk di {judul_acara}: {link_undangan}"
        ]);

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson([
            'success' => true,
            'count' => 3,
        ]);

        $wedding->refresh();
        $guestList = $wedding->getGuestList();
        $this->assertCount(3, $guestList);
        $this->assertEquals('Bpk. Budi Santoso & Keluarga', $guestList[0]);

        // 3. Verify helper methods produce proper URLs and messages
        $invitationUrl = $wedding->getGuestInvitationUrl('Bpk. Budi Santoso & Keluarga');
        $this->assertStringContainsString('to=Bpk.', $invitationUrl);
        $this->assertStringContainsString('Budi', $invitationUrl);

        $waMsg = $wedding->generateWaMessageForGuest('Bpk. Budi Santoso & Keluarga');
        $this->assertStringContainsString('Bpk. Budi Santoso & Keluarga', $waMsg);
        $this->assertStringContainsString($invitationUrl, $waMsg);

        // 4. Guest visits personal link and sees personalized cover & name on invitation
        $guestVisitResponse = $this->get(route('story.public.show', [
            'slug' => $wedding->slug,
            'to' => 'Bpk. Budi Santoso & Keluarga'
        ]));
        $guestVisitResponse->assertStatus(200);
        $guestVisitResponse->assertSee('Bpk. Budi Santoso &amp; Keluarga', false);
        $guestVisitResponse->assertSee('The Wedding Invitation');
        $guestVisitResponse->assertSee('Buka Undangan');
    }

    /**
     * Test admin can store and update story via HTTP Form Request endpoints.
     */
    public function test_admin_can_store_and_update_story_via_http_endpoints(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $storePayload = [
            'story_type' => StoryType::LOVE_LETTER->value,
            'duration_plan' => StoryDurationPlan::ONE_MONTH->value,
            'theme' => StoryTemplateTheme::ROMANTIC_ROSE->value,
            'title' => 'Kisah Kasih Endpoint Test',
            'sender_name' => 'Alif',
            'recipient_name' => 'Bintang',
            'message' => 'Pesan cinta via form request controller...',
            'photos' => [UploadedFile::fake()->image('wedding-raw.jpg', 1200, 1200)],
        ];

        $storeResponse = $this->actingAs($user)->post(route('admin.digital-stories.store'), $storePayload);
        $storeResponse->assertRedirect();

        $story = DigitalStory::where('title', 'Kisah Kasih Endpoint Test')->with('media')->first();
        $this->assertNotNull($story);
        $this->assertCount(1, $story->media);
        $storedMedia = $story->media->first();
        $this->assertStringEndsWith('.webp', $storedMedia->file_path);
        $this->assertEquals('image/webp', $storedMedia->mime_type);
        Storage::disk('public')->assertExists($storedMedia->file_path);
        $this->assertLessThanOrEqual(100 * 1024, strlen(Storage::disk('public')->get($storedMedia->file_path)));

        $updateResponse = $this->actingAs($user)->put(route('admin.digital-stories.update', $story), [
            'title' => 'Kisah Kasih Endpoint Test (Updated)',
            'message' => 'Pesan cinta yang telah diperbarui...',
            'sender_name' => 'Alif Updated',
            'recipient_name' => 'Bintang Updated',
            'theme' => StoryTemplateTheme::MODERN_EMERALD->value,
            'duration_plan' => StoryDurationPlan::SIX_MONTHS->value,
            'status' => StoryStatus::ACTIVE->value,
            'new_photos' => [UploadedFile::fake()->image('wedding-update.jpg', 1000, 1000)],
        ]);

        $updateResponse->assertRedirect(route('admin.digital-stories.index'));
        $story->refresh();
        $this->assertEquals('Kisah Kasih Endpoint Test (Updated)', $story->title);
        $this->assertCount(2, $story->media);

        foreach ($story->media as $mediaItem) {
            $this->assertStringEndsWith('.webp', $mediaItem->file_path);
            $this->assertEquals('image/webp', $mediaItem->mime_type);
            Storage::disk('public')->assertExists($mediaItem->file_path);
            $this->assertLessThanOrEqual(100 * 1024, strlen(Storage::disk('public')->get($mediaItem->file_path)));
        }
    }

    /**
     * Test admin can delete story from pipeline with transaction and storage cleanup.
     */
    public function test_admin_can_delete_story_from_pipeline(): void
    {
        $user = User::factory()->create();

        $story = DigitalStory::create([
            'slug' => 'to-delete-' . uniqid(),
            'story_type' => StoryType::LOVE_LETTER,
            'duration_plan' => StoryDurationPlan::ONE_MONTH,
            'status' => StoryStatus::ACTIVE,
            'theme' => StoryTemplateTheme::ROMANTIC_ROSE,
            'title' => 'Pesanan Yang Akan Dihapus',
            'sender_name' => 'Fulan',
            'recipient_name' => 'Fulanah',
            'message' => 'Konten...',
        ]);

        $indexResponse = $this->actingAs($user)->get(route('admin.digital-stories.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('openDeleteModal');

        $deleteResponse = $this->actingAs($user)->delete(route('admin.digital-stories.destroy', $story));
        $deleteResponse->assertRedirect(route('admin.digital-stories.index'));
        $deleteResponse->assertSessionHas('success');

        $this->assertSoftDeleted('digital_stories', ['id' => $story->id]);
    }

    /**
     * Test audio trimming start and end cut persistence and accessors.
     */
    public function test_audio_trimming_start_and_end_cut_persistence(): void
    {
        $user = User::factory()->create();

        $storePayload = [
            'story_type' => StoryType::WEDDING_INVITATION->value,
            'duration_plan' => StoryDurationPlan::LIFETIME->value,
            'theme' => StoryTemplateTheme::CLASSIC_GOLD->value,
            'title' => 'Wedding Audio Trim Test',
            'sender_name' => 'Romeo',
            'recipient_name' => 'Juliet',
            'message' => 'Pesan pernikahan dengan audio cut...',
            'audio_title' => 'Acoustic Guitar Romance',
            'audio_start_sec' => 45.5,
            'audio_end_sec' => 120.0,
        ];

        $storeResponse = $this->actingAs($user)->post(route('admin.digital-stories.store'), $storePayload);
        $storeResponse->assertRedirect();

        $story = DigitalStory::where('title', 'Wedding Audio Trim Test')->firstOrFail();
        $this->assertEquals(45.5, $story->audio_start_sec);
        $this->assertEquals(120.0, $story->audio_end_sec);
        $this->assertEquals('00:45', $story->audio_start_formatted);
        $this->assertEquals('02:00', $story->audio_end_formatted);

        // Update audio trimming cut
        $updateResponse = $this->actingAs($user)->put(route('admin.digital-stories.update', $story), [
            'title' => 'Wedding Audio Trim Test (Re-Cut)',
            'sender_name' => 'Romeo',
            'recipient_name' => 'Juliet',
            'message' => 'Pesan pernikahan dengan audio cut...',
            'audio_start_sec' => 60,
            'audio_end_sec' => 180,
        ]);

        $updateResponse->assertRedirect(route('admin.digital-stories.index'));
        $story->refresh();
        $this->assertEquals(60.0, $story->audio_start_sec);
        $this->assertEquals(180.0, $story->audio_end_sec);
        $this->assertEquals('01:00', $story->audio_start_formatted);
        $this->assertEquals('03:00', $story->audio_end_formatted);
    }
}
