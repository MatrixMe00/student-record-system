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
                <div>
                    @if (!$active_payment)
                        <x-primary-button onclick="location.href='payment/create/results'">
                            Make Payment
                        </x-primary-button>
                    @else
                        <x-primary-button disabled class="bg-gray-600 hover:bg-gray-600 active:bg-gray-600">
                            Payment up to date
                        </x-primary-button>
                    @endif

                    <x-primary-button
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'payments')"
                        type="button">
                        {{ __("My Payments") }}
                    </x-primary-button>

                    <x-modal name="payments" :show="false">
                        @include("payments.payments-table")
                    </x-modal>
                </div>

                <x-session-component />

                @include('student.results')
                @break

            @default
                <x-empty-div>{{ __("No Content to be displayed for you") }}</x-empty-div>
        @endswitch
    </x-app-main>
</x-app-layout>
