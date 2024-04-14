@props(["maintitle" => "", "subtitle" => "", "padding" => "p-8 lg:px-12", "showErrors" => true])
<div {{ $attributes->merge(["class"=>"flex items-center w-full $padding mx-auto"]) }}>
    <div class="w-full">
        <h1 class="text-2xl font-semibold tracking-wider text-gray-800 capitalize dark:text-white">
            @yield("main-title", $maintitle)
        </h1>

        <p class="mt-4 text-gray-500 dark:text-gray-400">
            @yield("sub-title", $subtitle)
        </p>

        @if ($errors->any() && $showErrors)
            <x-input-error :messages="$errors->all()" />
        @endif

        {{ $slot }}
    </div>
</div>
