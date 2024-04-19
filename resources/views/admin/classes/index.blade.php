<x-app-layout>
    <x-slot name="header">
        <x-app-header>Your Classes</x-app-header>
    </x-slot>

    @section("title", "Classes")

    <x-app-main class="mt-4">
        {{-- show the success message after creation --}}
        <x-session-component />

        {{-- add a class --}}
        <x-primary-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'create_class')"
            type="button">Add A Class</x-primary-button>

        @if ($programs->count() < 9)
            <x-primary-button
                type="button"
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'create_multiple_class')"
                >{{ __("Add Default Classes") }}</x-primary-button>
        @endif

        {{-- promotion --}}
        <x-primary-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'promotion')"
            type="button"
        >{{ __("Promote Students") }}</x-primary-button>

        @if ($programs->count() > 0)
            <x-content-grid class="mt-6">
                @foreach ($programs as $program)
                    @php
                        $teacher = $program->teacher;
                        $teacher_name = !is_null($teacher) ? "{$teacher->lname} {$teacher->oname}" : "Not Set";

                        $extras = [
                            ["title" => "Student Count", "content" => $program->students->count()." students"],
                            ["title" => "Class Teacher", "content" => $teacher_name]
                        ];
                    @endphp
                    <x-content-card
                        class="bg-white hover:bg-neutral-50"
                        title="{{ $program->name }}" item_id="{{ $program->id }}"
                        :sub_title="$program->slug ?? 'No Slug name'"
                        path_head="class" :extras="$extras" />
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

            <x-modal name="promotion" :show="false">
                <form method="post" action="{{ route('students.promote') }}" class="p-6">
                    @csrf

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Are you sure you want to promote your students?') }}
                    </h2>

                    @php
                        $aca_year = get_academic_year(now());
                    @endphp

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {!! __('Once confirmed, all students who have been assigned new classes would automatically be promoted to that class for the stated academic year <b>\''.$aca_year.'\'</b>') !!}
                    </p>

                    <div class="mt-6">
                        <x-text-input
                            name="academic_year"
                            type="hidden"
                            class="mt-1 block w-3/4"
                            :value="$aca_year"
                            readonly
                            placeholder="{{ __('Academic Year') }}"
                        />

                        <x-input-error :messages="$errors->get('academic_year')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-primary-button class="ms-3">
                            {{ __('Proceed') }}
                        </x-primary-button>
                    </div>
                </form>
            </x-modal>

            @if ($programs->count() < 9)
                <x-modal name="create_multiple_class" :show="false">
                    <div class="grid items-center w-full p-8 mx-auto lg:px-12">
                        <p>This will create a set classes from primary 1 to JHS 3 for your school</p>
                        <form action="{{ route('add-multiple-program') }}" method="POST" class="mt-4">
                            @csrf
                            <x-primary-button class="bg-blue-600">Proceed</x-primary-button>
                        </form>
                    </div>
                </x-modal>
            @endif
        @endif
    </x-app-main>
</x-app-layout>
