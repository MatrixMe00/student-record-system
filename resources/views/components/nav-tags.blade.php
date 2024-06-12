@props(["tags", "stopper" => null, "tag_count" => -1])

@if (is_null($stopper))
    <x-group-buttons-container class="sticky top-2 mx-auto w-full">
        @foreach ($tags as $tag)
            <x-group-button :icon="$tag['icon']" :first="$loop->first" :last="$loop->last" text="{{ $tag['text'] }}" :link="$tag['link'] ?? null" />
        @endforeach
    </x-group-buttons-container>
@else
    <x-group-buttons-container class="py-4">
        @while (++$tag_count <= $stopper)
            <x-group-button
                :icon="$tags[$tag_count]['icon']"
                :first="$tag_count == 0"
                :last="$tag_count == $stopper"
                text="{{ $tags[$tag_count]['text'] }}"
                :link="$tag_count == $stopper ? null :  $tags[$tag_count]['link']"
                :text_color="$tag_count == $stopper ? 'text-blue-800' : 'text-slate-800 hover:text-blue-600'"
            />
        @endwhile
    </x-group-buttons-container>
@endif
