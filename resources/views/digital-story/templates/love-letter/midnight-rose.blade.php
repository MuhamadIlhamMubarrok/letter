@include('digital-story.templates.love-letter.online-love-letter', [
    'story' => $story,
    'template' => $template ?? \App\Domains\DigitalStory\Enums\StoryTemplateKey::MIDNIGHT_ROSE,
    'isDemo' => $isDemo ?? false,
    'themePreset' => 'midnight_rose',
])
