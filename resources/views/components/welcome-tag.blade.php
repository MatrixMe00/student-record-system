@props(["arrow_color" => "text-red-400", "href", "tag_name", "icon" => ""])

<a href="{{ $href }}" class="p-6 bg-white dark:bg-gray-800/50
    dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset
    dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none
    flex justify-between items-center w-full sm:min-w-80 transition-all duration-250
    focus:outline focus:outline-2 focus:outline-red-500 group hover:bg-red-50">
    <div class="flex flex-col justify-center items-center w-full">
        <div class="h-20 w-20 bg-red-50 dark:bg-red-800/20 text-center flex items-center justify-center rounded-full">
            @if (!empty($icon))
                <i class="{{ $icon }} text-red-500 text-3xl group-hover:text-red-700"></i>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
            @endif
        </div>

        <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{{ $tag_name }}</h2>
    </div>

    <i class="{{ $arrow_color }} mr-2 fas fa-right-long group-hover:mr-0 group-hover:text-red-700 group-hover:ml-2"></i>
</a>
