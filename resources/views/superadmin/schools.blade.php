<x-app-layout>
    <x-slot name="header">
        <x-app-header>School Management</x-app-header>
    </x-slot>

    @section("title", "School Management")

    <x-app-main class="mt-4">
        <x-content-grid>
            @foreach ($schools as $school)
                @php
                    $extras = [
                        ["title" => "Students","content" => round_number($school->students->count())],
                        ["title" => "Teachers","content" => round_number($school->teachers->count())],
                        ["title" => "Type","content" => ucfirst($school->school_type)],
                        ["title" => "Head Name","content" => $school->school_head]
                    ];
                @endphp
                <x-content-card
                    class="shadow hover:shadow-lg bg-slate-50 hover:bg-white"
                    title="{{ __($school->school_name) }}"
                    sub_title="{{ __($school->school_slug ?? 'No Slogan') }}"
                    item_id="{{ $school->id }}"
                    avatar_url="{{ asset('storage/'.$school->logo_path) }}"
                    removable="0"
                    editable="0"
                    :extras="$extras"
                    :content="$school->description"
                    view_text="Enter"
                    :card_link="route('school.menu', ['school_id' => $school->protected_id])"
                />
            @endforeach
        </x-content-grid>
    </x-app-main>
</x-app-layout>
