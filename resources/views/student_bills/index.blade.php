<x-app-layout>
    <x-slot name="header">
        <x-app-header>Billing Information - {{ $current_year }}</x-app-header>
    </x-slot>

    @section("title", "Billing Information")

    <x-app-main class="py-4">
        <x-group-buttons-container>
            @foreach ($academic_years as $academic_year)
                <x-group-button :text="$academic_year" :first="$loop->first"
                    :last="$loop->last" :link="$academic_year == $current_year ? null : route('bills.index', ['academic_year' => $academic_year])"
                />
            @endforeach
        </x-group-buttons-container>

        @if ($programs->count() > 0)
            <x-content-grid class="mt-6">
                @foreach ($programs as $program)
                    <x-content-card
                        class="bg-white hover:bg-neutral-50"
                        title="{{ $program->name }}" item_id="{{ $program->id }}"
                        :sub_title="$program->slug ?? 'No Slug name'"
                        :removable="false" :editable="false" :card_link="route('bills.show', ['academic_year' => year_link($current_year), 'program' => $program->id])" />
                @endforeach
            </x-content-grid>
        @else
            <x-empty-div>
                There is no content to display
            </x-empty-div>
        @endif
    </x-app-main>
</x-app-layout>
