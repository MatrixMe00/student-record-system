@props(["icon" => "fas fa-school text-6xl"])

<i {{ $attributes->merge(['class' => "$icon text-gray-700"]) }}></i>
