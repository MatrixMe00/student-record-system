@props(["title" => "", "sub_title" => ""])

<div {{ $attributes->merge(["class"=>"section relative p-4 bg-white"]) }}>
    <div class="container xl:max-w-6xl mx-auto px-4">
        <!-- Heading start -->
        @if (!empty($title))
            <x-section-header class="border-b-2 w-fit">
                <h2 class="text-2xl leading-normal mb-2 font-bold text-black">{{ __($title) }}</h2>
                @if (!empty($sub_title))
                    <p class="text-gray-500 leading-relaxed font-light text-xl mx-auto pb-2">{{ __($sub_title) }}</p>
                @endif
            </x-section-header>
        @else
            @yield("section-title")
        @endif

        <!-- End heading -->
        {{ $slot }}
    </div>
</div>
