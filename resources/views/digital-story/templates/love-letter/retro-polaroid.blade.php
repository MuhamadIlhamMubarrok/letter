@include('digital-story.templates.love-letter.online-love-letter', [
    'story' => $story,
    'template' => $template ?? \App\Domains\DigitalStory\Enums\StoryTemplateKey::RETRO_POLAROID,
    'isDemo' => $isDemo ?? false,
    'themePreset' => 'retro_polaroid',
])
