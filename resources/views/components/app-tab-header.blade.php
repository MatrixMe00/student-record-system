@props(["tabs", "linktab" => false])

<ul class="grid border grid-flow-col text-center text-gray-500 p-1">
    @foreach ($tabs as $tab)
        <li id="{{ $tab['name'] ?? $tab }}" @click="contentBox='{{ $tab['name'] ?? $tab }}'"><a :href="$linktab ? $tab['href'] ? 'javascript:void(0)'" :class="contentBox=='{{ $tab['name'] ?? $tab }}' ? 'flex justify-center bg-white rounded-tl-lg rounded-tr-lg border-l border-t border-r border-gray-100 py-4':'flex justify-center py-4 cursor-pointer hover:bg-slate-200'">{{ ucwords($tab['name'] ?? $tab) }}</a></li>
    @endforeach
    {{-- <li><a href="#page2" class="flex justify-center bg-white rounded-tl-lg rounded-tr-lg border-l border-t border-r border-gray-100 py-4">Titan maintenance</a></li> --}}
</ul>
