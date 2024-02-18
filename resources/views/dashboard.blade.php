<x-app-layout>
    <x-slot name="header">
        <x-app-header>Dashboard</x-app-header>
    </x-slot>

    <div class="py-12">
        @switch(Auth::user()->role_id)
            @case(1)
            @case(2)
                @include("superadmin.dashboard")
                @break
            @case(4)
                @include("teacher.dashboard")
            @break
            @case(5)
                @include("student.dashboard")
                @break
            @default
                @include("admin.dashboard")
        @endswitch
    </div>
</x-app-layout>
