@props(["title", "content"])

<div {{ $attributes->merge(["class"=>"px-4 py-6 sm:px-0"]) }}>
    <dt class="text-sm font-medium leading-6 text-gray-900 text-nowrap">{{ __($title) }}</dt>
    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ __($content) }}</dd>
</div>
