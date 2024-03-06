<x-app-layout>
    <x-slot name="header">
        <x-app-header>Data for {{ $program->name }}, Term {{ $result->semester." (".$academic_year.")" }}</x-app-header>
    </x-slot>

    @section("title", "Result Data")

    <x-app-main>
        @session('success')
            <x-session-message class="mb-2">
                {{ __(session('message')) }}
            </x-session-message>
        @endsession

        @php
            $readonly = $edit_all ? "" : "readonly";
        @endphp
        <div class="flex items-center w-full p-8 mx-auto lg:px-12">
            <div class="w-full">
                <h1 class="text-2xl font-semibold tracking-wider text-gray-800 capitalize dark:text-white">
                    @if ($is_admin)
                        Details for result slip <b>{{ strtoupper($result->result_token) }}</b> [{{ $result->status }}]
                    @else
                        {{ $edit_all ? "Edit" : "Details for" }} result slip <b>{{ strtoupper($result->result_token) }}</b> [{{ $result->status }}]
                    @endif
                </h1>

                <p class="my-4 text-gray-500 dark:text-gray-400">
                    @php
                        if($is_admin){
                            $message = "Verify the status of this result slip";
                        }else{
                            switch ($result->status) {
                                case 'accept':
                                case 'accepted':
                                    $message = "Results have been approved as final records";
                                    break;
                                case 'submitted':
                                    $message = "Results data has been submitted and is awaiting review from admin";
                                    break;
                                case 'reject':
                                case 'rejected':
                                    $message = "Result was rejected. Please make necessary changes and resubmit";
                                    break;
                                default:
                                    $message = "Fill the form below with the needed data";
                            }
                        }

                    @endphp
                    {{ __($message) }}
                </p>

                <div class="grid grid-cols-1 lg:grid-cols-5 gap-2 items-start lg:mt-4">
                    <section class="bg-slate-50 p-2 lg:col-span-2">
                        @include('results.partials._edit_result_head')
                    </section>

                    <section class="bg-slate-50 p-2 mt-8 lg:mt-0 lg:col-span-3">
                        <h1 class="text-2xl font-semibold tracking-wider text-gray-800 capitalize dark:text-white">
                            {{ __($program->name.' result list') }}
                        </h1>

                        <form class="grid grid-cols-1 gap-6 mt-8 border p-4"
                            method="POST" action="{{ route($grades->count() > 0 ? 'grades.update' : 'grades.create') }}">
                            @csrf

                            @php
                                $show_submit = $grades->count() > 0 || $students->count() > 0;
                            @endphp

                            @if ($errors->any())
                            <x-input-error :messages="$errors->all()" />
                            @endif

                            {{-- result_token --}}
                            <x-text-input type="hidden" name="result_token" :value="$result->result_token" required readonly />

                            {{-- school id --}}
                            <x-text-input type="hidden" name="school_id" value="{{ auth()->user()->school->id }}" />

                            {{-- teacher id --}}
                            <x-text-input type="hidden" name="teacher_id" value="{{ auth()->user()->id }}" />

                            {{-- program id --}}
                            <x-text-input type="hidden" name="program_id" value="{{ $program->id }}" />

                            {{-- program id --}}
                            <x-text-input type="hidden" name="semester" value="{{ $result->semester }}" />

                            @if (!$show_submit)
                                <p class="p-4 text-center">
                                    {{ __("No Student data was found for this class") }}
                                </p>
                            @elseif ($grades->count() > 0)
                                @method("PUT")

                                <div class="overflow-auto py-4">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Index Number</th>
                                                <th>Fullname</th>
                                                <th>Class Score</th>
                                                <th>Exam Score</th>
                                                <th>Total Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($grades as $key => $grade)
                                                <x-result-entry-row
                                                    :student="$grade->student" :key="$key"
                                                    :classmark="old('class_mark.'.$key, $grade->class_mark)"
                                                    :exammark="old('exam_mark.'.$key, $grade->exam_mark)"
                                                    :rowid="$grade->id"
                                                    :readonly="$is_admin"
                                                />
                                            @endforeach

                                            {{-- if new students have been added to the class --}}
                                            @if ($unsaved->count() > 0 && $result->status == "pending")
                                                @foreach($unsaved as $key => $student)
                                                    <x-result-entry-row
                                                        :student="$student" :key="$key"
                                                        :classmark="old('class_mark.'.$key, 0)"
                                                        :exammark="old('exam_mark.'.$key, 0)"
                                                        painttd="border-teal-400"
                                                    />
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="overflow-auto py-4">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Index Number</th>
                                                <th>Fullname</th>
                                                <th>Class Score</th>
                                                <th>Exam Score</th>
                                                <th>Total Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($students as $key => $student)
                                                <x-result-entry-row
                                                    :student="$student" :key="$key"
                                                    :classmark="old('class_mark.'.$key, 0)"
                                                    :exammark="old('exam_mark.'.$key, 0)"
                                                />
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            @if ($show_submit && !$is_admin)
                                @if ($edit_once)
                                    <div class="flex flex-col items-center justify-center md:flex-row gap-4">
                                        <button type="submit" value="save" name="submit"
                                            class="flex items-center justify-between w-full md:w-1/2 px-6 py-3 text-sm
                                                tracking-wide text-white capitalize group transform bg-teal-500 rounded-md
                                                hover:bg-teal-400 focus:outline-none focus:ring focus:ring-teal-300
                                                focus:ring-opacity-50">
                                            <span>Save For Later</span>
                                            <i class="far fa-save group-hover:mr-2 transition-all duration-500"></i>
                                        </button>
                                        <button type="submit" value="submit" name="submit"
                                            class="flex items-center justify-between w-full md:w-1/2 px-6 py-3 text-sm
                                                tracking-wide text-white capitalize group transform bg-blue-500 rounded-md
                                                hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300
                                                focus:ring-opacity-50">
                                            <span>Submit as Final</span>
                                            <i class="fas fa-angle-right group-hover:mr-2 transition-all duration-500"></i>
                                        </button>
                                    </div>
                                @endif


                            @elseif ($is_admin)
                                <div class="flex flex-col items-center justify-center md:flex-row gap-4">
                                    {{-- set pending status --}}
                                    @if (in_array($result->status, ["submitted", "accepted", "accept", "rejected", "reject"]))
                                        <button type="submit" value="pending" name="submit"
                                        class="flex items-center justify-between w-full md:w-1/2 px-6 py-3 text-sm
                                            tracking-wide text-white capitalize group transform bg-blue-500 rounded-md
                                            hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300
                                            focus:ring-opacity-50">
                                        <span>Save for Editing</span>
                                        <i class="far fa-edit group-hover:mr-2 transition-all duration-500"></i>
                                    </button>
                                    @endif

                                    {{-- set save status --}}
                                    @if (in_array($result->status, ["submitted", "rejected", "reject"]))
                                        <button type="submit" value="accepted" name="submit"
                                        class="flex items-center justify-between w-full md:w-1/2 px-6 py-3 text-sm
                                            tracking-wide text-white capitalize group transform bg-teal-500 rounded-md
                                            hover:bg-teal-600 focus:outline-none focus:ring focus:ring-teal-300
                                            focus:ring-opacity-50">
                                        <span>Approve Results</span>
                                        <i class="fas fa-check group-hover:mr-2 transition-all duration-500"></i>
                                    </button>
                                    @endif

                                    {{-- set reject status --}}
                                    @if (in_array($result->status, ["submitted", "accepted", "accept"]))
                                        <button type="submit" value="reject" name="submit"
                                        class="flex items-center justify-between w-full md:w-1/2 px-6 py-3 text-sm
                                            tracking-wide text-white capitalize group transform bg-red-500 rounded-md
                                            hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-300
                                            focus:ring-opacity-50">
                                        <span>Reject Results</span>
                                        <i class="fas fa-times group-hover:mr-2 transition-all duration-500"></i>
                                    </button>
                                    @endif

                                    @if ($result->status == "pending")
                                        <p class="border p-2 text-center w-full cursor-default">
                                            {{ "Results is still been written for submission" }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </form>
                    </section>
                </div>

            </div>
        </div>

    </x-app-main>
</x-app-layout>
