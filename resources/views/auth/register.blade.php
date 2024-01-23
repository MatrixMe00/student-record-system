<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Last Name -->
        <div>
            <x-input-label for="lname" :value="__('Lastname')" />
            <x-text-input id="lname" class="block mt-1 w-full" type="text" name="lname" :value="old('lname')" required autofocus autocomplete="lname" />
            <x-input-error :messages="$errors->get('lname')" class="mt-2" />
        </div>

        <!-- Other Names -->
        <div class="mt-4">
            <x-input-label for="oname" :value="__('Othername(s)')" />
            <x-text-input id="oname" class="block mt-1 w-full" type="text" name="oname" :value="old('oname')" required autofocus autocomplete="oname" />
            <x-input-error :messages="$errors->get('oname')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="mt-4">
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- User Roles -->
        <div class="mt-4">
            <x-input-label for="role_id" :value="__('User Role')" />
            <x-input-select name="role_id" default="Select a role" :value="old('role_id')" :options="$roles" required />
            <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
        </div>

        <!-- Primary Phone number -->
        <div class="mt-4">
            <x-input-label for="primary_phone" :value="__('Primary Phone Number')" />
            <x-text-input id="primary_phone" class="block mt-1 w-full" type="text" name="primary_phone" :value="old('primary_phone')" required autocomplete="primary_phone" />
            <x-input-error :messages="$errors->get('primary_phone')" class="mt-2" />
        </div>

        <!-- Secondary Phone Number -->
        <div class="mt-4">
            <x-input-label for="secondary_phone" :value="__('Secondary Phone Number [Optional]')" />
            <x-text-input id="secondary_phone" class="block mt-1 w-full" type="text" name="secondary_phone" :value="old('secondary_phone')" />
            <x-input-error :messages="$errors->get('secondary_phone')" class="mt-2" />
        </div>

        <!-- User School -->
        <div class="mt-4">
            <x-input-label for="school_id" :value="__('User Role')" />
            <x-input-select name="school_id" default="Select a School" :value="old('school_id')" :options="$schools" required />
            <x-input-error :messages="$errors->get('school_id')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
