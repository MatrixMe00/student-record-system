<x-guest-layout>
    {{-- page title --}}
    @section("title", $page_title)

    @section("logo")
        <a href="/">
            <x-application-logo icon="{{ $login_icon }}" class="w-20 h-20 fill-current text-gray-500" />
        </a>
    @endsection

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Page Heading -->
    <div class="w-full mb-6">
        <h1 class="text-3xl border-b-2 pb-1 px-2 w-fit m-auto font-semibold tracking-wider text-gray-800 capitalize dark:text-white">
            Welcome back
        </h1>
    </div>

    <form method="POST" action="{{ route('login') }}" class="w-full md:min-w-96 m-auto">
        @csrf

        <!-- Email Address -->
        <div>
            <?php $label = $role_id != 5 ? "Email / Username" : "Index Number" ?>
            <x-input-label for="username" :value="__($label)" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <x-text-input name="role_id" type="hidden" value="{{ $role_id }}" />
        <x-input-error :messages="$errors->get('role_id')" class="mt-2" />

        <!-- Remember Me -->
        <x-input-check name="remember" text="Remember Me" />

        <div class="flex flex-col items-center mt-4 gap-3">
            <x-primary-button class="ms-3 w-full py-4">
                {{ __('Log in') }}
            </x-primary-button>
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            @if ($role_id <= 3)
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('register') }}">
                    {{ __('Register Your School') }}
                </a>
            @endif

        </div>
    </form>
</x-guest-layout>
