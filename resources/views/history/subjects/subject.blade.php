<x-app-layout>
    <x-slot name="header">
        <x-app-header>{{ __("$program->name - $subject->name [$academic_year]") }}</x-app-header>
    </x-slot>

    @section("title", "Class Subject Data")

    <x-app-main class="py-4">
        {{-- navigation menu --}}
        @include("history.partials._menu")

        <x-group-buttons-container class="w-full justify-center">
            @for ($i = 1; $i <= 3; $i++)
                <x-group-button icon="" text="Term {{ $i }}"
                    :first="$i === 1" :last="$i === 3"
                    text_color="{{ $term == $i ? 'text-blue-500 hover:bg-blue-100' : '' }}"
                    :link="$term == $i ? null : route($route_head.'.results', ['school_id' => $school_id, 'academic_year' => year_link($academic_year), 'program' => $program->id, 'term' => $i, 'subject' => $subject->id]) " />
            @endfor
        </x-group-buttons-container>

        {{-- main content --}}
        <x-section-component class="mt-4" title="Term {{ $term }}">
            @if ($results->count() > 0)
                <x-table-component screens="" class="mt-2">
                    <tbody>
                        <tr class="border-t">
                            <x-table-data class="uppercase"><b>{{ __("Entered By") }}</b></x-table-data>
                            <x-table-data>{{ __($result_head->teacher->fullname) }}</x-table-data>
                            <x-table-data class="uppercase"><b>{{ __("Result Status") }}</b></x-table-data>
                            <x-table-data>{{ __(ucfirst($result_head->status)) }}</x-table-data>
                            <x-table-data class="uppercase"><b>{{ __("Reviewed By") }}</b></x-table-data>
                            <x-table-data>{{ __($result_head->admin?->fullname ?? "Not Reviewed") }}</x-table-data>
                        </tr>
                    </tbody>
                </x-table-component>

                <x-table-component screens="">
                    @section("thead")
                        <thead>
                            <x-thead-data>Index Number</x-thead-data>
                            <x-thead-data>Fullname</x-thead-data>
                            <x-thead-data>Mark</x-thead-data>
                            <x-thead-data>Position</x-thead-data>
                        </thead>
                    @endsection

                    <tbody>
                        @foreach ($results as $result)
                            @php
                                $student = $result->student;
                            @endphp

                            <tr>
                                <x-table-data>{{ __($student->user->username) }}</x-table-data>
                                <x-table-data>{{ __($student->fullname) }}</x-table-data>
                                <x-table-data>{{ __($result->total) }}</x-table-data>
                                <x-table-data>{{ __(positionFormat($result->position)) }}</x-table-data>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table-component>
            @else
                <x-empty-div>{{ __("No results for this term") }}</x-empty-div>
            @endif
        </x-section-component>
    </x-app-main>
</x-app-layout>
