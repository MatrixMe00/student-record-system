<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} {{ " | " }} @yield('title', ucwords(request()->route()->getName()))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="{{ asset('jquery/compressed_jquery.js') }}"></script>
        <style>
            @page{
                size: A4; margin-left: 0
            }
            @media print{
                html, body{
                    width: 210mm; height: 297mm;
                }
            }
        </style>
    </head>

    <body>
        <x-app-main class="">
            <x-section-component class="">
                <table class="w-full border mx-auto" shadow="">
                    {{-- school data --}}
                    <tr class="border-y">
                        <x-thead-data class="border-0 text-center flex flex-col gap-1">
                            <span class="text-[12pt]">{{ $school->school_name }}</span>
                            <span>{{ "$school->box_number | $school->gps_address" }}</span>
                            <span>{{ "$school->circuit Circuit" }}</span>
                            @if ($school->district)
                                <span>{{ "$school->district District" }}</span>
                            @endif
                        </x-thead-data>
                        <x-table-data class="p-0">
                            <img src="{{ url("storage/".$school->logo_path) }}" alt="" class="w-[20mm] h-[20mm]">
                        </x-table-data>
                    </tr>
                    <tr>
                        <x-thead-data class="text-center" colspan="2">Terminal Report</x-thead-data>
                    </tr>
                </table>

                <section class="mt-3">
                    {{-- info table --}}
                    <table class="w-full border" shadow="">
                        <tbody>
                            <tr class="border-t">
                                <x-thead-data>Name</x-thead-data>
                                <x-table-data colspan="2" style="border-right: thin solid lightgrey">{{ "$student->lname $student->oname" }}</x-table-data>
                                {{-- <x-thead-data>Class</x-thead-data> --}}
                                <x-table-data colspan="2">{{ $program->name }}</x-table-data>
                            </tr>
                            <tr class="border-t">
                                <x-thead-data class>Position</x-thead-data>
                                <x-table-data class="border-b" style="border-right: thin solid lightgrey">{{ positionFormat($remark?->position) }}</x-table-data>
                                <x-thead-data class>Attendance</x-thead-data>
                                <x-table-data class="border-b" style="border-right: thin solid lightgrey">{{ $remark?->attendance." of ".$remark?->head_remark->total_attendance }}</x-table-data>
                                <x-thead-data>Term</x-thead-data>
                                <x-table-data>{{ $semester }}</x-table-data>
                            </tr>
                        </tbody>
                    </table>

                    {{-- marks table --}}
                    <table class="w-full mt-6 mb-8 border">
                        <thead>
                            <x-thead-data>Subject Name</x-thead-data>
                            <x-thead-data>Class Score</x-thead-data>
                            <x-thead-data>Exam Score</x-thead-data>
                            <x-thead-data>Total Score</x-thead-data>
                            <x-thead-data>Position</x-thead-data>
                            <x-thead-data>Description</x-thead-data>
                        </thead>

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
                                {{-- <x-table-data>{{ $class_total }}</x-table-data>
                                <x-table-data>{{ $exam_total }}</x-table-data> --}}
                                <x-table-data colspan="2">{{ $total = $class_total + $exam_total }}</x-table-data>
                                {{-- <x-table-data>{{ grade_description(($total / $results->count())) }}</x-table-data> --}}
                            </tr>
                            <tr class="border-t">
                                <x-thead-data>{{ __("Teacher's Remark") }}</x-thead-data>
                                <x-table-data class="text-wrap">{{ __($remark?->remark ?  $remark->remark : "No Remarks provided") }}</x-table-data>
                                <x-thead-data>{{ __("Head Master's Remark") }}</x-thead-data>
                                <x-table-data colspan="2" class="text-wrap">{{ __($remark?->h_remark ?  $remark->h_remark : "No Remark provided") }}</x-table-data>
                            </tr>
                            <tr class="border-t">
                                <x-thead-data>{{ __("Interest") }}</x-thead-data>
                                <x-table-data class="text-wrap">{{ __($remark?->interest ? $remark?->interest : "No information provided") }}</x-table-data>
                                <x-thead-data>{{ __("Conduct") }}</x-thead-data>
                                <x-table-data class="text-wrap">{{ __($remark?->conduct ? $remark?->conduct : "No information provided") }}</x-table-data>
                                <x-thead-data>{{ __("Attitude") }}</x-thead-data>
                                <x-table-data class="text-wrap">{{ __($remark?->attitude ? $remark?->attitude : "No information provided") }}</x-table-data>
                            </tr>

                            @if ($semester == 3)
                                <tr class="border-t">
                                    {{-- <x-thead-data>{{ __("Promoted") }}</x-thead-data>
                                    <x-table-data class="text-wrap">{{ __($remark->promoted == true ? "Yes" : "No") }}</x-table-data> --}}
                                    <x-thead-data>{{ __("Promoted To") }}</x-thead-data>
                                    <x-table-data class="text-wrap">{{ __($remark->promoted == true ? $remark_head->promoted_class->name : "N/A") }}</x-table-data>
                                </tr>
                            @endif
                        </tfoot>
                    </table>

                    <div class="flex gap-x-4 pl-4 border-l-2 border-l-neutral-600 items-center">
                        <div class="qrcode">
                            {!! QrCode::size(80)->generate("Digitally Signed by ".$school->school_head) !!}
                        </div>
                        <div class="remark">
                            Digitally Signed by<br><span>{{ $school->school_head }}</span>
                        </div>
                    </div>
                </section>
            </x-section-component>
        </x-app-main>
    </body>

    <script>
        $(document).ready(function(){
            window.print();

            var afterPrint = function() {
                location.href=document.referrer;
            };

            if (window.matchMedia) {
                var mediaQueryList = window.matchMedia('print');
                mediaQueryList.addListener(function(mql) {
                    if (mql.matches) {
                        // beforePrint();
                    } else {
                        afterPrint();
                    }
                });
            }

            window.onafterprint = afterPrint;

        })
    </script>
</html>
