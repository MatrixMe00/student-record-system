<x-app-layout>
    <x-slot name="header">
        <x-app-header>Data for {{ $program->name }}, Term {{ $remark_head->semester." (".$academic_year.")" }}</x-app-header>
    </x-slot>

    @section("title", "Result Data")

    <x-app-main>
        <x-session-component />

        <div class="flex items-center w-full p-8 mx-auto lg:px-12">
            <div class="w-full">
                <h1 class="text-2xl font-semibold tracking-wider text-gray-800 capitalize dark:text-white">
                    @if ($is_admin)
                        Details for remark slip <b>{{ strtoupper($remark_head->remark_token) }}</b> [{{ $remark_head->status }}]
                    @else
                        {{ $edit_all ? "Edit" : "Details for" }} remark slip <b>{{ strtoupper($remark_head->remark_token) }}</b> [{{ $remark_head->status }}]
                    @endif
                </h1>

                <p class="my-4 text-gray-500 dark:text-gray-400">
                    @php
                        if($is_admin){
                            $message = "Verify the status of this remark slip";
                        }else{
                            switch ($remark_head->status) {
                                case 'accepted':
                                    $message = "Remarks have been approved for display on result slips";
                                    break;
                                case 'submitted':
                                    $message = "Remarks data has been submitted and is awaiting review from admin";
                                    break;
                                case 'rejected':
                                    $message = "Remark data was rejected. Please make necessary changes and resubmit";
                                    break;
                                default:
                                    $message = "Fill the form below with the needed data";
                            }
                        }

                    @endphp
                    {{ __($message) }}
                </p>

                @if (!$is_admin || ($is_admin && $remark_head->status != "pending"))
                    <div class="grid grid-cols-1 items-start lg:mt-4">
                        <section class="bg-slate-50 p-2 mt-8 lg:mt-0 lg:col-span-3">
                            @include("remarks.partials._edit_remark_body")
                        </section>
                    </div>
                @else
                    <x-empty-div>{{ __("Remark slip is still in edit mode by the teacher. Please wait for submission") }}</x-empty-div>
                @endif


            </div>
        </div>

    </x-app-main>
</x-app-layout>
