@include('digital-story.templates.love-letter.online-love-letter', [
    'story' => $story,
    'template' => $template ?? \App\Domains\DigitalStory\Enums\StoryTemplateKey::VINTAGE_ENVELOPE,
    'isDemo' => $isDemo ?? false,
    'themePreset' => 'vintage_envelope',
])
