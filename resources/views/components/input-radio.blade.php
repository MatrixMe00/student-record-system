@props(["name", "text"])

<div class="block mt-4">
    <label for="{{ $name }}" class="inline-flex items-center">
        <input id="{{ $name }}" type="radio" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="{{ $name }}">
        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __($text) }}</span>
    </label>
</div>
