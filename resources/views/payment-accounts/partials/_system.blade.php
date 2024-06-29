@php
    $subtitle = "Use this form to set up the base price for the system. This is added to the amount the schools will be charging on the results (checking) section.";
@endphp

<x-form-container subtitle="{{ $subtitle }}" padding="" :showErrors="old('submit') == 'system_price'">
    <x-form-element method="POST" action="{{ is_null(session('base_price')) ? route('system-settings.store') : route('system-settings.update', ['key' => 'system_price']) }}">
        {{-- info type --}}
        <x-text-input type="hidden" name="type" value="individual" />

        @if (session('base_price') > 0)
            @method("PUT")
        @endif

        {{-- Current Price --}}
        <div>
            <x-input-label for="price" :value="__('Current Price (GHC)')" />
            <x-text-input id="price" :value="number_format(session('base_price'), 2)" readonly />
        </div>

        {{-- visual name, attribute name and role access --}}
        <x-text-input type="hidden" name="visual_name" value="System Price" />
        @if (is_null(session('base_price')))
            <x-text-input type="hidden" name="name" value="system_price" />
        @endif
        <x-text-input type="hidden" name="role_access" value="1-2-3" />

        {{-- New default value --}}
        <div>
            <x-input-label for="default_value" :value="__('New Price')" />
            <x-text-input id="default_value" name="default_value" placeholder="New Price to be created" :value="dual_old('system_price', 'default_value')" />
            <x-input-error :messages="dual_error('system_price', 'default_value', $errors)" />
        </div>

        <x-form-button-container>
            <x-form-submit-button icon="far fa-save" name="submit" value="system_price">Save</x-form-submit-button>
        </x-form-button-container>
    </x-form-element>
</x-form-container>
