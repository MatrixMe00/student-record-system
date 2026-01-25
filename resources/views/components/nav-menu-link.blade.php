@props(["name", "href", "is_current" => false])

@php
    $baseClasses = "px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200";
    $activeClasses = $is_current 
        ? "text-indigo-600 bg-indigo-50 font-semibold" 
        : "text-gray-700 hover:text-indigo-600 hover:bg-gray-50";
    $classes = $baseClasses . " " . $activeClasses;
@endphp

<a href="{{ $href }}" {!! $attributes->merge(["class" => $classes]) !!}>
    {{ $name ?? $slot }}
</a>
