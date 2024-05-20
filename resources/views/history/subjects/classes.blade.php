<x-app-layout>
    <x-slot name="header">
        <x-app-header>School Results ({{ $academic_year }})</x-app-header>
    </x-slot>

    @section("title", "School Results")

    <x-app-main class="py-4">
        {{-- navigation menu --}}
        @include("history.partials._menu")

        @php
            $route = "$route_head.class";
        @endphp

        @if ($classes->count() > 0)
            <x-content-grid class="mt-6">
                @foreach ($classes as $class)
                    @php
                        $program = $class->program;
                    @endphp
                    <x-content-card
                        class="bg-white hover:bg-neutral-50"
                        title="{{ $program->name }}" item_id="{{ $program->id }}"
                        :sub_title="$program->slug ?? 'No Slug name'"
                        card_link="{{ route($route, ['academic_year' => year_link($academic_year), 'school_id' => $school_id, 'program' => $program->id, 'term' => 1]) }}"
                        :editable="false" :removable="false" />
                @endforeach
            </x-content-grid>
        @else
            <x-empty-div>
                There is no content to display
            </x-empty-div>
        @endif
    </x-app-main>
</x-app-layout>
