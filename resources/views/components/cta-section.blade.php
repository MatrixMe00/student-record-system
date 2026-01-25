@props(['title', 'description' => null, 'subDescription' => null, 'buttons' => []])

<section class="py-16 px-4 bg-indigo-600 md:px-8">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            {{ $title }}
        </h2>
        @if($description)
            <p class="text-xl text-indigo-100 mb-2">
                {{ $description }}
            </p>
        @endif
        @if($subDescription)
            <p class="text-lg text-indigo-200 mb-8">
                {{ $subDescription }}
            </p>
        @endif
        @if(count($buttons) > 0)
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @foreach($buttons as $button)
                    <a href="{{ $button['href'] }}" class="{{ $button['class'] ?? 'inline-block px-8 py-3 bg-white text-indigo-600 font-semibold rounded-lg shadow-lg hover:bg-indigo-50 transition-all duration-200 transform hover:scale-105' }}">
                        {{ $button['text'] }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
