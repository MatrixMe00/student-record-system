@props(["tabs", "contents", "islink" => false])

<div class="p-8" x-data="{contentBox:'{{ $tabs[0]['name'] ?? $tabs[0] }}'}" x-cloak="">
    <x-app-tab-header :tabs="$tabs" :linktab="$islink" />
    @if (isset($contents))
        @foreach ($contents as $content)
            <div class="bg-white shadow border border-gray-100 p-8 text-gray-700 rounded-lg -mt-2">
                {{ $content }}
            </div>
        @endforeach
    @else
        {{ $slot }}
    @endif
</div>
