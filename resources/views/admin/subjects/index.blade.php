<x-app-layout>
    <x-slot name="header">
        <x-app-header>Your Subjects</x-app-header>
    </x-slot>

    @section("title", "Subjects")

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
            type="button">Add A Subject</x-primary-button>

        @if ($subjects->count() > 0)
            <x-content-grid class="mt-6">
                @foreach ($subjects as $subject)
                    @php
                        // $teacher = $program->teacher;
                        $extras = [
                            ["title" => "Classes Offering", "content" => $subject->programs->count()],
                            ["title" => "Teachers Teaching", "content" => $subject->teachers->count()]
                        ];
                    @endphp
                    <x-content-card
                        class="bg-white hover:bg-neutral-50"
                        title="{{ $subject->name }}" item_id="{{ $subject->id }}"
                        :sub_title="$subject->slug ?? 'No Slug name'"
                        path_head="subject" :extras="$extras" />
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
                @include("admin.subjects._add_subject")
            </x-modal>
        @endif
    </x-app-main>
</x-app-layout>
