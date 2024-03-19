<x-app-layout>
    <x-slot name="header">
        <x-app-header>Results for {{ $program->name}}</x-app-header>
    </x-slot>

    @section("title", "My Result")

    <x-app-main class="pt-8 pb-10">
        {{-- term tabs --}}
        <x-group-buttons-container class="w-full justify-center">
            @for ($i = 1; $i <= 3; $i++)
                <x-group-button icon="" text="Term {{ $i }}"
                    :first="$i === 1" :last="$i === 3"
                    text_color="{{ $semester == $i ? 'text-blue-500 hover:bg-blue-100' : '' }}"
                    :link="$semester == $i ? null : '/my-result/'.$program->id.'/'.$i" />
            @endfor
        </x-group-buttons-container>

        <x-section-component title="Term {{ $semester }}" class="mt-4">
            @if ($results->count() > 0)
                <x-primary-button type="button" class="mt-4">Print Results</x-primary-button>

                <section class="mt-3">
                    <x-table-component>
                        <tbody>
                            <tr class="border-t">
                                <x-thead-data>Position</x-thead-data>
                                <x-table-data>1st</x-table-data>
                                <x-thead-data>Total Students</x-thead-data>
                                <x-table-data>{{ $rows }}</x-table-data>
                            </tr>
                        </tbody>
                    </x-table-component>

                    <x-table-component>
                        @section("thead")
                            <thead>
                                <x-thead-data>Subject Name</x-thead-data>
                                <x-thead-data>Class Score</x-thead-data>
                                <x-thead-data>Exam Score</x-thead-data>
                                <x-thead-data>Total Score</x-thead-data>
                                <x-thead-data>Description</x-thead-data>
                            </thead>
                        @endsection

                        @php
                            $class_total = $exam_total = 0;
                        @endphp

                        <tbody>
                            @foreach ($results as $grade)
                            @php
                                $class_total += $grade->class_mark;
                                $exam_total += $grade->exam_mark;
                            @endphp
                            <tr>
                                <x-table-data>{{ $grade->subject->name }}</x-table-data>
                                <x-table-data>{{ $grade->class_mark }}</x-table-data>
                                <x-table-data>{{ $grade->exam_mark }}</x-table-data>
                                <x-table-data>{{ $total = $grade->class_mark + $grade->exam_mark }}</x-table-data>
                                <x-table-data>{{ grade_description($total) }}</x-table-data>
                            </tr>

                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr class="border-y">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <x-thead-data>{{ __("Total") }}</x-thead-data>
                                <x-table-data>{{ $class_total }}</x-table-data>
                                <x-table-data>{{ $exam_total }}</x-table-data>
                                <x-table-data>{{ $total = $class_total + $exam_total }}</x-table-data>
                                <x-table-data>{{ grade_description(($total / $results->count())) }}</x-table-data>
                            </tr>
                            <tr class="border-t">
                                <x-thead-data>{{ __("Teacher Remarks") }}</x-thead-data>
                                <x-table-data colspan="4" class="text-wrap">No Remarks provided</x-table-data>
                            </tr>
                        </tfoot>
                    </x-table-component>
                </section>

            @else
                <x-empty-div>{{ __("No results for this period") }}</x-empty-div>
            @endif
        </x-section-component>
    </x-app-main>
</x-app-layout>