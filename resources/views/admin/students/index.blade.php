<x-app-layout>
    <x-slot name="header">
        <x-app-header>{{ $program->name." Students" }}</x-app-header>
    </x-slot>

    @section("title", "Class List")

    <x-app-main class="py-4">
        <x-section-component class="bg-gray-50">
            <div
                class="grid gap-3 md:gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4
                p-8 text-gray-700 rounded-lg -mt-2">
                @foreach ($students as $student)
                    <x-app-user-card :user="$student" />
                @endforeach
            </div>
        </x-section-component>
    </x-app-main>
</x-app-layout>
