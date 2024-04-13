<x-app-layout>
    <x-slot name="header">
        <x-app-header>BECE Menu</x-app-header>
    </x-slot>

    @section("title", "BECE Menu")

    <x-app-main>
        @switch($role_id)
            @case(3)
                @include("bece.partials.admin-index")
                @break
            @case(5)
                @include("bece.partials.student-index")
                @break
            @break
        @endswitch
    </x-app-main>
</x-app-layout>
