@php
    $subtitle = "Information entered here is going to be used for to auto-procure payment to the account when a student makes result payment in your school.";
@endphp

<x-form-container subtitle="{{ $subtitle }}" padding="" :showErrors="old('submit') == 'personal'">
    <x-form-element method="POST" action="{{ is_null($personal_account) ? route('payment-account.store') : route('payment-account.update', ['paymentInformation' => $personal_account?->id]) }}">
        @include("payment-accounts.partials._defaults")

        {{-- info type --}}
        <x-text-input type="hidden" name="type" value="individual" />

        @if ($personal_account)
            @method("PUT")

            {{-- account id --}}
            <div>
                <x-input-label for="account_id_p" :value="__('Account ID')" readonly />
                <x-text-input id="account_id_p" :value="$personal_account->account_id" readonly />
            </div>
        @endif

        {{-- Fullname --}}
        <div>
            <x-input-label for="fullname" :value="__('Full Name')" />
            <x-text-input id="fullname" :value="$user->fullname" readonly />
        </div>

        {{-- Bank Code --}}
        <div>
            <x-input-label for="bank_code" :value="__('Select your account bank')" />
            <x-input-select :options="$banks" name="bank_code" value_key="code" :value="dual_old('personal', 'bank_code') ?? $personal_account?->bank_code" />
            <x-input-error :messages="dual_error('personal', 'bank_code', $errors)" />
        </div>

        {{-- account number --}}
        <div>
            <x-input-label for="account_number" :value="__('Account Number')" />
            <x-text-input id="account_number" name="account_number" placeholder="Account number to the bank selected above." :value="dual_old('personal', 'account_number') ?? $personal_account?->account_number" />
            <x-input-error :messages="dual_error('personal', 'account_number', $errors)" />
        </div>

        <p class="bg-yellow-100 py-3 px-4 md:col-span-2 text-xs text-center" shadow="border">
            Please verify that the above provided information is valid before saving since we will not be liable for wrong information provided
        </p>

        <x-form-button-container>
            <x-form-submit-button icon="far fa-save" name="submit" value="personal">Save</x-form-submit-button>
        </x-form-button-container>
    </x-form-element>
</x-form-container>
