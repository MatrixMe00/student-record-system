<x-app-layout>
    <x-slot name="header">
        <x-app-header>School Results ({{ $academic_year }})</x-app-header>
    </x-slot>

    @section("title", "School Results")

    <x-app-main class="py-4">
        {{-- navigation menu --}}
        @include("history.partials._menu")

        @if ($records->count() > 0)
            <x-content-grid class="mt-6">
                @foreach ($records as $record)
                    @php
                        $subject = $record->subject;
                        $teacher = $record->teacher;
                        $admin = $record->admin;

                        $extras = [
                            ["title" => "Created By", "content" => $teacher?->fullname]
                        ];

                        if($admin){
                            $extras[] = ["title" => "Approved By", "content" => $admin->fullname];
                        }
                    @endphp
                    <x-content-card
                        class="bg-white hover:bg-neutral-50"
                        title="{{ $subject->name }}" item_id="{{ $subject->id }}"
                        :sub_title="'Status: '.ucfirst($record->status)" :extras="$extras"
                        card_link="{{ route($route_head.'.fresult', ['academic_year' => year_link($academic_year), 'school_id' => $school_id, 'program' => $program->id, 'subject' => $subject->id]) }}"
                        :editable="false" :removable="false" />
                @endforeach
            </x-content-grid>
        @else
            <x-empty-div>
                There is no content to display
            </x-empty-div>
        @endif
    </x-app-main>
</x-app-layout>
