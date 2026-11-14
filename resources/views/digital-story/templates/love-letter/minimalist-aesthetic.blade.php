@include('digital-story.templates.love-letter.online-love-letter', [
    'story' => $story,
    'template' => $template ?? \App\Domains\DigitalStory\Enums\StoryTemplateKey::MINIMALIST_AESTHETIC,
    'isDemo' => $isDemo ?? false,
    'themePreset' => 'minimalist_aesthetic',
])
