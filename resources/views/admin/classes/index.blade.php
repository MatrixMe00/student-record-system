<x-app-layout>
    <x-slot name="header">
        <x-app-header>Your Classes</x-app-header>
    </x-slot>

    @section("title", "Classes")

    <x-app-main class="mt-4">
        {{-- show the success message after creation --}}
        @session('success')
            <x-session-message class="mb-2">
                {{ __(session('message')) }}
            </x-session-message>
        @endsession

        {{-- add a class --}}
        <x-primary-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'create_class')"
            type="button">Add A Class</x-primary-button>

        @if ($programs->count() > 0)
            <x-content-grid class="mt-6">
                @foreach ($programs as $program)
                    @php
                        $teacher = $program->teacher;
                        $extras = [
                            ["title" => "Student Count", "content" => $program->students->count()." students"],
                            ["title" => "Class Teacher", "content" => ($teacher->lname." ".$teacher->oname) ?? "Not set"]
                        ];
                    @endphp
                    <x-content-card class="bg-white hover:bg-neutral-50" title="{{ $program->name }}" item_id="{{ $program->id }}" :sub_title="$program->slug ?? 'No Slug name'" :extras="$extras" />
                @endforeach
            </x-content-grid>
        @else
            <x-empty-div>
                There is no content to display
            </x-empty-div>
        @endif

        {{-- modal for new class program --}}
        @if (auth()->user()->role_id <= 3)
            <x-modal name="create_class" :show="$errors->any()">
                @include("admin.classes._add_class")
            </x-modal>
        @endif
    </x-app-main>
</x-app-layout>
