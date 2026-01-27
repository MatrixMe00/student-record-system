@props(['icon' => 'fas fa-info-circle'])

@if(isset($text) || $slot->isNotEmpty())
    <p {{ $attributes->merge(['class' => 'mt-2 text-sm text-gray-500 dark:text-gray-400']) }}>
        @if($icon)
            <i class="{{ $icon }} mr-1"></i>
        @endif
        {{ $text ?? $slot }}
    </p>
@endif
