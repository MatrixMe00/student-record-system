@props(['value'])

<label {{ $attributes->merge(['class' => 'block mb-2 text-sm text-gray-600 dark:text-gray-200']) }}>
    {{ $value ?? $slot }}
</label>
