<x-app-layout>
    <x-slot name="header">
        <x-app-header>{{ $school->school_name }}</x-app-header>
    </x-slot>

    @section("title", "School Menu")

    @php
        $tags = [
            ["text" => "Menu", "id" => "menu", "icon" => ""],
            ["text" => "About", "id" => "about", "icon" => ""],
            // ["text" => "", "id" => "", "icon" => ""],
        ]
    @endphp

    <x-app-main class="pt-3 pb-4" x-data="{tag:'{{ $tags[1]['id'] }}' }" x-cloak="">
        {{-- tags --}}
        <x-group-buttons-container class="py-4">
            @foreach ($tags as $tag)
                <x-group-button :icon="$tag['icon']" :first="$loop->first" :last="$loop->last" text="{{ $tag['text'] }}" @click="tag='{{ $tag['id'] }}'" />
            @endforeach
        </x-group-buttons-container>

        {{-- menu --}}
        <x-section-component title="Menu Items" x-show="tag=='menu'">

        </x-section-component>

        {{-- about --}}
        <x-section-component x-show="tag=='about'">
            @include("school-content")
        </x-section-component>
    </x-app-main>
</x-app-layout>
