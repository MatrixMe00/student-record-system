<x-app-layout>
    <x-slot name="header">
        <x-app-header>School History Menu</x-app-header>
    </x-slot>

    @section("title", "School History Menu")

    <x-app-main class="pt-3 pb-4">
        {{-- admin menu tags --}}
        @include("history.partials._admin-menu")

        {{-- menu --}}
        <x-section-component title="Menu Items">
            <div class="mt-2 text-6 flex flex-wrap gap-2">
                <x-school-menu-card
                    icon="fas fa-poll"
                    message="Exam Results"
                    item_url="{{ route('history.results') }}"
                />
                <x-school-menu-card
                    icon="fas fa-book"
                    message="Subject Records"
                    item_url="{{ route('history.subjects') }}"
                />
            </div>

        </x-section-component>
    </x-app-main>
</x-app-layout>
