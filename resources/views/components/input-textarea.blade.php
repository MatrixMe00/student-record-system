@props(["value", "subtext" => null, "subtextIcon" => "fas fa-info-circle"])

<div>
<textarea
{!! $attributes->merge(['class' => 'w-full mt-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}>
    {{ $value ?? $slot }}
</textarea>
@if($subtext)
    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
        <i class="{{ $subtextIcon }} mr-1"></i>
        {{ $subtext }}
    </p>
@endif
</div>
