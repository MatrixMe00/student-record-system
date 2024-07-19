<x-app-layout>
    <x-slot name="header">
        <x-app-header>Settings - {{ $school->school_name }}</x-app-header>
    </x-slot>

    @section("title", "My School")

    <x-app-main class="py-12">
        <x-session-component />

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" x-cloak="" x-data="{active:'{{ old('active_tab','settings') }}'}">
            <x-group-buttons-container>
                <x-group-button text="Settings" icon="fas fa-cog" @click="active='settings'" />
                <x-group-button text="Internal" icon="fas fa-cogs" @click="active='internal'" />

                @if ($school_admin)
                    @if (session('base_price'))
                        <x-group-button text="Payment" icon="fas fa-cash-register" @click="active='payment'" />
                    @endif

                    <x-group-button text="Delete School" icon="fas fa-trash" @click="active='delete'" />
                @endif
            </x-group-buttons-container>

            <x-section-component x-show="active=='internal'" title="Internal Settings"
                class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @include("admin.partials._internal")
            </x-section-component>

            <x-section-component title="School Settings" x-show="active=='settings'"
                class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @include("admin.partials._school_settings")
            </x-section-component>

            {{-- only admin who created school can delete the school --}}
            @if ($school_admin)
                @if (session("base_price"))
                    <x-section-component x-show="active=='payment'"
                        title="Update Results Price" class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @php
                                $accounts = school()->payment_information;
                                $personal_account = $accounts->where("type", "individual")->first();
                                $school_account = $accounts->where("type", "school")->first();
                                $add_internal = true;
                            @endphp
                            @include("payment-accounts.partials._school_price")
                        </div>
                    </x-section-component>
                @endif

                <x-section-component x-show="active=='delete'"
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('admin.partials._delete_school')
                    </div>
                </x-section-component>
            @endif
        </div>
    </x-app-main>
</x-app-layout>
