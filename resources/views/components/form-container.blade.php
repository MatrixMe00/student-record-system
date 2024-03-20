@props(["maintitle" => "", "subtitle" => ""])
<div class="flex items-center w-full p-8 mx-auto lg:px-12" x-data="{ selected_role:'{{ old('role_id') }}', email_val:'{{ old('email') }}' }" x-init="email_val='{{ old('email') }}'">
    <div class="w-full">
        <h1 class="text-2xl font-semibold tracking-wider text-gray-800 capitalize dark:text-white">
            @yield("main-title", $maintitle)
        </h1>

        <p class="mt-4 text-gray-500 dark:text-gray-400">
            @yield("sub-title", $subtitle)
        </p>

        @if ($errors->any())
            <x-input-error :messages="$errors->all()" />
        @endif

        {{ $slot }}
    </div>
</div>
