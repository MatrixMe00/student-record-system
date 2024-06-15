<x-app-layout>
    <x-slot name="header">
        <x-app-header>Payment Accounts</x-app-header>
    </x-slot>

    @section("title", "Payment Accounts")

    <x-app-main class="py-4">
        <x-nav-tags :tags="$tags" />

        @if ($accounts->count())
            <x-content-grid class="mt-4">
                @foreach ($accounts as $account)
                    <x-content-card
                        title="{{ $account->account_id }}"
                        sub_title="{{ payment_type($account->bank->type).' | '.$account->account_number }}"
                        :editable="false" :removable="false" item_id="{{ $account->id }}"
                        class="bg-white"
                    />
                @endforeach
            </x-content-grid>
        @else
            <x-empty-div>{{ __("No payment accounts have been created") }}</x-empty-div>
        @endif
    </x-app-main>
</x-app-layout>
