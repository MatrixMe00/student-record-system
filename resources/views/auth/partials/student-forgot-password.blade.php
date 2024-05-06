<form method="POST" action="{{ route('password.student') }}" class="space-y-5">
    @csrf

    <!-- Index Number -->
    <div>
        <x-input-label for="username" :value="__('System Index Number / Username')" />
        <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus />
        <x-input-error :messages="$errors->get('username')" class="mt-2" />
    </div>

    <!-- New Password -->
    <div>
        <x-input-label for="password">{{ __("New Password") }}</x-input-label>
        <x-text-input name="password" type="password" id="password" :value="old('password')" required />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div>
        <x-input-label for="password_confirmation">{{ __("New Password") }}</x-input-label>
        <x-text-input name="password_confirmation" type="password" id="password_confirmation" :value="old('password_confirmation')" required />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-primary-button>
            {{ __('Reset my password') }}
        </x-primary-button>
    </div>
</form>
