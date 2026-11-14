<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Controllers;

use App\Domains\DigitalStory\Actions\CreateStoryAction;
use App\Domains\DigitalStory\Actions\DeleteStoryAction;
use App\Domains\DigitalStory\Actions\ExtendStoryDurationAction;
use App\Domains\DigitalStory\Actions\SaveGuestListAction;
use App\Domains\DigitalStory\Actions\UpdateFulfillmentStatusAction;
use App\Domains\DigitalStory\Actions\UpdateStoryAction;
use App\Domains\DigitalStory\Enums\StoryDurationPlan;
use App\Domains\DigitalStory\Enums\StoryFulfillmentStatus;
use App\Domains\DigitalStory\Enums\StoryStatus;
use App\Domains\DigitalStory\Enums\StoryTemplateKey;
use App\Domains\DigitalStory\Enums\StoryTemplateTheme;
use App\Domains\DigitalStory\Enums\StoryType;
use App\Domains\DigitalStory\Models\DigitalStory;
use App\Domains\DigitalStory\Requests\ExtendStoryDurationRequest;
use App\Domains\DigitalStory\Requests\SaveGuestListRequest;
use App\Domains\DigitalStory\Requests\StoreDigitalStoryRequest;
use App\Domains\DigitalStory\Requests\UpdateDigitalStoryRequest;
use App\Domains\DigitalStory\Requests\UpdateFulfillmentStatusRequest;
use App\Domains\DigitalStory\Templates\StoryTemplateRegistry;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminStoryController extends Controller
{
    /**
     * Display a listing of digital stories with fulfillment pipeline filters.
     */
    public function index(Request $request, StoryTemplateRegistry $templateRegistry): View
    {
        $query = DigitalStory::with('media')->latest();

        if ($request->filled('fulfillment_status')) {
            $query->where('fulfillment_status', $request->input('fulfillment_status'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $storyType = $request->input('story_type', $request->input('type'));
        if ($storyType) {
            $query->where('story_type', $storyType);
        }

        if ($request->filled('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($search): void {
                $q->where('title', 'like', $search)
                    ->orWhere('sender_name', 'like', $search)
                    ->orWhere('recipient_name', 'like', $search)
                    ->orWhere('order_code', 'like', $search)
                    ->orWhere('customer_phone', 'like', $search)
                    ->orWhere('slug', 'like', $search);
            });
        }

        $stories = $query->paginate(12)->withQueryString();

        // Pipeline stage counts for CMS queue badges
        $pipelineCounts = [
            'all' => DigitalStory::count(),
            'pending_content' => DigitalStory::where('fulfillment_status', StoryFulfillmentStatus::PENDING_CONTENT)->count(),
            'drafting' => DigitalStory::where('fulfillment_status', StoryFulfillmentStatus::DRAFTING)->count(),
            'customer_review' => DigitalStory::where('fulfillment_status', StoryFulfillmentStatus::CUSTOMER_REVIEW)->count(),
            'ready_to_print' => DigitalStory::where('fulfillment_status', StoryFulfillmentStatus::READY_TO_PRINT)->count(),
            'completed' => DigitalStory::where('fulfillment_status', StoryFulfillmentStatus::COMPLETED)->count(),
        ];

        $stats = [
            'total_orders' => $pipelineCounts['all'],
            'ready_to_print' => $pipelineCounts['ready_to_print'],
            'pending_content' => $pipelineCounts['pending_content'],
            'completed' => $pipelineCounts['completed'],
            'love_letter_count' => DigitalStory::where('story_type', StoryType::LOVE_LETTER)->count(),
            'wedding_count' => DigitalStory::where('story_type', StoryType::WEDDING_INVITATION)->count(),
            'total_views' => DigitalStory::sum('views_count'),
            'active_stories' => DigitalStory::active()->count(),
        ];

        return view('digital-story.admin.index', [
            'stories' => $stories,
            'digitalStories' => $stories,
            'storyTypes' => StoryType::cases(),
            'storyStatuses' => StoryStatus::cases(),
            'durationPlans' => StoryDurationPlan::cases(),
            'fulfillmentStatuses' => StoryFulfillmentStatus::cases(),
            'pipelineCounts' => $pipelineCounts,
            'stats' => $stats,
            'templates' => $templateRegistry->all(),
        ]);
    }

    /**
     * Show dedicated template showcase catalog.
     */
    public function templates(StoryTemplateRegistry $templateRegistry): View
    {
        return view('digital-story.admin.templates', [
            'loveLetterTemplates' => $templateRegistry->forType(StoryType::LOVE_LETTER),
            'weddingTemplates' => $templateRegistry->forType(StoryType::WEDDING_INVITATION),
        ]);
    }

    /**
     * Show the form for creating a new digital story.
     */
    public function create(StoryTemplateRegistry $templateRegistry): View
    {
        return view('digital-story.admin.create', [
            'storyTypes' => StoryType::cases(),
            'durationPlans' => StoryDurationPlan::cases(),
            'themes' => StoryTemplateTheme::cases(),
            'fulfillmentStatuses' => StoryFulfillmentStatus::cases(),
            'loveLetterTemplates' => $templateRegistry->forType(StoryType::LOVE_LETTER),
            'weddingTemplates' => $templateRegistry->forType(StoryType::WEDDING_INVITATION),
        ]);
    }

    /**
     * Store a newly created digital story.
     */
    public function store(StoreDigitalStoryRequest $request, CreateStoryAction $action): RedirectResponse
    {
        $story = $action->execute(
            payload: $request->validated(),
            photos: $request->file('photos', []),
            audioFile: $request->file('audio_file'),
        );

        return redirect()
            ->route('admin.digital-stories.print', $story)
            ->with('success', "Surat & Undangan Digital [{$story->title}] berhasil dibuat! Siap cetak kartu buket.");
    }

    /**
     * Display the specified story (redirects to print view for staff efficiency).
     */
    public function show(DigitalStory $digitalStory): View
    {
        return $this->printCard($digitalStory);
    }

    /**
     * Show the form for editing the story.
     */
    public function edit(DigitalStory $digitalStory, StoryTemplateRegistry $templateRegistry): View
    {
        $digitalStory->load(['media', 'rsvps']);

        return view('digital-story.admin.edit', [
            'story' => $digitalStory,
            'storyTypes' => StoryType::cases(),
            'durationPlans' => StoryDurationPlan::cases(),
            'themes' => StoryTemplateTheme::cases(),
            'statuses' => StoryStatus::cases(),
            'fulfillmentStatuses' => StoryFulfillmentStatus::cases(),
            'loveLetterTemplates' => $templateRegistry->forType(StoryType::LOVE_LETTER),
            'weddingTemplates' => $templateRegistry->forType(StoryType::WEDDING_INVITATION),
        ]);
    }

    /**
     * Quick update for fulfillment workflow status in CMS.
     */
    public function updateFulfillmentStatus(
        UpdateFulfillmentStatusRequest $request,
        DigitalStory $digitalStory,
        UpdateFulfillmentStatusAction $action
    ): RedirectResponse {
        $status = StoryFulfillmentStatus::from($request->validated('fulfillment_status'));
        $action->execute($digitalStory, $status);

        return redirect()->back()->with('success', "Status pengerjaan diperbarui: {$status->label()}");
    }

    /**
     * Update the specified story in storage.
     */
    public function update(
        UpdateDigitalStoryRequest $request,
        DigitalStory $digitalStory,
        UpdateStoryAction $action
    ): RedirectResponse {
        $action->execute(
            story: $digitalStory,
            payload: $request->validated(),
            newPhotos: $request->file('new_photos', []),
            audioFile: $request->file('audio_file'),
        );

        return redirect()
            ->route('admin.digital-stories.index')
            ->with('success', "Perubahan cerita [{$digitalStory->title}] berhasil disimpan.");
    }

    /**
     * Remove the specified story from storage.
     */
    public function destroy(DigitalStory $digitalStory, DeleteStoryAction $action): RedirectResponse
    {
        $title = $digitalStory->title;
        $action->execute($digitalStory);

        return redirect()
            ->route('admin.digital-stories.index')
            ->with('success', "Pesanan cerita [{$title}] berhasil dihapus dari sistem.");
    }

    /**
     * Dedicated print layout for bouquet card (A6 & 9x5.5cm).
     */
    public function printCard(DigitalStory $digitalStory): View
    {
        $digitalStory->load('media');

        return view('digital-story.admin.print-qr-card', [
            'story' => $digitalStory,
        ]);
    }

    /**
     * Extend duration plan for a story.
     */
    public function extendDuration(
        ExtendStoryDurationRequest $request,
        DigitalStory $digitalStory,
        ExtendStoryDurationAction $action
    ): RedirectResponse {
        $plan = StoryDurationPlan::from($request->validated('duration_plan'));
        $action->execute($digitalStory, $plan);

        return redirect()
            ->back()
            ->with('success', "Masa aktif cerita [{$digitalStory->title}] berhasil diperpanjang!");
    }

    /**
     * Dedicated guest link generator and bulk WhatsApp invitation manager.
     */
    public function guestLinks(DigitalStory $digitalStory): View
    {
        $guestList = $digitalStory->getGuestList();
        $waTemplate = $digitalStory->metadata['wa_template'] ?? $digitalStory->getDefaultWaInvitationTemplate();

        return view('digital-story.admin.guests', [
            'story' => $digitalStory,
            'guestList' => $guestList,
            'waTemplate' => $waTemplate,
        ]);
    }

    /**
     * Save guest list and customized WhatsApp template.
     */
    public function saveGuests(
        SaveGuestListRequest $request,
        DigitalStory $digitalStory,
        SaveGuestListAction $action
    ): JsonResponse|RedirectResponse {
        $result = $action->execute(
            story: $digitalStory,
            rawGuestNames: (string) $request->validated('guest_names', ''),
            waTemplate: $request->validated('wa_template')
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'count' => $result['count'],
                'message' => "{$result['count']} nama tamu undangan berhasil disimpan ke sistem.",
                'guests' => $result['guests'],
            ]);
        }

        return redirect()
            ->back()
            ->with('success', "{$result['count']} nama tamu undangan berhasil disimpan ke sistem.");
    }
}
