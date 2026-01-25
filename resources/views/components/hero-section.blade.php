@props(['title', 'subtitle' => null, 'description' => null, 'buttons' => []])

<section class="relative overflow-hidden py-16 px-4 bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-900 md:px-8">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/50 to-transparent"></div>
    <div class="max-w-4xl mx-auto text-center relative z-10">
        <div class="py-8">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                {!! $title !!}
            </h1>
            @if($subtitle)
                <p class="text-xl text-indigo-100 leading-relaxed max-w-2xl mx-auto mb-4">
                    {!! $subtitle !!}
                </p>
            @endif
            @if($description)
                <p class="text-lg text-indigo-200 max-w-xl mx-auto">
                    {{ $description }}
                </p>
            @endif
        </div>
        @if(count($buttons) > 0)
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @foreach($buttons as $button)
                    <a href="{{ $button['href'] }}" class="{{ $button['class'] ?? 'w-full sm:w-auto px-8 py-3 bg-white text-indigo-900 font-semibold rounded-lg shadow-lg hover:bg-indigo-50 transition-all duration-200 transform hover:scale-105' }}">
                        {{ $button['text'] }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
