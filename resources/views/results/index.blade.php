<x-app-layout>
    <x-slot name="header">
        <x-app-header>Results</x-app-header>
    </x-slot>

    @section("title", "Results")

    <x-app-main class="mt-4">
        @switch($role_id)
            @case(3)
                @include('admin.results')
                @break
            @case(4)
                @include('teacher.results')
                @break
            @case(5)
                @include('student.results')
                @break

            @default
                <x-empty-div>{{ __("No Content to be displayed for you") }}</x-empty-div>
        @endswitch
    </x-app-main>
</x-app-layout>
