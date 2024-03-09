@props(["main" => false, "link" => "javascript:void(0)"])
<td {{ $attributes->merge(["class"=>"py-2 px-4 border-b border-b-gray-50"]) }}>
    @if ($main)
        <div class="flex items-center">
            <a href="{{ $link }}" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">{{ $slot }}</a>
        </div>
    @else
    <span class="text-[13px] font-medium text-gray-400">{{ $slot }}</span>
    @endif

</td>
