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
            @if ($results->count() > 0 && $remark && $remark->status == "accepted")
                <x-primary-button type="button" class="mt-4" onclick="location.href='/my-result/{{ $program->id.'/'.$semester }}/print'">Print Results</x-primary-button>

                <section class="mt-3">
                    <x-table-component>
                        <tbody>
                            <tr class="border-t">
                                <x-thead-data>Position</x-thead-data>
                                <x-table-data>{{ positionFormat($remark?->position) }}</x-table-data>
                                <x-thead-data>Number on Roll</x-thead-data>
                                <x-table-data>{{ $rows }}</x-table-data>
                                <x-thead-data>Attendance</x-thead-data>
                                <x-table-data>{{ $remark?->attendance." of ".$remark?->head_remark->total_attendance }}</x-table-data>
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
                                {{-- <x-table-data>{{ $class_total }}</x-table-data> --}}
                                {{-- <x-table-data>{{ $exam_total }}</x-table-data> --}}
                                <x-table-data colspan="2">{{ $total = $class_total + $exam_total }}</x-table-data>
                                {{-- <x-table-data>{{ grade_description(($total / $results->count())) }}</x-table-data> --}}
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
                            @if ($semester == 3)
                                <tr class="border-t">
                                    {{-- <x-thead-data>{{ __("Promoted") }}</x-thead-data>
                                    <x-table-data class="text-wrap">{{ __($remark->promoted == true ? "Yes" : "No") }}</x-table-data> --}}
                                    <x-thead-data>{{ __("Promoted To") }}</x-thead-data>
                                    <x-table-data class="text-wrap">{{ __($remark->promoted == true ? $remark_head->promoted_class->name : "Repeated") }}</x-table-data>
                                </tr>
                            @endif
                        </tfoot>
                    </x-table-component>
                </section>
            @elseif ($results->count() > 0 && is_null($remark) || $remark?->status != "accepted")
                <x-empty-div>{{ __("Results are not ready for viewing. Please try again later") }}</x-empty-div>
            @else
                <x-empty-div>{{ __("No results for this period") }}</x-empty-div>
            @endif
        </x-section-component>
    </x-app-main>
</x-app-layout>
