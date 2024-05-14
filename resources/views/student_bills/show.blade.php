<x-app-layout>
    <x-slot name="header">
        <x-app-header>Bill List for {{ $program->name." ".$academic_year }} (Cleared)</x-app-header>
    </x-slot>

    @section("title", "Student Bill List (Cleared)")

    <x-app-main class="py-4">
        <x-group-buttons-container>
            <x-group-button :first="true" :last="false" text="Cleared" :link="request()->routeIs('bills.show') ? null : route('bills.show', ['academic_year' => year_link($academic_year), 'program' => $program->id])" />
            <x-group-button :first="false" :last="true" text="Debtors" :link="request()->routeIs('bills.edit') ? null : route('bills.edit', ['academic_year' => year_link($academic_year), 'program' => $program->id])" />
        </x-group-buttons-container>

        {{-- main data --}}
        <x-table-component class="mt-4">
            @section("thead")
                <thead>
                    <x-thead-data>{{ __("Student ID") }}</x-thead-data>
                    <x-thead-data>{{ __("Full Name") }}</x-thead-data>
                    <x-thead-data>{{ __("Debt Cleared (GHC)") }}</x-thead-data>
                    <x-thead-data>{{ __("Clearance Date") }}</x-thead-data>
                </thead>
            @endsection

            <tbody>
                @foreach ($students as $student)
                @php
                    $total_amount += $student->amount;
                @endphp
                    <tr>
                        <x-table-data>{{ __($student->student->user->username) }}</x-table-data>
                        <x-table-data>{{ __($student->student->fullname) }}</x-table-data>
                        <x-table-data>{{ __(number_format($student->amount, 2)) }}</x-table-data>
                        <x-table-data>{{ __(date("d m, Y H:i:s", strtotime($student->updated_at))) }}</x-table-data>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <x-thead-data>Total</x-thead-data>
                    <x-table-data colspan="2">{{ __(number_format($total_amount, 2)) }}</x-table-data>
                </tr>
            </tfoot>
        </x-table-component>
    </x-app-main>
</x-app-layout>
