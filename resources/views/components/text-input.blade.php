@props(['disabled' => false, "readonly" => false, "oa" => [], "subtext" => null, "subtextIcon" => "fas fa-info-circle"])

<div>
    <input {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }} {{ $attributes->merge(['class' => 'block w-full px-5 py-3 mt-2 text-gray-700 placeholder-gray-400 border border-gray-200 rounded-md dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40', ...$oa]) }}>
    @if($subtext)
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            <i class="{{ $subtextIcon }} mr-1"></i>
            {{ $subtext }}
        </p>
    @endif
</div>
