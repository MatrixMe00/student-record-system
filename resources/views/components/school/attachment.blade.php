@props(["icon" => "fas fa-paperclip", "filename", "size" => ""])

<i class="{{ $icon }}"></i>
<div class="ml-4 flex min-w-0 flex-1 gap-2">
    <span class="truncate font-medium">{{ __($filename) }}</span>
    @if ($size)
        <span class="flex-shrink-0 text-gray-400">2.4mb</span>
    @endif
</div>
