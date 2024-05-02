<x-app-layout>
    <x-slot name="header">
        <x-app-header>BECE Candidates</x-app-header>
    </x-slot>

    @section("title", "BECE Candidates")

    <x-app-main>
        @if (count($tags) > 0)
            <section class="mt-2" x-data="{tag:'{{ $tags[0] }}'}" x-cloak="">
                <x-group-buttons-container class="sticky top-2 mx-auto mb-4 w-full">
                    @foreach ($tags as $tag)
                        <x-group-button text="{{ $tag }}" :first="$loop->first" :last="$loop->last" @click="tag='{{ $tag }}'" />
                    @endforeach
                </x-group-buttons-container>

                @foreach ($candidate_data as $academic_year => $candidates)
                    <x-section-component title="List for {{ $academic_year }}">
                        <div class="bg-gray-50 grid gap-3 md:gap-4 grid-cols-1
                                    sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4
                                    shadow border border-gray-100 p-8 text-gray-700
                                    rounded-lg -mt-2">
                            @foreach ($candidates["data"] as $candidate)
                                <x-candidate-card :candidate="$candidate" />
                            @endforeach
                        </div>
                    </x-section-component>
                @endforeach

            </section>
        @endif
    </x-app-main>
</x-app-layout>
