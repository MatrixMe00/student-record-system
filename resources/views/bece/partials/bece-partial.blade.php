@php
    $thead = [
        "Index Number", "Lastname", "Othername"
    ];
    $years = array_keys($candidates->toArray());
@endphp

<section class="mt-3" x-data="{year:'{{ $years[0] ?? '' }}'}" x-cloak="">
    @if (count($years) > 0)
        <div class="py-2 px-4 border">
            <h4 class="mb-1">Academic Years</h4>
            <x-group-buttons-container class="sticky top-2 mx-auto">
                @foreach ($years as $year)
                    <x-group-button text="{{ $year }}" :first="$loop->first" :last="$loop->last" @click="year='{{ $year }}'" />
                @endforeach
            </x-group-buttons-container>
        </div>
    @endif

    @foreach ($candidates as $academic_year)
        <x-section-component :title="$academic_year['title']" x-show="year=='{{ $academic_year['title'] }}'">
            <x-table-component class="mt-3" :thead="$thead">
                <tbody>
                    @foreach ($academic_year["data"] as $data)
                        <tr class="hover:bg-neutral-300 cursor-pointer" onclick="location.href='{{ route('school.candidate.show', ['beceCandidate'=>$data->id]) }}'">
                            <x-table-data>{{ __($data->index_number ?? "Not Set") }}</x-table-data>
                            <x-table-data>{{ __(strtoupper($data->student->lname)) }}</x-table-data>
                            <x-table-data>{{ __(strtoupper($data->student->oname)) }}</x-table-data>
                        </tr>
                    @endforeach
                </tbody>
            </x-table-component>
        </x-section-component>
    @endforeach
</section>
