<x-app-layout>
    <x-slot name="header">
        <x-app-header>Data for {{ $program->name }}, Term {{ $result->semester." (".$academic_year.")" }}</x-app-header>
    </x-slot>

    @section("title", "Result Data")

    <x-app-main>
        <x-session-component />

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
                                case 'accepted':
                                    $message = "Results have been approved as final records";
                                    break;
                                case 'submitted':
                                    $message = "Results data has been submitted and is awaiting review from admin";
                                    break;
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
                        @include("results.partials._edit_result_body")
                    </section>
                </div>

            </div>
        </div>

    </x-app-main>
</x-app-layout>
