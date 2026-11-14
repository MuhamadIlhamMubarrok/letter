@php
    $resolvedTemplate = $template ?? ($story->template_key ?? app(\App\Domains\DigitalStory\Templates\StoryTemplateRegistry::class)->defaultForType($story->story_type));
    $view = view()->exists($resolvedTemplate->viewPath())
        ? $resolvedTemplate->viewPath()
        : ($story->story_type === \App\Domains\DigitalStory\Enums\StoryType::WEDDING_INVITATION
            ? 'digital-story.templates.wedding.online-wedding'
            : 'digital-story.templates.love-letter.online-love-letter');
@endphp

@include($view, [
    'story' => $story,
    'template' => $resolvedTemplate,
    'isDemo' => $isDemo ?? false,
])
