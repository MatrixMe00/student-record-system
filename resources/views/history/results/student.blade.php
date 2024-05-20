<x-app-layout>
    <x-slot name="header">
        <x-app-header>{{ __("$program->name results for $student->lname") }}</x-app-header>
    </x-slot>

    @section("title", "Student Data")

    <x-app-main class="py-4">
        {{-- navigation menu --}}
        @include("history.partials._menu")

        <x-section-component title="Term {{ $term }}">
            @if ($results->count() > 0)
                <x-table-component screens="" class="mt-3">
                    <tbody>
                        <tr class="border-t">
                            <x-thead-data>Position</x-thead-data>
                            <x-table-data>{{ positionFormat($remark?->position) }}</x-table-data>
                            <x-thead-data>Attendance</x-thead-data>
                            <x-table-data>{{ $remark?->attendance." of ".$remark?->head_remark->total_attendance }}</x-table-data>
                        </tr>
                    </tbody>
                </x-table-component>

                <x-table-component screens="">
                    @section("thead")
                        <thead>
                            <x-thead-data>Subject Name</x-thead-data>
                            <x-thead-data>Class Score</x-thead-data>
                            <x-thead-data>Exam Score</x-thead-data>
                            <x-thead-data>Total Score</x-thead-data>
                            <x-thead-data>Position</x-thead-data>
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
                                <x-table-data>{{ positionFormat($grade->position) }}</x-table-data>
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
                            <x-thead-data colspan="3">{{ __("Overall Score") }}</x-thead-data>
                            <x-table-data colspan="2">{{ $total = $class_total + $exam_total }}</x-table-data>
                        </tr>
                        <tr class="border-t">
                            <x-thead-data>{{ __("Interest") }}</x-thead-data>
                            <x-table-data class="text-wrap">{{ __($remark?->interest ? $remark?->interest : "No information provided") }}</x-table-data>
                            <x-thead-data>{{ __("Conduct") }}</x-thead-data>
                            <x-table-data class="text-wrap">{{ __($remark?->conduct ? $remark?->conduct : "No information provided") }}</x-table-data>
                            <x-thead-data>{{ __("Attitude") }}</x-thead-data>
                            <x-table-data class="text-wrap">{{ __($remark?->attitude ? $remark?->attitude : "No information provided") }}</x-table-data>
                        </tr>
                        <tr class="border-t">
                            <x-thead-data>{{ __("Teacher's Remark") }}</x-thead-data>
                            <x-table-data colspan="5" class="text-wrap">{{ __($remark?->remark ?  $remark->remark : "No Remarks provided") }}</x-table-data>
                        </tr>
                        <tr class="border-t">
                            <x-thead-data>{{ __("Head Teacher's Remark") }}</x-thead-data>
                            <x-table-data colspan="5" class="text-wrap">{{ __($remark?->h_remark ?  $remark->h_remark : "No Remark provided") }}</x-table-data>
                        </tr>
                        @if ($term == 3 && $remark_head)
                            <tr class="border-t">
                                <x-thead-data>{{ __("Current Class") }}</x-thead-data>
                                <x-table-data class="text-wrap">{{ __($program->name) }}</x-table-data>
                                <x-thead-data>{{ __("Promoted To") }}</x-thead-data>
                                <x-table-data class="text-wrap">{{ __($remark->promoted == true ? $remark_head->promoted_class->name : "Repeated") }}</x-table-data>
                            </tr>
                        @elseif (is_null($remark_head))
                            <tr class="border-t">
                                <x-table-data>Report not readied by class teacher. Report is not visible to student yet</x-table-data>
                            </tr>
                        @endif
                    </tfoot>
                </x-table-component>
            @else
                <x-empty-div>
                    {{ __("No results were returned") }}
                </x-empty-div>
            @endif
        </x-section-component>

    </x-app-main>
</x-app-layout>
