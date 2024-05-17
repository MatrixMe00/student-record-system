@props(["title" => null, "title_class" => "", "content_class" => "", "content"])
<div {{ $attributes->merge(["class"=>""]) }}>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        @if ($title)
            <h2 class="text-2xl font-bold mb-2 text-gray-800 {{ $title_class }}">{{ $title }}</h2>
        @endif

        <p class="text-gray-700 {{ $content_class }}">{{ $content ?? $slot }}</p>
    </div>
</div>
