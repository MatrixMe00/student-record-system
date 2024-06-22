@props(["title" => "", "sub_title" => "", "title_link" => "", "link_href" => "javascript:void()"])

<div {{ $attributes->merge(["class"=>"section relative p-4 bg-white"]) }}>
    <div class="container xl:max-w-6xl mx-auto px-4">
        <!-- Heading start -->
        @if (!empty($title))
            <x-section-header class="border-b-2 {{ $title_link != '' ? '' : 'w-fit' }}">
                <div class="{{ $title_link != '' ? 'flex flex-wrap-reverse justify-between sm:items-center' : '' }}">
                    <h2 class="text-2xl leading-normal mb-2 font-bold text-black">{{ __($title) }}</h2>
                    @if ($title_link != "")
                        <a href="{{ $link_href }}" class="text-blue-400 py-1 border-b-transparent border-b hover:border-b-blue-500 hover:text-blue-500">{{ __($title_link) }}</a>
                    @endif
                </div>
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
