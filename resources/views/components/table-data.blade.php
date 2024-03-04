@props(["message", "icon" => ""])

<td {{ $attributes->merge(["class"=>"border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 "]) }}>
    @if (!empty($icon))
        <i class="{{ $icon }}"></i>
    @endif
    {{ $message ?? $slot }}
</td>
