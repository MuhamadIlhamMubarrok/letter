<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Controllers;

use App\Domains\DigitalStory\Actions\SubmitStoryRsvpAction;
use App\Domains\DigitalStory\Enums\StoryTemplateKey;
use App\Domains\DigitalStory\Enums\StoryType;
use App\Domains\DigitalStory\Models\DigitalStory;
use App\Domains\DigitalStory\Requests\SubmitStoryRsvpRequest;
use App\Domains\DigitalStory\Templates\StoryTemplateRegistry;
use App\Http\Controllers\Controller;
use DomainException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PublicStoryController extends Controller
{
    /**
     * Display public viewer for scanned QR Code or direct link with dynamic template engine.
     */
    public function show(Request $request, string $slug, StoryTemplateRegistry $templateRegistry): View|Response
    {
        $story = DigitalStory::where('slug', $slug)
            ->with(['media', 'rsvps' => fn ($q) => $q->latest()->limit(50)])
            ->firstOrFail();

        // Graceful expiration view if time has expired
        if ($story->is_expired) {
            return response()
                ->view('digital-story.expired', [
                    'story' => $story,
                ], 410);
        }

        // Session-throttled view counter to avoid inflation
        $sessionKey = "viewed_story_{$story->id}";
        if (! $request->session()->has($sessionKey)) {
            $story->increment('views_count');
            $request->session()->put($sessionKey, true);
        }

        // Allow previewing different template in CMS preview mode
        $activeTemplate = $story->template_key;
        if ($request->filled('preview_template')) {
            $previewKey = StoryTemplateKey::tryFromWithLegacy((string) $request->input('preview_template'));
            if ($previewKey) {
                $activeTemplate = $previewKey;
            }
        }

        if (! $activeTemplate) {
            $activeTemplate = $templateRegistry->defaultForType($story->story_type);
        }

        $viewPath = view()->exists($activeTemplate->viewPath())
            ? $activeTemplate->viewPath()
            : 'digital-story.public-viewer';

        return view($viewPath, [
            'story' => $story,
            'template' => $activeTemplate,
        ]);
    }

    /**
     * Public interactive preview for a template with realistic demo data.
     * Publicly shareable with clients before ordering.
     */
    public function previewTemplate(string $templateKey, StoryTemplateRegistry $templateRegistry): View
    {
        $template = StoryTemplateKey::tryFromWithLegacy($templateKey);
        if (! $template) {
            abort(404, 'Template tidak ditemukan.');
        }

        $story = $templateRegistry->makeDemoStory($template);

        $viewPath = view()->exists($template->viewPath())
            ? $template->viewPath()
            : 'digital-story.public-viewer';

        return view($viewPath, [
            'story' => $story,
            'template' => $template,
            'isDemo' => true,
        ]);
    }

    /**
     * Store RSVP and warm wishes for wedding invitation.
     */
    public function rsvp(
        SubmitStoryRsvpRequest $request,
        string $slug,
        SubmitStoryRsvpAction $action
    ): JsonResponse|RedirectResponse {
        if (str_starts_with($slug, 'demo-')) {
            return response()->json([
                'success' => true,
                'message' => 'Terima kasih atas doa restunya! (Mode Pratinjau Demo)',
            ]);
        }

        $story = DigitalStory::where('slug', $slug)->firstOrFail();

        try {
            $rsvp = $action->execute(
                story: $story,
                payload: $request->validated(),
                ipAddress: $request->ip()
            );
        } catch (DomainException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Terima kasih atas doa restu dan konfirmasi kehadiran Anda! ❤️',
                'rsvp' => [
                    'guest_name' => $rsvp->guest_name,
                    'attendance_label' => $rsvp->attendance_label,
                    'guest_count' => $rsvp->guest_count,
                    'wishes' => $rsvp->wishes,
                    'created_at' => $rsvp->created_at->diffForHumans(),
                ],
            ]);
        }

        return redirect()->back()->with('success', 'Doa restu Anda telah berhasil dikirimkan!');
    }
}
