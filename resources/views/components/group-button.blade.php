@props(["icon" => null, "text", "first" => false, "last" => false])
@php
    $first = $first ? 'rounded-l-lg' : '';
    $last = $last ? 'rounded-r-lg' : '';
@endphp
<button {{ $attributes->merge(["class"=>"text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 $first $last font-medium px-4 py-2 inline-flex space-x-1 items-center"]) }}>
    @if ($icon)
        <i class="{{ $icon }} w-4 h-4"></i>
    @endif
    <span>{{ __(ucfirst($text)) }}</span>
</button>
