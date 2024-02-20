<section class="bg-white dark:bg-gray-900 md:w-[80vw]">
    <div class="flex justify-center min-h-screen">
        <div class="hidden bg-cover lg:block lg:w-2/5" style="background-image: url('https://images.unsplash.com/photo-1494621930069-4fd4b2e24a11?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=715&q=80')">
        </div>

        <div class="flex items-center w-full max-w-3xl p-8 mx-auto lg:px-12 lg:w-3/5">
            <div class="w-full">
                <h1 class="text-2xl font-semibold tracking-wider text-gray-800 capitalize dark:text-white">
                    Create free account now.
                </h1>

                <p class="mt-4 text-gray-500 dark:text-gray-400">
                    Let’s get you all set up so you can verify your personal account and begin creating your school profile.
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

                    <x-text-input name="role_id" id="role_id" type="hidden" value="{{ $role_id }}" />
                    <x-text-input name="new_school" id="new_school" type="hidden" value="1" />

                    <button
                        class="flex items-center justify-between w-full px-6 py-3 text-sm
                            tracking-wide text-white capitalize group transform bg-blue-500 rounded-md
                            hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300
                            focus:ring-opacity-50">
                        <span>Create My Account</span>
                        <i class="fas fa-angle-right group-hover:mr-2 transition-all duration-500"></i>
                    </button>
                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('admin.login') }}">
                            {{ __('Already registered?') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
