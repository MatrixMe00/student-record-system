@php
    $subtitle = "Use this form to fill out the charge of use services on the system. Students will pay the price displayed in the current price field";
@endphp

<x-form-container subtitle="{{ $subtitle }}" padding="" :showErrors="old('submit') == 'system_price'">
    <x-form-element method="POST"
        action="{{ route('school-payment.modify') }}"
        x-cloak="" x-data="{system_price: {{ session('base_price') }}, current_price:'{{ dual_old('system_price', 'value') ?? number_format(session('school_result_price'), 2) }}', total:'{{ number_format(session('base_price') + session('school_result_price'), 2) }}'}"
    >
        @if (session('school_result_price') > 0)
            @method("PUT")
        @endif

        @php
            $max_price = session('result_max_price') ?? 0;
        @endphp
        <x-info-card shadow="" class="sm:col-span-2 text-sm">System takes a base amount of <b>GH¢ {{ number_format(session('base_price'), 2) }}</b>, you can add up to a maximum of <b>GH¢ {{ number_format($max_price,2) }}</b></x-info-card>

        {{-- parse if it has a personal account --}}
        <x-text-input type="hidden" name="personal_account" value="{{ $personal_account?->account_id }}" />
        {{-- parse if it has a school account --}}
        <x-text-input type="hidden" name="school_account" value="{{ $school_account?->account_id }}" />
        {{-- split account id --}}
        <x-text-input type="hidden" name="split_id" value="{{ $personal_account?->split_id }}" />

        {{-- school id --}}
        <x-text-input type="hidden" name="school_id" value="{{ session('school_id') }}" />
        {{-- settings name --}}
        <x-text-input type="hidden" name="settings_name" value="system_price" />

        @if (isset($add_internal))
            <x-text-input name="active_tab" value="payment" type="hidden" />
        @endif

        {{-- Current Price --}}
        <div>
            <x-input-label for="price" :value="__('Current Price (GH¢)')" />
            <x-text-input id="price" x-model="total" readonly />
        </div>

        {{-- New default value --}}
        <div>
            <x-input-label for="value" :value="__('Your Price')" />
            <x-text-input type="number" step="0.01" max="{{ $max_price }}" min="0" id="value" name="value" placeholder="New Price to be added" x-model="current_price"
                @change="total=parseFloat(parseFloat(current_price)+parseFloat(system_price)).toFixed(2)"
                @blur="current_price=parseFloat(current_price).toFixed(2)"
            />
            <x-input-error :messages="dual_error('system_price', 'value', $errors)" />
        </div>

        <x-form-button-container x-show="{{ session('school_result_price') }} != current_price">
            <x-form-submit-button icon="far fa-save" name="submit" value="system_price">Save</x-form-submit-button>
        </x-form-button-container>
    </x-form-element>
</x-form-container>
