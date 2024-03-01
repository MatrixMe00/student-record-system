<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    @if ($errors->any())
        <x-input-error :messages="$errors->all()" />
    @endif

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            {{-- lname --}}
            <div>
                <x-input-label for="lname" :value="__('Lastname')" />
                <x-text-input id="lname" name="lname" type="text" class="mt-1 block w-full" :value="old('lname', $model->lname)" required autofocus autocomplete="lname" />
                <x-input-error class="mt-2" :messages="$errors->get('lname')" />
            </div>

            {{-- oname --}}
            <div>
                <x-input-label for="oname" :value="__('Othernames')" />
                <x-text-input id="oname" name="oname" type="text" class="mt-1 block w-full" :value="old('oname', $model->oname)" required autocomplete="oname" />
                <x-input-error class="mt-2" :messages="$errors->get('oname')" />
            </div>

            @if ($user->role_id != 5)
                {{-- email --}}
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                {{ __('Your email address is unverified.') }}

                                <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            @endif


            {{-- username --}}
            <div>
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('username')" />
            </div>

            {{-- primary phone --}}
            <div>
                <x-input-label for="primary_phone" :value="__('Primary Phone Number')" />
                <x-text-input id="primary_phone" name="primary_phone" type="text" class="mt-1 block w-full" :value="old('primary_phone', $model->primary_phone)" required autocomplete="primary_phone" />
                <x-input-error class="mt-2" :messages="$errors->get('primary_phone')" />
            </div>

            {{-- secondary phone --}}
            <div>
                <x-input-label for="secondary_phone" :value="__('Secondary Phone Number')" />
                <x-text-input id="secondary_phone" name="secondary_phone" type="text" class="mt-1 block w-full" :value="old('secondary_phone', $model->secondary_phone)" placeholder="[Optional]" autocomplete="secondary_phone" />
                <x-input-error class="mt-2" :messages="$errors->get('secondary_phone')" />
            </div>

            @if ($user->role_id == 5)
                {{-- next of kin --}}
                <div>
                    <x-input-label for="next_of_kin" :value="__('Next Of Kin')" />
                    <x-text-input id="next_of_kin" name="next_of_kin" type="text" class="mt-1 block w-full" :value="old('next_of_kin', $model->next_of_kin)" autocomplete="next_of_kin" />
                    <x-input-error class="mt-2" :messages="$errors->get('next_of_kin')" />
                </div>

                {{-- program of study --}}
                <div>
                    <x-input-label for="cur_username" :value="__('Current Class')" />
                    <x-text-input id="cur_username" type="text" class="mt-1 block w-full" :value="$model->program->name" readonly />
                    <x-input-error class="mt-2" :messages="$errors->get('program_id')" />
                </div>
            @endif
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Make Change') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
