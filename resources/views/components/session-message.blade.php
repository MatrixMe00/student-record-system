@props(["message", "success" => true, "time" => 3500])

@php
    $success = $success ? "bg-green-200 border-green-500" : "bg-red-200 border-red-500"
@endphp
<p {{ $attributes->merge(["class"=>"text-center mt-2 p-2 $success border cursor-pointer"])}} onclick="this.remove()"
    x-data="{ show: true }"
    x-show="show"
    x-transition
    x-init="setTimeout(() => show = false, {{ $time }})"
>{{ $message ?? $slot }}</p>
