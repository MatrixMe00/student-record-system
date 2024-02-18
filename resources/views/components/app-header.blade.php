@props(["title"])

<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
    {{ __((string) ($title ?? $slot)) }}
</h2>
