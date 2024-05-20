<x-app-layout>
    <x-slot name="header">
        <x-app-header>School Results (All Time)</x-app-header>
    </x-slot>

    @section("title", "School Results")

    <x-app-main class="py-4">
        {{-- navigation menu --}}
        @include("history.partials._menu")

        @php
            $route = "$route_head.programs";
        @endphp

        @if ($academic_years->count() > 0)
            <x-info-card class="text-center text-sm">Select an academic year to view the class results</x-info-card>
            <x-content-grid class="mt-3">
                @foreach ($academic_years as $academic_year)
                    <x-content-card
                        class="bg-white hover:bg-neutral-50"
                        title="{{ $academic_year }}" item_id="{{ $academic_year }}"
                        card_link="{{ route($route, ['school_id' => $school_id, 'academic_year' => year_link($academic_year)]) }}"
                        :editable="false" :removable="false" />
                @endforeach
            </x-content-grid>
        @else
            <x-empty-div>
                No results history found
            </x-empty-div>
        @endif
    </x-app-main>
</x-app-layout>
