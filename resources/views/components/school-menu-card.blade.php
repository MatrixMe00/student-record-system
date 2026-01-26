@props(["icon" => "fas fa-school text-6xl", "message" => null, "item_url" => null])

<div class="sm:w-56 w-full bg-white shadow rounded border border-neutral-200 hover:border-blue-500 cursor-pointer"
    @if ($item_url)
        onclick="location.href='{{ $item_url }}'"
    @endif
>
    <div class="h-32 w-full checker-bg flex items-center justify-center p-4">
      <x-application-logo variant="icon-only" :icon="$icon" />
    </div>

    <div class="p-4 border-t border-gray-200" x-data="{showMore:false}" x-cloak="">
      <div class="w-full">
        <h1 class="text-gray-600 font-medium text-center">{{ $message ?? $slot }}</h1>
      </div>
    </div>
  </div>
