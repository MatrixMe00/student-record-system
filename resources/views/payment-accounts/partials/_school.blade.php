@php
    $subtitle = "Information entered here is going to be used to auto-procure payment to the school account when a student makes payment for results or debts."
@endphp

<x-form-container subtitle="{{ $subtitle }}" padding="" :showErrors="old('submit') == 'school'">
    <x-form-element method="POST" action="{{ is_null($school_account) ? route('payment-account.store') : route('payment-account.update', ['paymentInformation' => $school_account?->id]) }}">
        @include("payment-accounts.partials._defaults")

        {{-- info type --}}
        <x-text-input type="hidden" name="type" value="school" />

        @if ($school_account)
            @method("PUT")

            {{-- account id --}}
            <div>
                <x-input-label for="account_id_s" :value="__('Account ID')" readonly />
                <x-text-input id="account_id_s" :value="$school_account->account_id" readonly />
            </div>
        @endif

        {{-- School Name --}}
        <div>
            <x-input-label for="school_name" :value="__('School Name')" />
            <x-text-input id="school_name" :value="$school->school_name" readonly />
        </div>

        {{-- Bank Code --}}
        <div>
            <x-input-label for="bank_code_s" :value="__('Select your account bank')" />
            <x-input-select :options="$banks" name="bank_code" value_key="code" :value="dual_old('school', 'bank_code') ?? $school_account?->bank_code" />
            <x-input-error :messages="dual_error('school', 'bank_code', $errors)" />
        </div>

        {{-- account number --}}
        <div>
            <x-input-label for="account_number_s" :value="__('Account Number')" />
            <x-text-input id="account_number_s" name="account_number" placeholder="Account number to the bank selected above." :value="dual_old('school', 'bank_code') ?? $school_account?->account_number" />
            <x-input-error :messages="dual_error('school', 'account_number', $errors)" />
        </div>

        <p class="bg-yellow-100 py-3 px-4 md:col-span-2 text-xs text-center" shadow="border">
            Please verify that the above provided information is valid before saving since we will not be liable for wrong information provided
        </p>

        <x-form-button-container>
            <x-form-submit-button icon="far fa-save" value="school" name="submit">Save</x-form-submit-button>
        </x-form-button-container>
    </x-form-element>
</x-form-container>
