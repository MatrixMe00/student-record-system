@props(["icon" => "fas fa-school"])

<i {{ $attributes->merge(['class' => "$icon text-6xl text-gray-700"]) }}></i>
