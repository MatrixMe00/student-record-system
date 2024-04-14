@if ($students->count() > 0)
    @php
        $thead = ["School ID No.", "Lastname", "Othernames", "Overall Average Score"];
    @endphp
    <x-table-component class="mt-3" :thead="$thead">
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <x-table-data>{{ __($student->user->username) }}</x-table-data>
                    <x-table-data>{{ __($student->lname) }}</x-table-data>
                    <x-table-data>{{ __($student->oname) }}</x-table-data>
                    <x-table-data>{{ __(round($student->average_grade(), 2)) }}</x-table-data>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr class="border-t">
                <x-thead-data>{{ __("Total") }}</x-thead-data>
                <x-table-data colspan="3">{{ __($students->count()) }}</x-table-data>
            </tr>
        </tfoot>
    </x-table-component>
@else
    <x-empty-div>{{ __("You have no current JHS3 Students") }}</x-empty-div>
@endif
