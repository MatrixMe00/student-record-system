<x-app-layout>
    <x-slot name="header">
        <x-app-header>Payment Accounts</x-app-header>
    </x-slot>

    @section("title", "Payment Accounts")

    <x-app-main class="py-4">
        <x-nav-tags :tags="$tags" />

        @if ($accounts->count())
            <x-content-grid class="mt-4">
                @php
                    $user_id = auth()->user()->id;
                @endphp
                @foreach ($accounts as $account)
                    @php
                        $extras= [
                            ["title" => "Type", "content" => ucfirst($account->type)],
                            ["title" => "Owner", "content" => $account->account_name],
                        ];

                        if($account->master){
                            $extras[] = ["title" => "Master Account", "content" => "Yes"];
                        }

                        $current_account = $account->user_id == $user_id && $account->type == "individual";
                    @endphp
                    <x-content-card
                        title="{{ $account->account_id }}"
                        sub_title="{{ payment_type($account->bank->type).' | '.$account->account_number }}"
                        :editable="false" :removable="false" item_id="{{ $account->id }}"
                        :extras="$extras"
                        class="{{ $current_account ? 'bg-neutral-50 border border-blue-400' : 'bg-white' }}"
                    />
                @endforeach
            </x-content-grid>
        @else
            <x-empty-div>{{ __("No payment accounts have been created") }}</x-empty-div>
        @endif
    </x-app-main>
</x-app-layout>
