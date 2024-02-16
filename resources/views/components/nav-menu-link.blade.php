@props(["name", "href", "is_current" => false])

@php
    $selected = $is_current ? "text-indigo-600" : "text-gray-500"
@endphp
<li {!! $attributes->merge(["class"=>"$selected hover:text-indigo-600"]) !!}>
    <a href="{{ $href }}">{{ $name ?? $slot }}</a>
</li>
