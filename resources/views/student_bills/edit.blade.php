<x-app-layout>
    <x-slot name="header">
        <x-app-header>Bill List for {{ $program->name." ".$academic_year }} (Debtors)</x-app-header>
    </x-slot>

    @section("title", "Student Bill List (Debtors)")

    <x-app-main class="py-4 space-y-4">
        <x-group-buttons-container>
            <x-group-button :first="true" :last="false" text="Cleared" :link="request()->routeIs('bills.show') ? null : route('bills.show', ['academic_year' => year_link($academic_year), 'program' => $program->id])" />
            <x-group-button :first="false" :last="true" text="Debtors" :link="request()->routeIs('bills.edit') ? null : route('bills.edit', ['academic_year' => year_link($academic_year), 'program' => $program->id])" />
        </x-group-buttons-container>

        <x-session-component />

        @if ($class_students->count() > 0)
            <x-form-container padding="">
                <x-form-element mdcols="" method="post" action="{{ route('bills.store', ['academic_year' => year_link($academic_year), 'program' => $program->id]) }}">
                    @include("student_bills.partials._defaults")
                    @include("student_bills.partials._body")
                </x-form-element>
            </x-form-container>
        @else
            <x-empty-div>{{ __("You have no students in this class currently") }}</x-empty-div>
        @endif

    </x-app-main>
</x-app-layout>
