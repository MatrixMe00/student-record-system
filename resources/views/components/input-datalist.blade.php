@props(["options", "value_key" => "name"])

@php
    $data_key = "list_".rand(1,999);
@endphp

<x-text-input type="text" list="{{ $data_key }}" {{ $attributes->merge([]) }} />

<datalist id="{{ $data_key }}">
    @foreach ($options as $option)
        <option value="{{ $option[$value_key] }}">
    @endforeach
</datalist>
