@if ($jhs_valid)
    <section class="mt-2 space-y-2">
        <x-section-component title="BECE Index Number">
            <p class="mt-3 text-lg">{{ $student->index_number ?? 'Index Number not set' }}</p>
        </x-section-component>

        <x-section-component title="Placement Details">
            <p class="mt-3 mx-4">
                @if ($student->placement_checker)
                    Your placement checker key is <b>{{ $student->placement_checker }}</b>. Use this to make a follow  up check on your placements.
                @else
                    Placement checker key has not been set.
                @endif
            </p>
            @if ($student->placement && $student->placement['placement_school'])
                @component('components.school.attachment-container')
                    @slot('download_link', url('storage/'.$student->placement["placement_school"]))
                    <p class="mt-3 text-lg">Your placement data is ready to be downloaded</p>
                @endcomponent
            @else
                <x-empty-div>{{ __("Placement details not uploaded") }}</x-empty-div>
            @endif
        </x-section-component>

        <x-section-component title="BECE Results">
            <p class="mt-3 mx-4">
                @if ($student->result_checker)
                    Your result checker key is <b>{{ $student->result_checker }}</b>. Use this to make a follow  up check on your results.
                @else
                    Result checker key has not been set
                @endif
            </p>
            @if ($results->count() > 0)
                @php
                    $result_slips = array_encode($results->results);
                @endphp
                <x-table-component btn_text="Print Results">
                    @section("thead")
                        <thead>
                            <x-thead-data>{{ __("Subject Name") }}</x-thead-data>
                            <x-thead-data>{{ __("Grade Point") }}</x-thead-data>
                        </thead>
                    @endsection

                    <tbody>
                        @foreach ($result_slips as $result)
                            <tr>
                                <x-table-data>{{ __($result["name"]) }}</x-table-data>
                                <x-table-data>{{ __($result["grade"]) }}</x-table-data>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <x-thead-data>{{ __("Raw Score") }}</x-thead-data>
                            <x-thead-data>{{ __($results->raw_score) }}</x-thead-data>
                        </tr>
                    </tfoot>
                </x-table-component>
            @elseif ($student->placement)
                @component('components.school.attachment-container')
                    @slot('download_link', url('storage/'.$student->placement["bece_result"]))
                    <p class="mt-3 text-lg">Your BECE results is ready to be downloaded</p>
                @endcomponent
            @else
                <x-empty-div>{{ __("BECE Results not uploaded") }}</x-empty-div>
            @endif
        </x-section-component>
    </section>
@else
    <x-empty-div>{{ __("You are not a qualified BECE candidate") }}</x-empty-div>
@endif
