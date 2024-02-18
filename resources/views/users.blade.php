<x-app-layout>
    <x-slot name="header">
        <x-app-header>Users</x-app-header>
    </x-slot>

    <x-app-main>
        <section class="mt-4 ml-6">
            <x-primary-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'create_user')"
                type="button">
                {{ __("Add New User") }}
            </x-primary-button>
        </section>
        <x-app-tab :tabs="array_keys($options)">
            @foreach ($options as $content_id => $option)
            @if ($option->count() > 0)
                <div id="{{ $content_id }}"
                    class="bg-gray-50 shadow border border-gray-100 p-8 text-gray-700 rounded-lg -mt-2"
                    x-show="contentBox=='{{ $content_id }}'">
                    @foreach ($option as $user)
                        <x-app-user-card :user="$user" />
                    @endforeach
                </div>
            @else
                <div id="{{ $content_id }}"
                    class="bg-gray-50 shadow border border-gray-100 p-8 text-gray-700 rounded-lg -mt-2"
                    x-show="contentBox=='{{ $content_id }}'">
                    <p class="text-center">No user found</p>
                </div>
            @endif

            @endforeach
        </x-app-tab>

        {{-- modal for new user --}}
        <x-modal name="create_user">
            <div class="flex items-center w-full max-w-3xl p-8 mx-auto lg:px-12 lg:w-3/5">
                <div class="w-full">
                    <h1 class="text-2xl font-semibold tracking-wider text-gray-800 capitalize dark:text-white">
                        Add A New User
                    </h1>

                    <p class="mt-4 text-gray-500 dark:text-gray-400">
                        Fill the form below to add a new user
                    </p>

                    <form class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2 border p-4" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div>
                            <x-input-label for="lname" :value="__('Last Name')" />
                            <x-text-input id="lname" type="text" name="lname" :value="old('lname')" placeholder="Doe" autofocus required />
                            <x-input-error :messages="$errors->get('lname')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="oname" :value="__('Other Name(s)')" />
                            <x-text-input id="oname" type="text" name="oname" :value="old('oname')" placeholder="John" required />
                            <x-input-error :messages="$errors->get('oname')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" type="email" name="email" :value="old('email')" placeholder="example@email.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="username" :value="__('Username')" />
                            <x-text-input id="username" type="text" name="username" :value="old('username')" placeholder="jondoe" required />
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" type="password" name="password" :value="old('password')" placeholder="Password" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" type="password" name="password_confirmation" :value="old('password_confirmation')" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="primary_phone" :value="__('Primary Phone Number')" />
                            <x-text-input id="primary_phone" type="tel" name="primary_phone" :value="old('primary_phone')" placeholder="XXX XXX XXXX" maxlength="13" minlength="10" required />
                            <x-input-error :messages="$errors->get('primary_phone')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="secondary_phone" :value="__('Secondary Phone Number')" />
                            <x-text-input id="secondary_phone" type="tel" name="secondary_phone" :value="old('secondary_phone')" placeholder="XXX XXX XXXX" maxlength="13" minlength="10" />
                            <x-input-error :messages="$errors->get('secondary_phone')" class="mt-2" />
                        </div>

                        <x-text-input name="role_id" id="role_id" type="hidden" value="" />

                        <button
                            class="flex items-center justify-between w-full px-6 py-3 text-sm
                                tracking-wide text-white capitalize group transform bg-blue-500 rounded-md
                                hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300
                                focus:ring-opacity-50">
                            <span>Create User Account</span>
                            <i class="fas fa-angle-right group-hover:mr-2 transition-all duration-500"></i>
                        </button>
                    </form>
                </div>
            </div>
        </x-modal>
    </x-app-main>
</x-app-layout>
