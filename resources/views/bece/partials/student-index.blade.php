@if ($jhs_valid)
    <section class="mt-2 space-y-2">
        <x-section-component title="BECE Index Number">
            <p class="mt-3 text-lg">{{ $student->index_number ?? 'Index Number not set' }}</p>
        </x-section-component>

        <x-section-component title="Placement Details">
            @if ($student->placement)
                <p class="mt-3 text-lg">Your school of placement is {{ $student->placement["placement_school"] }}</p>
            @else
                <x-empty-div>{{ __("Placement details not uploaded") }}</x-empty-div>
            @endif
        </x-section-component>

        {{-- show the result checker --}}
        <x-section-component title="Result Checker">
            @if ($student->result_checker)
                <p class="mt-3 text-lg">Your result checker key is <b>{{ $student->result_checker }}</b>. Use this to make a follow  up check on your results.</p>
            @else
                <x-empty-div>{{ __("Result checker not provided or not used yet") }}</x-empty-div>
            @endif
        </x-section-component>

        <x-section-component title="BECE Results">
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
                    @slot('download_link', url('storage/'.$candidate->placement["bece_result"]))
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
