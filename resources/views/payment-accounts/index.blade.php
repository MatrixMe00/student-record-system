<x-app-layout>
    <x-slot name="header">
        <x-app-header>Payment Accounts</x-app-header>
    </x-slot>

    @section("title", "Payment Accounts")

    <x-app-main class="py-4">
        <x-nav-tags :tags="$tags" />

        @if ($accounts->count())

        @else
            <x-empty-div>{{ __("No payment accounts have been created") }}</x-empty-div>
        @endif
    </x-app-main>
</x-app-layout>
