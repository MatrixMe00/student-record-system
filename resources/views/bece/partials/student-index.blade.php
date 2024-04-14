@if ($jhs_valid)
    <section class="mt-2 space-y-2">
        <x-section-component title="BECE Index Number" sub_title="{{ $student->index_number ?? 'Index Number not set' }}"></x-section-component>
        <x-section-component title="Placement Details">
            @if ($student?->placement)
                <p>There is placement</p>
            @else
                <x-empty-div>{{ __("Placement details not uploaded") }}</x-empty-div>
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
            @else
                <x-empty-div>{{ __("BECE Results not uploaded") }}</x-empty-div>
            @endif
        </x-section-component>
    </section>
@else
    <x-empty-div>{{ __("You are not a qualified BECE candidate") }}</x-empty-div>
@endif
