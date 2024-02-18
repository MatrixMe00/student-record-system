@props(["icon" => "fas fa-school text-6xl"])

@php
    if(!str_contains($icon, 'xl')){
        $icon .= " text-6xl";
    }
@endphp

<i {{ $attributes->merge(['class' => "$icon text-gray-700"]) }}></i>
