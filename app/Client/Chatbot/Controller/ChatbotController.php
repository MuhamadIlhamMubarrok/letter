<?php

namespace App\Client\Chatbot\Controller;

use App\Http\Controllers\Controller;
use App\Services\Ai\GeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function __construct(
        protected GeminiService $geminiService
    ) {
    }

    public function ask(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
            'history' => ['nullable', 'array', 'max:15'],
            'history.*.role' => ['nullable', 'string', 'in:user,model,assistant'],
            'history.*.content' => ['nullable', 'string', 'max:2000'],
        ]);

        $reply = $this->geminiService->generateReply(
            $validated['message'],
            $validated['history'] ?? []
        );

        return response()->json([
            'reply' => $reply,
            'timestamp' => now()->format('H:i'),
            'is_live_ai' => $this->geminiService->isConfigured(),
            'model' => $this->geminiService->getModel(),
        ]);
    }
}
