@php
    $current_price = session("base_price");
    $dev_price = 0.1833 * $current_price;
    $system_price = 0.15 * $current_price;
    $superadmin_price = 0.25 * $current_price;
    $admin_price = 0.1667 * $current_price;
@endphp

<x-form-container padding="" :showErrors="false">
    <x-form-element @submit.prevent="true">
        <div class="sm:col-span-2">
            <p>Prices are calculated based on the current system price <b>{{ number_format(floatval($current_price),2) }}</b></p>
        </div>
        {{-- System price --}}
        <div>
            <x-input-label for="sys_price" :value="__('System [15%] (GHC)')" />
            <x-text-input id="sys_price" :value="number_format($system_price,2)" readonly />
        </div>

        {{-- Dev price --}}
        <div>
            <x-input-label for="d_price" :value="__('Developer [18.33%] (GHC)')" />
            <x-text-input id="d_price" :value="number_format($dev_price,2)" readonly />
        </div>

        {{-- Superadmin Price --}}
        <div>
            <x-input-label for="su_price" :value="__('Superadmin [25%] (GHC)')" />
            <x-text-input id="su_price" :value="number_format($superadmin_price,2)" readonly />
        </div>

        {{-- Admin Price --}}
        <div>
            <x-input-label for="a_price" :value="__('Admin Price [16.67%] (GHC)')" />
            <x-text-input id="a_price" :value="number_format($admin_price,2)" readonly />
        </div>
    </x-form-element>
</x-form-container>
