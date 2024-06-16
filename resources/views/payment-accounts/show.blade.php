<x-app-layout>
    <x-slot name="header">
        <x-app-header>My Accounts</x-app-header>
    </x-slot>

    @section("title", "My Accounts")

    <x-app-main class="py-4">
        @if(session("payment_is_ready"))
            @if (auth()->user()->role_id == 1)
                <x-primary-button onclick="location.href='{{ route('banks.create') }}'" class="mb-3">{{ count($banks) > 0 ? "Update Banks" : "Add Banks" }}</x-primary-button>
            @endif

            <x-nav-tags :tags="$tags" />
            @php
                $class = $admin ? "grid grid-cols-1 lg:grid-cols-2 gap-2 items-start" : "";
            @endphp

            <x-session-component />

            <section class="mt-3 {{ $class }}">
                <x-section-component title="Personal Account" class="h-fit">
                    @include("payment-accounts.partials._personal")
                </x-section-component>

                @if ($admin)
                    <x-section-component title="School Account" class="h-fit">
                        @include("payment-accounts.partials._school")
                    </x-section-component>
                @endif
        </section>

        @else
            <x-empty-div>{{ __("You cannot add an account yet. Please check again another time") }}</x-empty-div>
        @endsession
    </x-app-main>
</x-app-layout>
