<x-app-layout>
    <x-slot name="header">
        <x-app-header>{{ __("$academic_year Results For $program->name") }}</x-app-header>
    </x-slot>

    @section("title", "Class Data")

    <x-app-main class="py-4">
        {{-- navigation menu --}}
        @include("history.partials._menu")

        <x-group-buttons-container class="w-full justify-center">
            @for ($i = 1; $i <= 3; $i++)
                <x-group-button icon="" text="Term {{ $i }}"
                    :first="$i === 1" :last="$i === 3"
                    text_color="{{ $term == $i ? 'text-blue-500 hover:bg-blue-100' : '' }}"
                    :link="$term == $i ? null : route($route_head.'.class', ['school_id' => $school_id, 'academic_year' => year_link($academic_year), 'program' => $program->id, 'term' => $i]) " />
            @endfor
        </x-group-buttons-container>

        {{-- main content --}}
        <x-section-component class="mt-4" title="Term {{ $term }}">
            @if ($results->count() > 0)
                <x-table-component screens="" class="mt-2">
                    @section("thead")
                        <thead>
                            <x-thead-data>Index Number</x-thead-data>
                            <x-thead-data>Fullname</x-thead-data>
                            <x-thead-data>Total Marks</x-thead-data>
                            <x-thead-data>Position</x-thead-data>
                        </thead>
                    @endsection

                    <tbody>
                        @foreach ($results as $result)
                            @php
                                $student = $result->student;
                            @endphp

                            <tr class="group hover:bg-gray-50">
                                <x-table-data>{{ __($student->user->username) }}</x-table-data>
                                <x-table-data>{{ __($student->fullname) }}</x-table-data>
                                <x-table-data>{{ __($result->total_marks) }}</x-table-data>
                                <x-table-data>{{ __(positionFormat($result->position)) }}</x-table-data>
                                <x-table-data class="cursor-pointer text-stone-500 group-hover:text-stone-800"
                                    title="View Results"
                                    onclick="location.href='{{ route($route_head.'.student', ['academic_year' => year_link($academic_year), 'student' => $student->user_id, 'program' => $program->id, 'term' => $term]) }}'"
                                >
                                    <i class="fas fa-scroll"></i>
                                </x-table-data>
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
