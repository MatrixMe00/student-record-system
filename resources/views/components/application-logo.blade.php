@props([
    "icon" => "fas fa-school",
    "showText" => true,
    "text" => "EduRecordsGH",
    "variant" => "default" // default, compact, icon-only
])

@php
    // Clean icon class - remove any existing size classes as we'll control size via container
    $iconBase = preg_replace('/\btext-\w+\b/', '', $icon);
    $iconBase = trim($iconBase);
    
    // Variant-based styling
    $containerClass = match($variant) {
        'compact' => 'flex items-center space-x-2',
        'icon-only' => 'flex items-center justify-center',
        default => 'flex items-center space-x-3'
    };
    
    $iconContainerClass = match($variant) {
        'compact' => 'w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center shadow-sm',
        'icon-only' => 'w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md',
        default => 'w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center shadow-sm'
    };
    
    $iconSize = match($variant) {
        'compact' => 'text-sm',
        'icon-only' => 'text-2xl',
        default => 'text-lg'
    };
    
    $textSize = match($variant) {
        'compact' => 'text-lg',
        'icon-only' => 'hidden',
        default => 'text-xl'
    };
    
    $iconClass = "$iconBase $iconSize";
    $textClass = "$textSize font-bold";
@endphp

<div {{ $attributes->merge(['class' => $containerClass]) }}>
    <div class="{{ $iconContainerClass }}">
        <i class="{{ $iconClass }} text-white"></i>
    </div>
    @if($showText && $variant !== 'icon-only')
        <span class="{{ $textClass }} {{ $attributes->get('text-color', 'text-gray-900') }}">
            {{ $text }}
        </span>
    @endif
</div>
