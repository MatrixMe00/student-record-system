<x-app-layout>
    <x-slot name="header">
        <x-app-header>My Accounts</x-app-header>
    </x-slot>

    @section("title", "My Accounts")

    <x-app-main class="py-4">
        @if($can_create)
            @if (auth()->user()->role_id == 1)
                <x-primary-button onclick="location.href='{{ route('banks.create') }}'" class="mb-3">{{ count($banks) > 0 ? "Update Banks" : "Add Banks" }}</x-primary-button>
            @endif

            <x-nav-tags :tags="$tags" />

            <x-session-component />

            <section class="mt-3 grid grid-cols-1 lg:grid-cols-2 gap-2 items-start">
                {{-- superadmins have no restrictions but admins should set up school account first --}}
                @if (!$admin || ($admin && $school_account))
                    <x-section-component title="Personal Account" class="h-fit">
                        @include("payment-accounts.partials._personal")
                    </x-section-component>
                @endif

                @if ($admin)
                    @if (session("school_result_price"))
                        <x-section-component title="School Account" class="h-fit">
                            @include("payment-accounts.partials._school")
                        </x-section-component>
                    @endif
                    <x-section-component title="Results Check Price" class="h-fit">
                        @include("payment-accounts.partials._school_price")
                    </x-section-component>
                @endif

                @if (!$admin)
                <section class="space-y-3">
                    <x-section-component title="System Account Price">
                        @include("payment-accounts.partials._system")
                    </x-section-component>

                    <x-section-component title="Admin Price Splits">
                        @include("payment-accounts.partials._admin_price_splits")
                    </x-section-component>
                </section>

                @endif
        </section>

        @else
            <x-empty-div>{{ __("You cannot add an account yet. Please check again another time") }}</x-empty-div>
        @endsession
    </x-app-main>
</x-app-layout>
